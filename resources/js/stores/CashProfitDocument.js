import axios from 'axios';

import actions from './core/actions';
import mutations from './core/mutations';

export const CashProfitDocument = {
    namespaced: true,
    state: {
        documents: [],
        document: {},
        cashes: [],
        expenses: [],
        url: '/api/cash-profit-documents',
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
        profits:        state   =>  state.profits,
        cashes:         state   =>  state.cashes,
    },
    mutations: {
        ...mutations,        
    },
    actions: {
        ...actions,
        applyFilter: ({commit, dispatch}, payload) => {
            commit('filterDocuments', payload);
            dispatch('fetchData');
        },
        // getExpensesDictionary: ({dispatch, state}) => {
        //     dispatch('getDictionary',  'ExpenseItem')
        //         .then(res => state.expense = res);
        // },
        getCashesDictionary({dispatch, state}) {
            dispatch('getDictionary', 'Cash')
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