import actions from './core/actions';
import mutations from './core/mutations';

export const Branch = {
    namespaced: true,
    state: {
        documents: [],
        document: {},        
        url: '/api/branches',
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            branchId        :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        branches    :   state   =>  state.documents,
        branch      :   state   =>  state.document,
    },
    mutations: {
        ...mutations       
    },
    actions: {
        ...actions,
    }
}