import actions from './core/actions';
import mutations from './core/mutations';

export const Employee = {
    namespaced: true,
    state: {
        documents: [],
        document: {},
        departments: [],
        positions: [],
        url: '/api/employees',
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            branchId        :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        employees   :   state   =>  state.documents,
        employee    :   state   =>  state.document,
        departments :   state   =>  state.departments,
        positions   :   state   =>  state.positions
    },
    mutations: {
        ...mutations       
    },
    actions: {
        ...actions,
        getDepartmentsDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'department')
                .then(res => state.departments = res);
        },
        getPositionsDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'position')
                .then(res => state.positions = res);
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