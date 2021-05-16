<template>

<div>

    <!-- <grid   :dataTable="documents"
            :pagination="pagination"
            filteredField="department"
            @searched="searchedData"
            @fetchData="fetchData">  -->

    <grid   :dataTable="documents"
            :pagination="pagination"
            filteredField="department"
            @onSearch="onSearchData"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Торговая выручка
                <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-new-document"
                        data-backdrop="static" 
                        data-keyboard="true">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" 
                        class="btn btn-info" 
                        v-on:click="fetchData"
                        title="Обновить данные">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button class="btn btn-info "
                        data-toggle="modal" 
                        data-target="#modal-filter-document"
                        data-backdrop="static" 
                        data-keyboard="true">
                    <i class="fas fa-filter"></i>
                </button>
            </h3>
        </template>           
        <template v-slot:header>
            <tr>
                <td></td>
                <td class="text-center">Дата</td>
                <td class="text-center">№</td>
                <td>Отдел</td>
                <td>Касса</td>
                <td class="text-right">Сумма</td>                    
                <td></td>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'SalesRevenueShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                    <!-- <i class="far fa-eye"></i> -->
                </td>
                <td class="text-center">{{data.date}}</td>
                <td>{{data.number}}</td>
                <td>{{data.department}}</td>
                <td>{{data.cash}}</td>
                <td class="text-right">{{data.amount | formatNumber(2) }}</td>   
                <td>{{data.status}}</td>             
            </tr>     
        </template>
        <template v-slot:footer>
            <tr v-if="searchedDocuments.length > 0">
                <td colspan="5" class="font-weight-bold">Найдено документов: {{searchedDocuments.length}}</td>
                <td class="text-right font-weight-bold">{{totalSearchedSum | formatNumber(2) }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="font-weight-bold">Итого документов: {{documents.length}}</td>
                <td class="text-right font-weight-bold">{{totalSum | formatNumber(2) }}</td>
                <td></td>
            </tr>
        </template>       
    </grid>

    
    <document-form></document-form>
    <filter-documents></filter-documents>
   

</div>

</template>

<script>

import { mapActions, mapGetters } from 'vuex'
import Grid from '../../components/Grid';
import FilterDocuments from './Filter';
import DocumentForm from './Form';

export default {
    name: 'SalesRevenueMain',
    props: [],
    data() {
        return {
            pagination: {},
            // departments: [],
            searchedDocuments: []
        }
    },    
    methods: {
        ...mapActions(['fetchData', 'getCashesDictionary', 'getDepartmentsDictionary', 'searchData']),
        // searchedData(data) {
        //     this.searchedDocuments = data ? data : [];
        // }
        onSearchData(value) {
            this.searchData(value)
        }
    },
    computed: {
        ...mapGetters(['documents', 'filter']),
        totalSum() {
            let total =  this.documents.reduce((a, b) => a + b.amount * 1, 0.00);
            return total;
        },
        totalSearchedSum() {
            let total =  this.searchedDocuments.reduce((a, b) => a + b.amount * 1, 0.00);
            return total;
        }
    },    
    created() {
        this.fetchData();
        this.getCashesDictionary();
        this.getDepartmentsDictionary(0);
    },
    components: {
        Grid,
        FilterDocuments,
        DocumentForm
    }
}
</script>