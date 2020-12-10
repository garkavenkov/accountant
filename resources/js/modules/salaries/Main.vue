<template>

<div>

    <grid   :dataTable="documents"
            :pagination="pagination"
            filteredField="employee_full_name"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Зароботная плата
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
                <th></th>
                <th class="text-center">Дата</th>
                <th class="text-center">№</th>
                <th>Касса</th>
                <th>Сотрудник</th>
                <th>Основание</th>
                <th class="text-right">Сумма</th>
                <th></th>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'SalaryShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                </td>
                <td class="text-center">{{data.date}}</td>
                <td>{{data.number}}</td>                
                <td>{{data.cash}}</td>
                <td>{{data.employee_full_name}}</td>
                <td>{{data.purpose}}</td>
                <td class="text-right">{{data.amount | formatNumber(2) }}</td>   
                <td>{{data.status}}</td>             
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <td colspan="6" class="font-weight-bold">Итого документов: {{documents.length}}</td>
                <td class="text-right font-weight-bold">{{totalSalary | formatNumber(2) }}</td>
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
    name: 'SalariesMain',
    props: [],
    data() {
        return {
            pagination: {},
            // departments: [],
        }
    },    
    methods: {
        ...mapActions(['fetchData', 'getCashesDictionary', 'getEmployeesDictionary']),
    },    
    computed: {
        ...mapGetters(['documents', 'filter']),
        totalSalary() {
            let total =  this.documents.reduce((a, b) => a + b.amount * 1, 0.00);
            return total;
        },
    },
    created() {
        this.fetchData(),
        this.getCashesDictionary(), 
        this.getEmployeesDictionary()
    },
    components: {
        Grid,
        FilterDocuments,
        DocumentForm
    }
}
</script>