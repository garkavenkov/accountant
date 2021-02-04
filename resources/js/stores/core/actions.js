const config = {
    'headers': {
        'Authorization': 'Bearer ' + window.api_token,
        'Accept': 'application/json',
    } 
}

export default {

    fetchData({state}) {   
        //  use Promise ???
        let page_url = state.filter.isFiltered ? (state.url + '?' + state.filter.queryStr) : state.url;
        axios
            .get(page_url, config)
            .then(res => {
                state.documents = res.data.data;
                // this.makePagination(res.data.links, res.data.meta);
            })
            .catch(err => console.log(err));
        
    },
    
    fetchDocument({state}, id) {
        
        let page_url = `${state.url}/${id}`;
        axios
            .get(page_url, config)        
            .then(res => {
                state.document = res.data.data;
            })
            .catch(err => console.log(err));
    },

    saveDocument: ({state, dispatch}, payload) => {
        return new Promise((resolve, reject) => {
            axios
                .post(state.url, payload,  config)
                .then(res => {
                    if (res.status == 201) {
                        dispatch('fetchData');
                        resolve(res);
                    }
                })
                .catch(err => reject(err));
        })            
    },

    updateDocument: ({dispatch, state}, payload) => {
        return new Promise((resolve, reject) => {
            axios
                .patch(`${state.url}/${state.document.id}`,  payload, config)
                .then(res => {
                    dispatch('fetchDocument', state.document.id);
                    resolve(res);
                })
                .catch(err => reject(err));
        });
    },

    deleteDocument: ({dispatch, state}, {id, url}) => {
        return new Promise((resolve, reject) => {
            url = (url == '' ) ? state.url : url;
            axios
                .delete(`${url}/${id}`, config)
                .then(res => {
                    dispatch('fetchData');
                    resolve(res)
                })
                .catch(err => reject(err))
            });
    },
    
    applyFilter: ({commit, dispatch}, payload) => {
        commit('filterDocuments', payload);
        dispatch('fetchData');
    },
}