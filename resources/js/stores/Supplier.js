import actions from './core/actions';
import mutations from './core/mutations';

export const Supplier = {
    namespaced: true,
    state: {
        documents: [],
        document: {},        
        url: '/api/suppliers',
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            branchId        :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        suppliers    :   state   =>  state.documents,
        supplier     :   state   =>  state.document,
    },
    mutations: {
        ...mutations       
    },
    actions: {
        ...actions,
    }
}