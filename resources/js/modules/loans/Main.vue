<template>
<div>
    
    <grid   :dataTable="loans"
            :pagination="pagination"
            filteredField="creditor"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Кредиты
                <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-new-loan"
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
                <!-- <button class="btn btn-info "
                        data-toggle="modal" 
                        data-target="#modal-filter-document"
                        data-backdrop="static" 
                        data-keyboard="true">
                    <i class="fas fa-filter"></i>
                </button> -->
            </h3>
        </template>           
        <template v-slot:header>
            <tr>
                <td></td>
                <td>Кредитор</td>
                <td class="text-center">Валюта</td>
                <td class="text-center">Сумма</td>
                <td class="text-center">Дата начала</td>
                <td class="text-center">Дата окончания</td>
                <!-- <td></td> -->
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'LoansShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                </td>
                <td>{{data.creditorName}}</td>
                <td class="text-center">{{data.currencyName}}</td>
                <td class="text-right">{{data.amount | formatNumber(2)}}</td>
                <td class="text-center">{{data.dateBegin}}</td>
                <td class="text-center">{{data.dateEnd}}</td>                
            </tr>     
        </template>
        <!-- <template v-slot:footer>
            <tr>
                <td colspan="5" class="font-weight-bold">Итого документов: {{documents.length}}</td>
                <td class="text-right font-weight-bold">{{totalMarkdownSum | formatNumber(2)}}</td>
                <td></td>
            </tr>
        </template>        -->
    </grid>

    <new-loan-form></new-loan-form>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

import Grid     from '../../components/Grid';
import NewLoanForm from './NewLoanForm';


export default {
    name: 'LoansMain',
    data() {
        return {
            pagination: {}
        }
    },
    methods: {
        ...mapActions(['fetchData'])
    },
    computed: {
        ...mapGetters(['loans'])
    },    
    components: {
        Grid,
        NewLoanForm
    },
    created() {
        this.fetchData();
    }

}
</script>