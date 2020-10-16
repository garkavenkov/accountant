<template>

<div>

    <grid   :dataTable="documents"
            :pagination="pagination"
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
        }
    },    
    methods: {
        ...mapActions('SalesRevenue',   ['fetchData']),   
    },
    computed: {
        ...mapGetters('SalesRevenue',   ['documents', 'filter']),
        totalSum() {
            let total =  this.documents.reduce((a, b) => a + b.amount * 1, 0.00);
            return total;
        },
    },
    created() {
        this.fetchData()
    },
    components: {
        Grid,
        FilterDocuments,
        DocumentForm
    }
}
</script>