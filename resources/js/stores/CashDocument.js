import axios from 'axios';

import actions from './core/actions';
import mutations from './core/mutations';

// const url = '/api/cash-documents';

export const CashDocument = {
    namespaced: true,
    state: {
        documents: [],
        document: {},
        types: [],
        // cashes: [],
        // departments: [],
        url: '/api/cash-documents',
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            operationId     :   0,
            creditId        :   0,
            debetId         :   0,
            sumBegin        :   0,
            sumEnd          :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        documents:      state   =>  state.documents,
        document:       state   =>  state.document,
        filter:         state   =>  state.filter,
        types:          state   =>  state.types,
        // cashes:         state   =>  state.cashes,
        // departments:    state   =>  state.departments
    },
    mutations: {
        ...mutations,        
    },
    actions: {
        ...actions,
        // updateDocument: ({dispatch, state}, payload) => {
        //     return new Promise((resolve, reject) => {
        //         axios.patch(`${url}/${state.document.id}`,  payload,
        //                     {
        //                         'headers': {
        //                             'Authorization': 'Bearer ' + window.api_token,
        //                             'Accept': 'application/json',
        //                         } 
        //                     }
        //                 )
        //                 .then(res => {
        //                     dispatch('fetchDocument', state.document.id);
        //                     resolve(res);
        //                 })
        //                 .catch(err => reject(err));
        //     });
        // },
        // fetchDocumentItem: ({state}, id) => {
        //     return new Promise((resolve, reject) => {
        //         let page_url = `${documentItemsUrl}/${id}`;
        //         axios
        //             .get(page_url,
        //                 {
        //                     'headers': {
        //                         'Authorization': 'Bearer ' + window.api_token,
        //                         'Accept': 'application/json',
        //                     }            
        //                 }
        //             )        
        //             .then(res => {
        //                 // console.log(res);
        //                 // console.log(res.data);
        //                 // console.log(res.data.data);
        //                 resolve(res.data.data);
                        
        //                 // state.document = res.data.data;
        //             })
        //             .catch(err => reject(err));
        //     })            
        // },
        // saveDocumentItem: ({dispatch}, payload) => {
        //     return new Promise((resolve, reject) => {
        //         axios.post(documentItemsUrl, payload,  
        //                     {
        //                         'headers': {
        //                             'Authorization': 'Bearer ' + window.api_token,
        //                             'Accept': 'application/json',
        //                         } 
        //                     }
        //                 )
        //                 .then(res => {
        //                     if (res.status == 201) {
        //                         dispatch('fetchDocument', payload.document_id);
        //                         resolve(res);
        //                     }
        //                 })
        //                 .catch(err => reject(err));
        //     })            
        // },
        // updateDocumentItem: ({dispatch}, payload) => {
        //     return new Promise((resolve, reject) => {
        //         axios.patch(`${documentItemsUrl}/${payload.id}`,  payload,
        //                     {
        //                         'headers': {
        //                             'Authorization': 'Bearer ' + window.api_token,
        //                             'Accept': 'application/json',
        //                         } 
        //                     }
        //                 )
        //                 .then(res => {
        //                     dispatch('fetchDocument', payload.document_id);
        //                     resolve(res);
        //                 })
        //                 .catch(err => reject(err));
        //     });
        // },
        // deleteDocumentItem: ({dispatch, state}, id) => {
        //     return new Promise((resolve, reject) => {
        //         axios
        //             .delete(`${documentItemsUrl}/${id}`,
        //                 {
        //                     'headers': {
        //                         'Authorization': 'Bearer ' + window.api_token,
        //                         'Accept': 'application/json',
        //                     } 
        //                 }
        //             )
        //             .then(res => {
        //                 dispatch('fetchDocument', state.document.id);
        //                 resolve(res)
        //             })
        //             .catch(err => reject(err))
        //         });
        // },
        applyFilter: ({commit, dispatch}, payload) => {
            commit('filterDocuments', payload);
            dispatch('fetchData');
        },
        getOperationTypeDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'CashOperation')
                .then(res => state.types = res);
        },
        // getDepartmentsDictionary({dispatch, state}, cashId) {
        //     let dictionary = 'department';
        //     if (cashId != 0) {
        //         dictionary = 'department?branch_id=' + cashId;
        //     }
        //     dispatch('getDictionary', dictionary)
        //         .then(res => state.departments = res);
        // },      
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