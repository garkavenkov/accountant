<template>

<div>
    
    <grid   :dataTable="documents"
            :pagination="pagination"
            filteredField="supplier"
            @fetchData="fetchData"
            v-model="selectedRecords"> 

        <template v-slot:title>
            <h3 class="card-title">Товарные накладные
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
                <button type="button" 
                        class="btn btn-info" 
                        v-on:click="selectMode"
                        title="Выбрать записи"
                        v-if="documents.length > 0">
                            <i class="fas fa-tasks"></i>
                            <span class="float-right badge bg-primary" v-if="selectedRecords.length > 0">{{selectedRecords.length}}</span>
                    </button>
                <template v-if="selectedRecords.length > 0">                    
                    <button class="btn btn-info "
                            data-toggle="modal" 
                            data-target="#modal-tag-form"
                            data-backdrop="static" 
                            data-keyboard="true"
                            title="Установить признак на документ">
                        <i class="fas fa-tags"></i>
                    </button>
                    <button class="btn btn-info "
                            data-toggle="modal" 
                            data-target="#modal-accountability-form"
                            data-backdrop="static" 
                            data-keyboard="true"
                            title="Добавить документ в авансовый отчет">
                        <i class="fas fa-receipt"></i>
                    </button>
                </template>               
            </h3>
        </template>           
        <template v-slot:header>
            <tr>
                <td v-if="inSelectMode">
                    <input type="checkbox" name="selectAll" id="selectAll" @change="selectAll($event)">
                </td>
                <td v-else></td>
                <td class="text-center" @click="sort('date')">Дата</td>
                <td class="text-center" @click="sort('number')">№</td>
                <td  @click="sort('supplier')">
                    Поставщик
                    <i class="fas fa-sort"></i>
                </td>
                <td>Отдел</td>
                <td>Сотрудник</td>
                <td class="text-right">Сумма закупки</td>
                <td class="text-right">Сумма продажи</td>
                <td class="text-right">Торговая наценка</td>                    
                <td colspan="2"></td>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id" :class="{ selected: data.selected }">
                <td class="text-center" v-if="!inSelectMode">
                    <router-link :to="{name: 'IncomeDocumentsShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                </td>
                <td v-else>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" v-model="data.selected" @change="handleClick(data)">
                      </div>
                    <!-- <input type="checkbox" v-model="data.selected" @change="handleClick(data)"> -->
                </td>
                <td class="text-center">{{data.date}}</td>
                <td>{{data.number}}</td>
                <td>{{data.supplier}}</td>
                <td>{{data.department}}</td>
                <td>{{data.employee_full_name}}</td>
                <td class="text-right">{{data.sum1 | formatNumber(2)}}</td>
                <td class="text-right">{{data.sum2 | formatNumber(2)}}</td>                    
                <td class="text-right">{{data.gain | formatNumber(2)}}</td>
                <td class="text-center">
                    <document-paid v-if="data.isPaid" :payments="data.payments"></document-paid>                    
                    <in-accountability v-if="data.inAccountability" :accountability="data.accountability"></in-accountability>

                </td>
                <td>
                    <template v-if="data.firstForm">
                        <abbr title="Первая форма">
                            <i class="fas fa-search-dollar first-form"></i>
                        </abbr>                        
                    </template>
                    <abbr title="Бонус" v-if="data.bonus == 1">
                        <i class="fas fa-gift gift"></i>
                    </abbr>
                    <!-- <i class="fas fa-file-invoice-dollar"></i> -->
                </td>         
            </tr>     
        </template>
        <template v-slot:footer>
            <tr v-if="selectedRecords.length>0">
                <td colspan="6" class="font-weight-italic">Выделено документов: {{selectedRecords.length}}</td>
                <td class="text-right font-weight-italic">{{totalSelectedPurchaseSum | formatNumber(2)}}</td>
                <td class="text-right font-weight-italic">{{totalSelectedRetailSum | formatNumber(2)}}</td>                
                <td class="text-right font-weight-italic">{{totalSelectedRetailSum - totalSelectedPurchaseSum | formatNumber(2)}}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="6" class="font-weight-bold">Итого документов: {{documents.length}}</td>
                <td class="text-right font-weight-bold">{{totalPurchaseSum | formatNumber(2)}}</td>
                <td class="text-right font-weight-bold">{{totalRetailSum | formatNumber(2)}}</td>                
                <td class="text-right font-weight-bold">{{totalRetailSum - totalPurchaseSum | formatNumber(2)}}</td>
                <td></td>
            </tr>
        </template>       
    </grid>

    <document-form></document-form>    
    <document-filter></document-filter>
    
    <flag-form :documents="selectedRecords"></flag-form>
    <accountability-form :documents="selectedRecords"></accountability-form>

</div>

</template>

<script>

import Grid                 from '../../components/Grid';
import DocumentPaid         from './DocumentPaid';
import InAccountability     from './Accountability';
import DocumentForm         from './Form';
import DocumentFilter       from './Filter';
import FlagForm             from './FlagForm'
import AccountabilityForm   from './AccountabilityForm';


import { mapGetters, mapActions } from 'vuex';

