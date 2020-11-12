import axios from 'axios';

export const Dictionary = {
    namespaced: true,
    state: {
        cashes: [],
        suppliers: []
    },
    getters: {
        cashes:         state =>    state.cashes,
        suppliers:      state =>    state.suppliers,
    },
    mutations: {

    },
    actions: {
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
        getCashesDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'cash')
                .then(res => state.cashes = res);
        },
        getSuppliersDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'supplier')
                .then(res => state.suppliers = res);
        },
    }

}