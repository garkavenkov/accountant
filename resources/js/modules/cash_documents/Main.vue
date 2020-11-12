<template>
<div>
     <grid  :dataTable="documents"
            :pagination="pagination"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Кассовые документы
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
                <td class="text-center">Тип</td>
                <td>Дебет</td>
                <td>Кредит</td>
                <td class="text-right">Расход</td>
                <td class="text-right">Приход</td>                
                <td></td>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'CashDocumentShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                    <!-- <i class="far fa-eye"></i> -->
                </td>
                <td class="text-center">{{data.date}}</td>
                <td>{{data.number}}</td>
                <td>{{data.operation}}</td>
                <td>{{data.debet_name}}</td>
                <td>{{data.credit_name}}</td>
                <td class="text-right">{{data.debet | formatNumber(2) }}</td>   
                <td class="text-right">{{data.credit | formatNumber(2) }}</td>   
                <td>
                    <i class="far fa-file"  v-if="data.status_code == 0"></i>
                    <i class="fas fa-check" v-else-if="data.status_code == 1"></i> 
                </td>
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <td colspan="6" class="font-weight-bold">Итого документов: {{documents.length}}</td>
                <td class="text-right font-weight-bold">{{totalDebet | formatNumber(2) }}</td>
                <td class="text-right font-weight-bold">{{totalCredit | formatNumber(2) }}</td>
                <td></td>
            </tr>
        </template>       
    </grid>

    <document-form></document-form>
    <filter-documents></filter-documents>
   

</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import Grid from '../../components/Grid';
import FilterDocuments from './Filter';
import DocumentForm from './Form';

export default {
    name: 'CashDocumentsMain',
    data() {
        return {
            pagination: {},
       
        }
    },
    methods: {
        ...mapActions('CashDocument', ['fetchData', 'getOperationTypeDictionary'])
    },
    computed: {
        ...mapGetters('CashDocument', ['documents']),
        totalDebet() {
            let total =  this.documents.reduce((a, b) => a + b.debet * 1, 0.00);
            return total;
        },
        totalCredit() {
            let total =  this.documents.reduce((a, b) => a + b.credit * 1, 0.00);
            return total;
        },
    },
    components: {
        Grid,
        FilterDocuments,
        DocumentForm
    },
    created() {
        this.fetchData();
        this.getOperationTypeDictionary();
    }
}
</script>