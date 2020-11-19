<template>

<div>
    
    <grid   :dataTable="documents"
            :pagination="pagination"
             filteredField="department_takes"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Трансферные накладные
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
                <td>Отдел передает</td>
                <td>Сотрудник</td>
                <td class="text-right">Сумма</td>
                <td>Отдел принимает</td>
                <td>Сотрудник</td>                
                <td class="text-right">Сумма</td>
                <!-- <td class="text-right">Торговая наценка</td>                     -->
                <td></td>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'TransferDocumentsShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                </td>
                <td class="text-center">{{data.date | formatDate }}</td>
                <td>{{data.number}}</td>
                <td>{{data.department_gives}}</td>
                <td>{{data.employee_gives}}</td>
                <td class="text-right">{{data.given_sum | formatNumber(2)}}</td>
                <td>{{data.department_takes}}</td>
                <td>{{data.employee_takes}}</td>                
                <td class="text-right">{{data.taken_sum | formatNumber(2)}}</td>                    
                <!-- <td class="text-right">{{data.gain | formatNumber(2)}}</td> -->
                <td class="text-center">
                    <!-- <document-paid v-if="data.isPaid" :payments="data.payments"></document-paid> -->
                    <!-- <template v-if="data.isPaid">
                        <abbr :title="Oплата произведена ${data.supplier}">
                            <i class="fas fa-donate"></i>
                        </abbr>
                    </template> -->                   
                    <!-- <i class="fas fa-file-invoice-dollar"></i> -->
                </td>         
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <td colspan="5" class="font-weight-bold">Итого документов: {{documents.length}}</td>
                <td class="text-right font-weight-bold">{{totalGivenSum | formatNumber(2)}}</td>
                <td colspan="2"></td>
                <td class="text-right font-weight-bold">{{totalTakenSum | formatNumber(2)}}</td>                
                <!-- <td class="text-right font-weight-bold">{{totalTakenSum - totalGivenSum | formatNumber(2)}}</td> -->
                <td></td>
            </tr>
        </template>       
    </grid>

    <document-form></document-form>
    <document-filter></document-filter>


</div>

</template>

<script>
import FormValidator    from '../../mixins/FormValidator';
import Grid             from '../../components/Grid';
import DocumentForm     from './Form';
import DocumentFilter   from './Filter';

import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'TransferDocumentsMain',
    data() {
        return {            
            pagination: {},
            url: '/api/transfer-documents',            
            
        }
    },
    methods: {
        ...mapActions(['fetchData', 'applyFilter', 'saveDocument']),
        makePagination(links, meta) {
            this.pagination = {...links, ...meta}
        },        
                
        resetFilter() {
            this.filter.dateBegin           =   null;
            this.filter.dateEnd             =   null;
            this.filter.departmentGivesId   =   0;
            this.filter.departmentTakesId   =   0;
            // this.filter.sum1Begin           =   0;
            // this.filter.sum1End             =   0;
            this.filter.isFiltered          =   false;
            this.filter.queryStr            =   '';
            document.getElementById('dateBegin').value = new Date().toISOString().slice(0,10);
            document.getElementById('dateEnd').value = "";
        }

    },
    computed: {
        ...mapGetters(['documents', 'filter']),
        totalGivenSum() {
            let total =  this.documents.reduce((a, b) => a + b.given_sum*1, 0.00);
            return total;
        },
        totalTakenSum() {
            let total =  this.documents.reduce((a, b) => a + b.taken_sum*1, 0.00);
            return total;
        },        
    },
    created() {
        this.fetchData();        
        // this.getDepartmentsDictionary();
    },
    components: {
        Grid,
        DocumentForm,
        DocumentFilter
    }
}    
</script>

<style scoped>
    .fa-donate {
        color: red;
    }
    .fa-file-invoice-dollar {
        color:darkgreen;
    }    
    abbr {
        text-decoration: none;
    }
    abbr:hover {
        cursor: default;
    }
</style>
