import axios from 'axios';

import actions from './core/actions';
import mutations from './core/mutations';

export const Accountability = {
    namespaced: true,
    state: {
        documents: [],
        document: {},        
        cashes: [],
        employees: [],
        url: '/api/accountabilities',
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
        cashes:             state   =>  state.cashes,
        employees:          state   =>  state.employees
    },
    mutations: {
        ...mutations       
    },
    actions: {
        ...actions,        
        getCashesDictionary({dispatch, state}) {
            dispatch('getDictionary',  'cash')
                .then(res => state.cashes = res);
        },
        getEmployeesDictionary({dispatch, state}) {
            dispatch('getDictionary', 'employee?fields=id,surname,name,patronymic')
                .then(res => {
                    state.employees = [];
                    let empl = {};
                    res.forEach(employee => {                        
                        empl.id = employee.id;
                        empl.fullName = employee.surname + ' ' + employee.name.substring(0,1) + '.' + employee.patronymic.substring(0,1) + '.';
                        state.employees.push(empl);
                        empl = {};
                    });
                });
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