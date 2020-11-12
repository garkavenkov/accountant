import axios from 'axios';

import actions from './core/actions';
import mutations from './core/mutations';

// const url = '/api/sales-revenues';

export const Payment = {
    namespaced: true,
    state: {
        documents: [],
        document: {},
        unpaidDocuments: [],
        // cashes: [],
        // departments: [],
        url: '/api/payments',
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            creditId        :   0,
            debetId         :   0,
            sumBegin        :   0,
            sumEnd          :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        documents:          state   =>  state.documents,
        document:           state   =>  state.document,
        filter:             state   =>  state.filter,
        unpaidDocuments:    state   =>  state.unpaidDocuments,
        // cashes:         state   =>  state.cashes,
        // departments:    state   =>  state.departments
    },
    mutations: {
        ...mutations       
    },
    actions: {
        ...actions,
        getUnpaidDocuments({state},{supplierId}) {
            // console.log(supplierId);
            let url = `api/unpaid-documents/${supplierId}`;
            return new Promise((resolve, reject) => {
                axios
                    .get(url, {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => resolve(res))
                    .catch(err => reject(err))
            });
            // axios.get(url, {
            //     'headers': {
            //         'Authorization': 'Bearer ' + window.api_token,
            //         'Accept': 'application/json',
            //     }
            // })
            //     .then(res => state.unpaidDocuments = res.data)
            //     .catch(err => res.errors);
        },
        getCashesDictionary({dispatch, state}) {
            dispatch('getDictionary',  'cash')
                .then(res => state.cashes = res);
        },
        getDepartmentsDictionary({dispatch, state}, cashId) {
            let dictionary = 'department';
            if (cashId != 0) {
                dictionary = 'department?branch_id=' + cashId;
            }
            dispatch('getDictionary', dictionary)
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