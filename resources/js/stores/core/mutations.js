export default  {    

    filterDocuments: (state, payload) => {
        state.filter.queryStr = '';

        if (state.filter.dateBegin) {
            state.filter.queryStr = state.filter.queryStr + `date=${payload.dateBegin}`;
            state.filter.isFiltered = true;
        }

        if (state.filter.dateEnd) {
            state.filter.queryStr = state.filter.queryStr + `,${payload.dateEnd}`;
            state.filter.isFiltered = true;
        }

        if (state.filter.operationId > 0) {
            state.filter.queryStr = state.filter.queryStr + `&operation_id=${payload.operationId}`;
            state.filter.isFiltered = true;
        }

        if (state.filter.cashId > 0) {
            state.filter.queryStr = state.filter.queryStr + `&cash_id=${payload.cashId}`;
            state.filter.isFiltered = true;
        }

        if (state.filter.creditId > 0) {
            state.filter.queryStr = state.filter.queryStr + `&credit_id=${payload.creditId}`;
            state.filter.isFiltered = true;
        }            

        if (state.filter.debetId > 0) {
            state.filter.queryStr = state.filter.queryStr + `&debet_id=${payload.debetId}`;
            state.filter.isFiltered = true;
        }

        // if (state.filter.sumBegin > 0) {
        //     state.filter.queryStr = state.filter.queryStr + `&credit=${payload.departmentId}`;
        //     state.filter.isFiltered = true;
        // }
    }

}