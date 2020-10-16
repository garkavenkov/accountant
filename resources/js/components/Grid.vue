<template>
    <div class="card">
        <div class="card-header">
            <!-- <h3 class="card-title">{{title}}</h3> -->
            <slot name="title"></slot>
        </div>
        <div class="card-body" v-if="dataTable.length > 0">
            <div class="row">
                <!-- Items per page -->
                <div class="col-sm-12 col-md-6">                    
                    <div id="per_page_items__wrapper" class="perPageItems">
                        <label for="data-per-page">
                            Show&nbsp;
                            <select name="data-per-page" 
                                    id="data-per-page" 
                                    class="custom-select custom-select-sm form-control form-control-sm"
                                    @change="changePerPage($event.target.value)">
                                <option v-for="(value) in perPageItems" 
                                        :key="value"
                                        :value="value">{{value}}</option>
                            </select>
                        </label>
                    </div>                    
                </div>
                <!-- /Items per page -->                
                <!-- Filter -->
                <div class="col-sm-12 col-md-6">                    
                    <div id="filter_data__wrapper" class="filterData">
                        <label for="filter_data">
                            Filter&nbsp;
                            <input type="search" name="filter_data" id="filter_data" class="form-control form-control-sm" v-model="searchData">
                        </label>
                    </div>                    
                </div>
                <!-- /Filter -->
            </div>

            <!-- Table -->
            <div class="row">
                <div class="col-sm-12">
                    <table  id="dataTable" 
                            class="table table-bordered table-striped dataTable">
                        <thead>  
                            <slot name="header"></slot>
                        </thead>
                        <tbody>
                            <slot v-bind:paginatedData="paginatedData"></slot>                           
                        </tbody>
                        <tfoot>
                            <slot name="footer"></slot>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /Table -->

            <!-- Pagination -->
            <div class="row">
                <!-- Info -->
                <div class="col-sm-6 col-md-6">
                    <div class="dataTable_info">Showning {{paginateFrom}} to {{paginateTo}} from {{dataTableLength}}</div>
                </div>
                <!-- /Info -->
                <!-- Buttons -->
                <div class="col-sm-6 col-md-6">
                    <div id="paginate" class="dataTable_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous"
                                v-bind:class="{'disabled' : isFirstPage}">
                                <a href="#" class="page-link" @click="changePage(1)">First</a>
                            </li>

                            <li class="paginate_button page-item"
                                v-bind:class="[(currentPage == page) ? 'active' : '']"
                                v-for="page in pagesCount" :key="page">
                                <a href="#" class="page-link" @click="changePage(page)">{{page}}</a>
                            </li>                            
                            
                            <li class="paginate_button page-item next"
                                v-bind:class="{'disabled' : isLastPage}">
                                <a href="#" class="page-link" @click="changePage(pagesCount)">Last</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /Buttons -->
            </div>
            <!-- /Pagination -->
        </div>        
        <div class="card-body" v-else>
            <div>
                No documents.
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Grid',
    props: {
        title: {
            type: String,
            required: false,
            default: null
        },
        dataTable: {
            type:Array,
            required: true
        },
        perPageItems: {
            type: Array,
            required: false,
            default: () => (
                [
                    10,
                    20,
                    50,
                    'all'
                ]
            )
        },
        pagination: {
            type: Object,
            required: false,
            default: () => ({})
        }
    },
    data() {
        return {
            perPage: this.pagination.hasOwnProperty('per_page') ? this.pagination.per_page : this.perPageItems[0],
            currentPage: this.pagination.hasOwnProperty('current_page') ? this.pagination.current_page : 1,
            searchData: ''
        }
    },
    methods: {
        changePerPage(value) {
            if (this.externalPagination) {
                // let url = `${this.pagination.path}/?per_page=${value}`;
                this.$emit('fetchData', this.makeUrl(value));
            } else {
                this.perPage = value;
                this.currentPage = 1;
                // console.log(`Change per page rows to ${value}`);
            }
        },
        changePage(page) {
            if (this.externalPagination) {
                // let url = `${this.pagination.path}/?per_page=${this.pagination.per_page}&page=${page}`;             
                let url = `${this.makeUrl(this.pagination.per_page)}&page=${page}`;
                this.$emit('fetchData', url);                
            } else {
                this.currentPage = page;
            }                        
        },
        makeUrl(value) {
            let url = '';
            if (this.pagination.path.indexOf('?') > 0) {
                url = `${this.pagination.path}&per_page=${value}`;
            } else {
                url = `${this.pagination.path}?per_page=${value}`;
            }
            return url;
        }
    },
    computed: {        
        externalPagination() {
            return Object.keys(this.pagination).length > 0 ? true : false;
        },
        dataTableLength() {
            this.currentPage = 1;
            return this.pagination.hasOwnProperty('total') ? this.pagination.total : this.dataTable.length;
        },
        pagesCount() {
            if (this.externalPagination) {
                return this.pagination.last_page;
            } else {
                return this.perPage === "all" ? 1 : Math.ceil(this.dataTableLength / this.perPage);
            }
        },
        isFirstPage() {
            if (this.externalPagination) {
                return !this.pagination.prev;
            } else {
                return this.currentPage == 1 ? true : false
            }
        },
        isLastPage() {
            if (this.externalPagination) {
                return !this.pagination.next;
            } else {
                return this.currentPage == this.pagesCount ? true : false;
            }
        },
        paginateFrom() {
            if (this.pagination.hasOwnProperty('from')) {
                return this.pagination.from - 1;
            } else {
                if (this.perPage === "all" || this.dataTableLength == 0) {
                    return 1;
                } else {
                    return (this.currentPage -1 ) * this.perPage + 1;
                }
            }
        },
        paginateTo() {
            if (this.pagination.hasOwnProperty('to')) {
                return this.pagination.to;
            } else {
                let end = 0;
                if (this.perPage === "all" || this.dataTableLength == 0) {
                    end = this.dataTableLength;
                } else {
                    end = this.currentPage * this.perPage;
                }
                return end > this.dataTableLength ? this.dataTableLength : end;
            }
        },
        paginatedData() {
            if (this.externalPagination) {                
                return this.dataTable;
            } else {
                if (this.searchData) {
                    return this.dataTable.filter(data => {
                        return  data.department.toLowerCase().includes(this.searchData.toLowerCase() )  ||
                                data.supplier.toLowerCase().includes(this.searchData.toLowerCase()  )
                    });
                }
                return  this.dataTable.slice(this.paginateFrom-1, this.paginateTo);
            }
        },
    },
    watch: {
        'pagination.current_page'(newValue) {
            if (newValue) {
                this.currentPage = newValue;
            }
        },
        // searchData(newValue, oldValue) {
        //     console.log(`${newValue}`);
        // }
    }
}
</script>

<style scoped>
    #per_page_items__wrapper label {
        font-weight: normal;
        text-align: left;
        white-space: nowrap;
    }
    #per_page_items__wrapper select {
        width: auto;
        display: inline-block;
    }
    #filter_data__wrapper {
        text-align: right;
    }
    #filter_data__wrapper label{
        font-weight: normal;
        white-space: nowrap;
        text-align: left;
    }
    #filter_data__wrapper input{
        margin-left: 0.5em;
        display: inline-block;
        width: auto;
    }
    .dataTable_info {
        padding-top: 0.85em;
        white-space: nowrap;
    }
    .dataTable_paginate {
        margin: 0;
        white-space: nowrap;
        text-align: right;
    }
    ul.pagination {
        margin: 2px 0;
        white-space: nowrap;
        justify-content: flex-end;
    }
</style>