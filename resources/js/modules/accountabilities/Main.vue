<template>
<div>
     <grid  :dataTable="documents"
            :pagination="pagination"
            filteredField="supplier"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Подотчетные документы
                <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-new-document"
                        data-backdrop="static" 
                        data-keyboard="true"
                        title="Добавить документ">
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
                        data-keyboard="true"
                        title="Фильтр документов">
                    <i class="fas fa-filter"></i>
                </button>
            </h3>
        </template>           
        <template v-slot:header>
            <tr>
                <td></td>
                <td class="text-center">Дата</td>
                <td class="text-center">№</td>
                <td>Касса</td>
                <td>Подотчетное лицо</td>
                <td>Основание</td>                
                <td class="text-right">Сумма</td>                
                <td></td>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'AccountabilitiesShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                    <!-- <i class="far fa-eye"></i> -->
                </td>
                <td class="text-center">{{data.date}}</td>
                <td>{{data.number}}</td>
                <td>{{data.cash}}</td>
                <td>{{data.employee_full_name}}</td>
                <td>{{data.purpose}}</td>
                <td class="text-right">{{data.amount | formatNumber(2) }}</td>   
                <td>
                    <i class="far fa-file"  v-if="data.status_code == 0"></i>
                    <i class="fas fa-check" v-else-if="data.status_code == 1"></i> 
                    <i class="fas fa-lock" v-else></i> 
                </td>
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <td colspan="6" class="font-weight-bold">Итого документов: {{documents.length}}</td>                
                <td class="text-right font-weight-bold">{{totalAmount | formatNumber(2) }}</td>
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
    name: 'AccountabilitiesMain',
    data() {
        return {
            pagination: {},
       
        }
    },
    methods: {
        ...mapActions(['fetchData', 'getCashesDictionary', 'getEmployeesDictionary'])
    },
    computed: {
        ...mapGetters(['documents']),
        totalAmount() {
            let total =  this.documents.reduce((a, b) => a + b.amount * 1, 0.00);
            return total;
        }        
    },
    components: {
        Grid,
        FilterDocuments,
        DocumentForm
    },
    created() {
        this.fetchData();
        this.getCashesDictionary();
        this.getEmployeesDictionary();
    }
}
</script>