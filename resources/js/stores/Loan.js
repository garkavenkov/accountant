import actions from './core/actions';
import mutations from './core/mutations';

export const Loan = {
    namespaced: true,
    state: {
        documents: [],
        document: {},
        creditors: [],
        currencies: [],
        cashes: [],
        url: '/api/loans',
        filter: {
            dateBegin       :   null,
            dateEnd         :   null,
            branchId        :   0,
            isFiltered      :   false,
            queryStr        :   '?'
        },
    },
    getters: {
        loans       :   state   =>  state.documents,
        loan        :   state   =>  state.document,
        creditors   :   state   =>  state.creditors,
        currencies  :   state   =>  state.currencies,
        cashes      :   state   =>  state.cashes
    },
    mutations: {
        ...mutations       
    },
    actions: {
        ...actions,
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
        getCreditorsDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'counterparty')
                .then(res => state.creditors = res);
        },
        getCurrenciesDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'currency?fields=id,code,name')
                .then(res => state.currencies = res);
        },
        getCashesDictionary: ({dispatch, state}) => {
            dispatch('getDictionary',  'cash')
                .then(res => state.cashes = res);
        },
    }
}