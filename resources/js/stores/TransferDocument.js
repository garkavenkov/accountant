import axios from 'axios';

import actions from './core/actions';
import mutations from './core/mutations';

// const url = '/api/income-documents';
const documentItemsUrl = '/api/document-items';

export const TransferDocuments = {
    namespaced: true,
    state: {
        documents: [],
        document: {
            items: []
        },
        url: '/api/transfer-documents',
        // documentItemsUrl: '/api/document-items',
        // suppliers: [],
        departmentsGive: [],
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            debetId         :   0,
            creditId        :   0,
            sum1Begin       :   0,
            sum1End         :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        documents:          state   =>  state.documents,
        document:           state   =>  state.document,
        filter:             state   =>  state.filter,
        // suppliers:      state   =>  state.suppliers,
        departmentsGive:    state   =>  state.departmentsGive
    },
    mutations: {
        ...mutations,       
    },
    actions: {
        ...actions,
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
                        resolve(res.data.data);
                    })
                    .catch(err => reject(err));
            })            
        },
        saveDocumentItem: ({state, dispatch}, payload) => {
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
        getDepartmentsDictionary({dispatch, state}) {
            dispatch('getDictionary', 'department')
                .then(res => state.departmentsGive = res);
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