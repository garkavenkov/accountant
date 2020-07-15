import axios from 'axios';
import { reject } from 'lodash';

const url = '/api/income-documents';
const documentItemsUrl = '/api/document-items';

export const IncomeDocuments = {
    namespaced: true,
    state: {
        documents: [],
        document: {
            items: []
        },
        suppliers: [],
        departments: [],
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            supplierId      :   0,
            departmentId    :   0,
            sum1Begin       :   0,
            sum1End         :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        documents:      state   =>  state.documents,
        document:       state   =>  state.document,
        filter:         state   =>  state.filter,
        suppliers:      state   =>  state.suppliers,
        departments:    state   =>  state.departments
    },
    mutations: {
        filterDocuments: (state, payload) => {
            state.filter.queryStr = '';

            if (state.filter.dateBegin) {
                state.filter.queryStr = state.filter.queryStr + `date=${payload.dateBegin}`;
                state.filter.isFiltered = true;
            }

            if (state.filter.dateEnd) {
                state.filter.queryStr = state.filter.queryStr + `,${payload.dateEnd}`;
                state.filter.isFiltered = true;
            }

            if (state.filter.supplierId > 0) {
                state.filter.queryStr = state.filter.queryStr + `&debit_id=${payload.supplierId}`;
                state.filter.isFiltered = true;
            }            

            if (state.filter.departmentId > 0) {
                state.filter.queryStr = state.filter.queryStr + `&credit_id=${payload.departmentId}`;
                state.filter.isFiltered = true;
            }
        }
    },
    actions: {
        fetchData: ({state}) => {   
            //  use Promise ???
            let page_url = state.filter.isFiltered ? (url + '?' + state.filter.queryStr) : url;
            axios
                .get(page_url,
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => {
                    state.documents = res.data.data;
                    // this.makePagination(res.data.links, res.data.meta);
                })
                .catch(err => console.log(err));
                
        },
        fetchDocument: ({state}, id) => {
            let page_url = `${url}/${id}`;
            axios
                .get(page_url,
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }            
                    }
                )        
                .then(res => {
                    state.document = res.data.data;
                })
                .catch(err => console.log(err));
        },
        saveDocument: ({dispatch}, payload) => {
            return new Promise((resolve, reject) => {
                axios.post(url, payload,  
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => {
                    if (res.status == 201) {
                        dispatch('fetchData');
                        resolve(res);
                    }
                })
                .catch(err => reject(err));
            })            
        },
        deleteDocument: ({dispatch}, id) => {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`${url}/${id}`,
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => {
                        dispatch('fetchData');
                        resolve(res)
                    })
                    .catch(err => reject(err))
                });
        },
        updateDocument: ({dispatch, state}, payload) => {
            return new Promise((resolve, reject) => {
                axios.patch(`${url}/${state.document.id}`,  payload,
                            {
                                'headers': {
                                    'Authorization': 'Bearer ' + window.api_token,
                                    'Accept': 'application/json',
                                } 
                            }
                        )
                        .then(res => {
                            dispatch('fetchDocument', state.document.id);
                            resolve(res);
                        })
                        .catch(err => reject(err));
            });
        },
        fetchDocumentItem: ({state}, id) => {
            return new Promise((resolve, reject) => {
                let page_url = `${documentItemsUrl}/${id}`;
                axios
                    .get(page_url,
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            }            
                        }
                    )        
                    .then(res => {
                        // console.log(res);
                        // console.log(res.data);
                        // console.log(res.data.data);
                        resolve(res.data.data);
                        
                        // state.document = res.data.data;
                    })
                    .catch(err => reject(err));
            })            
        },
        saveDocumentItem: ({dispatch}, payload) => {
            return new Promise((resolve, reject) => {
                axios.post(documentItemsUrl, payload,  
                            {
                                'headers': {
                                    'Authorization': 'Bearer ' + window.api_token,
                                    'Accept': 'application/json',
                                } 
                            }
                        )
                        .then(res => {
                            if (res.status == 201) {
                                dispatch('fetchDocument', payload.document_id);
                                resolve(res);
                            }
                        })
                        .catch(err => reject(err));
            })            
        },
        updateDocumentItem: ({dispatch}, payload) => {
            return new Promise((resolve, reject) => {
                axios.patch(`${documentItemsUrl}/${payload.id}`,  payload,
                            {
                                'headers': {
                                    'Authorization': 'Bearer ' + window.api_token,
                                    'Accept': 'application/json',
                                } 
                            }
                        )
                        .then(res => {
                            dispatch('fetchDocument', payload.document_id);
                            resolve(res);
                        })
                        .catch(err => reject(err));
            });
        },
        deleteDocumentItem: ({dispatch, state}, id) => {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`${documentItemsUrl}/${id}`,
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => {
                        dispatch('fetchDocument', state.document.id);
                        resolve(res)
                    })
                    .catch(err => reject(err))
                });
        },
        applyFilter: ({commit, dispatch}, payload) => {
            commit('filterDocuments', payload);
            dispatch('fetchData');
        },
        getSuppliersDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'supplier')
                .then(res => state.suppliers = res);
        },
        getDepartmentsDictionary({dispatch, state}) {
            dispatch('getDictionary', 'department')
                .then(res => state.departments = res);
        },      
        getDictionary: (context, dictionary) => {            
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/select-dictionary/${dictionary}`, 
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => resolve(res.data))
                    .catch(err => reject(err));
            })          
        },
    }
}