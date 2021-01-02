import actions from './core/actions';
import mutations from './core/mutations';

export const Department = {
    namespaced: true,
    state: {
        documents: [],
        document: {},
        branches: [],
        types: [],
        url: '/api/departments',
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            branchId        :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        departments :   state   =>  state.documents,
        department  :   state   =>  state.document,
        branches    :   state   =>  state.branches,
        types       :   state   =>  state.types
    },
    mutations: {
        ...mutations       
    },
    actions: {
        ...actions,
        getDepartmentTypesDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'DepartmentType')
                .then(res => state.types = res);
        },
        getBranchesDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'Branch')
                .then(res => state.branches = res);
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