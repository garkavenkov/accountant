import axios from 'axios';

import actions from './core/actions';
import mutations from './core/mutations';

// const url = '/api/sales-revenues';

export const SalesRevenue = {
    namespaced: true,
    state: {
        documents: [],
        temp: [],
        document: {},
        cashes: [],
        departments: [],
        url: '/api/sales-revenues',
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
        documents:      state   =>  state.documents,
        document:       state   =>  state.document,
        filter:         state   =>  state.filter,
        cashes:         state   =>  state.cashes,
        departments:    state   =>  state.departments
    },
    mutations: {
        ...mutations       
    },
    actions: {
        ...actions,       
        searchData: ({state}, search)  => {
            let searched = [];
            if (search !== '') {
                searched =  state.documents.filter(data => {
                    if (data['department'].toLowerCase().includes(search) ) {
                        return true
                    } else {
                        state.temp.push(data);
                    }

                });                
                state.documents = searched;
                // state.temp = state.documents.filter(data => {

                // });

            } else {
                state.documents = state.documents.concat(state.temp);
                state.temp = [];
            }
            
            console.log(searched, state.temp);
            // state.documents = searched;
        },
        getCashesDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'cash')
                .then(res => state.cashes = res);
        },
        getDepartmentsDictionary: ({dispatch, state}, cashId) => {
            let dictionary = 'department?type=goods';
            if (cashId != 0) {
                dictionary += '&branch_id=' + cashId;
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