export default {
    // mixins: [FormValidator],
    name: 'IncomeDocumentsMain',
    data() {
        return {            
            pagination: {},            
            url: '/api/income-documents',            
            useFilter: false,
            inSelectMode: false,
            selectedRecords: [],
        }
    },
    methods: {
        ...mapActions(['fetchData', 'getDepartmentsDictionary', 'getSuppliersDictionary']),
        makePagination(links, meta) {
            this.pagination = {...links, ...meta}
        },        
       
        resetFilter() {
            this.filter.dateBegin       =   null;
            this.filter.dateEnd         =   null;
            this.filter.supplierId      =   0;
            this.filter.departmentId    =   0;
            this.filter.sum1Begin       =   0;
            this.filter.sum1End         =   0;
            this.filter.isFiltered      =   false;
            this.filter.queryStr        =   '';
            document.getElementById('dateBegin').value = new Date().toISOString().slice(0,10);
            document.getElementById('dateEnd').value = "";
        },
        selectMode() {
            if (this.inSelectMode) {
                this.inSelectMode = false;
                this.selectedRecords = [];
                this.documents.forEach(document => delete document.selected);
            } else {
                this.inSelectMode = true;
            }
        },
        selectAll(e) {
            if (e.target.checked) {
                this.selectedRecords = this.documents
                this.documents.map(document => document.selected = true);
            } else {
                this.selectedRecords = [];
                this.documents.map(document => delete document.selected);
            }
        },
        handleClick(record) {
            this.selectedRecords = this.documents.filter(document => document.selected);
            // if (record.selected) {
            //     this.selectedRecords.push(record);
            // } else {
            //     this.selectedRecords = this.selectedRecords.filter(item => item.id != record.id);
            // }
        },
        sort(field) {
            // console.log(`Sort on field ${field}`);
            // this.documents.sort((a,b) => (a[field] > b[field]) ? 1 : ((b[field] > a[field]) ? -1 : 0))
            // this.documents.sort((a,b) => a[field] - b[field] || a['sum1'] - b['sum2'] )
            // this.documents.sort('supplier');
            this.documents.sort(function (a, b) {

            	// Sort by votes
            	// If the first item has a higher number, move it down
            	// If the first item has a lower number, move it up
            	if (a[field] > b[field]) return 1;
            	if (a[field] < b[field]) return -1;

            	// If the votes number is the same between both items, sort alphabetically
            	// If the first item comes first in the alphabet, move it up
            	// Otherwise move it down
            	if (a['sum1'] > b['sum1']) return 1;
            	if (a['sum1'] < b['sum1']) return -1;

            });

        }
    },
    computed: {
        ...mapGetters(['documents', 'filter']),
        totalPurchaseSum() {
            let total =  this.documents.reduce((a, b) => a + b.sum1*1, 0.00);
            return total;
        },
        totalRetailSum() {
            let total =  this.documents.reduce((a, b) => a + b.sum2*1, 0.00);
            return total;
        },  
        totalSelectedPurchaseSum() {
            let total =  this.selectedRecords.reduce((a, b) => a + b.sum1*1, 0.00);
            return total;
        },
        totalSelectedRetailSum() {
            let total =  this.selectedRecords.reduce((a, b) => a + b.sum2*1, 0.00);
            return total;
        },  
        
    },
    created() {
        this.fetchData();
        this.getSuppliersDictionary();
        this.getDepartmentsDictionary();
    },
    watch: {
        
        // 'newDocument.date'(newValue, oldValue) {            
        //     this.getEmployeesInChargeOfDepartment();
        //     if (this.hasError('date')) {
        //         delete this.errors.date;
        //     }
            
        // },
        // 'newDocument.departmentId'(newValue, oldValue) {
        //     this.getEmployeesInChargeOfDepartment();
        //     if (this.hasError('credit_id')) {
        //         delete this.errors.credit_id;
        //     }
        // },
        // 'newDocument.supplierId'(newValue, oldValue) {            
        //     if (this.hasError('debit_id')) {
        //         delete this.errors.debit_id;
        //     }
        // },
        // 'newDocument.employeeId'(newValue, oldValue) {
        //     if (this.hasError('credit_person_id')) {
        //         delete this.errors.credit_person_id;
        //     }
        // },
        // 'newDocument.purchaseSum'(newValue, oldValue) {
        //     if (this.hasError('sum1')) {
        //         delete this.errors.sum1;
        //     }
        // },
        // 'newDocument.retailSum'(newValue, oldValue) {
        //     if (this.hasError('sum2')) {
        //         delete this.errors.sum2;
        //     }
        // },
        // 'filter.date_begin'(newValue, oldValue) {
        //     if (!newValue) {
        //         var el = document.getElementById('date_end');
        //         el.value = ""
        //         this.filter.date_end = null;
        //     }
        // },    
    },
    components: {
        Grid,
        DocumentPaid,
        DocumentForm,
        DocumentFilter,
        AccountabilityForm,
        InAccountability,
        FlagForm
    }
}    
</script>

<style scoped>
    abbr {
        text-decoration: none;
    }
    abbr:hover {
        cursor: default;
    }
    tr.selected {
        background-color: cadetblue !important;
    }

    i.first-form {
        color: green;
        font-weight: bold;
    }

    i.gift {
        color: blue;
        font-weight: bold;
    }
</style>
