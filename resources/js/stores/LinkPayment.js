import axios from 'axios';

import actions from './core/actions';

// const documentItemsUrl = '/api/document-items';

export const LinkPayment = {
    namespaced: true,
    state: {
        documents: [],
        payments: [],
        branches: [],
        suppliers: [],
        cashes: [],
        // url: '/api/income-documents',        
    },
    getters: {
        documents:      state   =>  state.documents,
        payments:       state   =>  state.payments,
        branches:       state   =>  state.branches,
        suppliers:      state   =>  state.suppliers,
        cashes:         state   =>  state.cashes
    },
    mutations: {
        // ...mutations,       
    },
    actions: {
        // ...actions,
        getUnpaidDocuments: ({state}, payload) => {
            axios
                .get(`/api/get-unpaid-documents?branch_id=${payload.branchId}&date_begin=${payload.dateBegin}`, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }   
                    }
                )
                .then(res => {
                    state.documents = res.data.data
                });
                //.catch(err => reject(err));
        },
        getUnlinkedPayments: ({state}, payload) => {
            axios
                .get(`/api/get-unlinked-payments?cash_id=${payload.cashId}&date_begin=${payload.dateBegin}`, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }   
                    }
                )
                .then(res => {
                    state.payments = res.data.data
                });
                //.catch(err => reject(err));
        },
        getBranchesDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'branch')
                .then(res => state.branches = res);
        },
        getSuppliersDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'supplier')
                .then(res => state.suppliers = res);
        },
        getCashesDictionary({dispatch, state}) {
            dispatch('getDictionary', 'cash')
                .then(res => state.cashes = res);
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