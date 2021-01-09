<template>

<div>
    
    <grid   :dataTable="documents"
            :pagination="pagination"
            filteredField="supplier"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Возвратные накладные
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
                <td>Сотрудник</td>
                <td>Поставщик</td>                
                <td class="text-right">Сумма продажи</td>
                <td class="text-right">Сумма закупки</td>
                <td class="text-right">Сумма возврата</td>                    
                <td></td>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'ReturnDocumentsShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                </td>
                <td class="text-center">{{data.date}}</td>
                <td>{{data.number}}</td>                
                <td>{{data.department}}</td>
                <td>{{data.employee_full_name}}</td>
                <td>{{data.supplier}}</td>
                <td class="text-right">{{data.retailSum   | formatNumber(2)}}</td>
                <td class="text-right">{{data.purchaseSum | formatNumber(2)}}</td>                    
                <td class="text-right">{{data.return      | formatNumber(2)}}</td>
                <td class="text-center">
                </td>         
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <td colspan="6" class="font-weight-bold">Итого документов: {{documents.length}}</td>
                <td class="text-right font-weight-bold">{{totalRetailSum | formatNumber(2)}}</td>                
                <td class="text-right font-weight-bold">{{totalPurchaseSum | formatNumber(2)}}</td>
                <td class="text-right font-weight-bold">{{totalPurchaseSum - totalRetailSum | formatNumber(2)}}</td>
                <td></td>
            </tr>
        </template>       
    </grid>

    <document-form></document-form>
    <document-filter></document-filter>

</div>

</template>

<script>

import Grid             from '../../components/Grid';

import DocumentForm     from './Form';
import DocumentFilter   from './Filter';

import { mapGetters, mapActions } from 'vuex';

export default {
    // mixins: [FormValidator],
    name: 'ReturnDocumentsMain',
    data() {
        return {            
            pagination: {},            
            url: '/api/return-documents',            
            useFilter: false
        }
    },
    methods: {
        ...mapActions(['fetchData', 'getDepartmentsDictionary', 'getSuppliersDictionary']),
        // makePagination(links, meta) {
        //     this.pagination = {...links, ...meta}
        // },        
       
        // resetFilter() {
        //     this.filter.dateBegin       =   null;
        //     this.filter.dateEnd         =   null;
        //     this.filter.supplierId      =   0;
        //     this.filter.departmentId    =   0;
        //     this.filter.sum1Begin       =   0;
        //     this.filter.sum1End         =   0;
        //     this.filter.isFiltered      =   false;
        //     this.filter.queryStr        =   '';
        //     document.getElementById('dateBegin').value = new Date().toISOString().slice(0,10);
        //     document.getElementById('dateEnd').value = "";
        // }

    },
    computed: {
        ...mapGetters(['documents', 'filter']),
        totalPurchaseSum() {
            let total =  this.documents.reduce((a, b) => a + b.purchaseSum*1, 0.00);
            return total;
        },
        totalRetailSum() {
            let total =  this.documents.reduce((a, b) => a + b.retailSum*1, 0.00);
            return total;
        },        
    },
    created() {
        this.fetchData();
        this.getSuppliersDictionary();
        this.getDepartmentsDictionary();
    },
    watch: {        
    },
    components: {
        Grid,        
        DocumentForm,
        DocumentFilter
    }
}    
</script>

<style scoped>
</style>
