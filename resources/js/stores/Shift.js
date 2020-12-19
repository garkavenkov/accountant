import axios from 'axios';

import actions from './core/actions';
import mutations from './core/mutations';

// const url = '/api/sales-revenues';

export const Shift = {
    namespaced: true,
    state: {
        documents: [],
        document: {},
        departments: [],
        employees: [],
        url: '/api/shifts',
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            departmentId    :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        shifts      :   state   =>  state.documents,
        shift       :   state   =>  state.document,
        filter      :   state   =>  state.filter,
        departments :   state   =>  state.departments,
        employees   :   state   =>  state.employees
    },
    mutations: {
        ...mutations       
    },
    actions: {
        ...actions,       
        getDepartmentsDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'departments?type=goods')
                .then(res => state.departments = res);
        },
        addEmployeeIntoShift: ({dispatch}, payload) => {
            return new Promise((resolve, reject) => {
                axios.post(`api/add-employee-into-shift`, payload,
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => {
                        dispatch('fetchDocument', payload.shift_id);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        removeEmployeeFromShift({dispatch}, {shiftId, employeeId}) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/remove-employee-from-shift/${shiftId}/${employeeId}`,
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => {
                        dispatch('fetchDocument', shiftId);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
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