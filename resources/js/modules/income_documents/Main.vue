<template>

<div>
    
    <grid   :dataTable="documents"
            :pagination="pagination"
            @fetchData="fetchData"> 

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
            </h3>
        </template>           
        <template v-slot:header>
            <tr>
                <td></td>
                <td class="text-center">Дата</td>
                <td class="text-center">№</td>
                <td>Поставщик</td>
                <td>Отдел</td>
                <td>Сотрудник</td>
                <td class="text-right">Сумма закупки</td>
                <td class="text-right">Сумма продажи</td>
                <td class="text-right">Торговая наценка</td>                    
                <td></td>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'IncomeDocumentsShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
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
                    <abbr title="Oплата произведена 29.06.2020">
                        <i class="fas fa-donate"></i>
                    </abbr>
                    <i class="fas fa-file-invoice-dollar"></i>
                </td>         
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <td colspan="6" class="font-weight-bold">Итого документов: {{documents.length}}</td>
                <td class="text-right font-weight-bold">{{totalPurchaseSum | formatNumber(2)}}</td>
                <td class="text-right font-weight-bold">{{totalRetailSum | formatNumber(2)}}</td>                
                <td class="text-right font-weight-bold">{{totalRetailSum - totalPurchaseSum | formatNumber(2)}}</td>
                <td></td>
            </tr>
        </template>       
    </grid>


    <div class="modal fade" id="modal-new-document">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Новый документ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">                 
                            <div class="form-group">
                                <label>Дата</label>                                
                                <input  type="date" 
                                        name="date" 
                                        id="date" 
                                        class="form-control datetimepicker-input" 
                                        v-bind:class="{'is-invalid' : hasError('date')}"
                                        v-model="newDocument.date">                                
                                <span   id="date-error" 
                                        class="error invalid-feedback">
                                            {{getError('date')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Поставщик</label>
                                <select class="form-control select2" 
                                        style="width: 100%;" 
                                        v-bind:class="{'is-invalid' : hasError('debit_id')}"
                                        v-model="newDocument.supplierId">
                                    <option selected="selected" 
                                            disabled 
                                            value="0">
                                        Выберите поставщика
                                    </option>
                                    <option v-for="supplier in suppliers" 
                                            :value="supplier.id" 
                                            :key="supplier.id">
                                                {{supplier.name}}
                                    </option>                          
                                </select>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('debit_id')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Отдел</label>
                                <select class="form-control select2" 
                                        style="width: 100%;" 
                                         v-bind:class="{'is-invalid' : hasError('credit_id')}"
                                        v-model="newDocument.departmentId">
                                    <option selected="selected" disabled value="0">
                                        Выбирите подразделение
                                    </option>
                                    <option v-for="department in departments" 
                                            :value="department.id" 
                                            :key="department.id">
                                                {{department.name}}
                                    </option>                          
                                </select>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('credit_id')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Сотрудник</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-bind:class="{'is-invalid' : hasError('credit_person_id')}"
                                        v-model="newDocument.employeeId">
                                    <option selected="selected" disabled value="0">
                                        Выбирите сотрудника
                                    </option>                                    
                                    <option v-for="employee in employees" 
                                            :value="employee.id" 
                                            :key="employee.id">
                                                {{employee.full_name}}
                                    </option>
                                </select>
                                <span v-if="departmentShift.length > 0"  v-html="departmentShift"></span>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('credit_person_id')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Сумма поставщика</label>                    
                                <input  type="text" 
                                        name="purchaseSum" 
                                        id="purchaseSum" 
                                        class="form-control" v-model="newDocument.purchaseSum"
                                        v-bind:class="{'is-invalid' : hasError('sum1')}">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('sum1')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Сумма отдела</label>                    
                                <input  type="text" 
                                        name="retailSum" 
                                        id="retailSum" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('sum2')}"
                                        v-model="newDocument.retailSum">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('sum2')}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <!-- data-dismiss="modal" -->
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal">Close</button>
                    <div class="custom-control custom-switch" v-if="filter.isFiltered">
                        <input type="checkbox" id="useFilter" class="custom-control-input" v-model="useFilter">
                        <label for="useFilter" class="custom-control-label">Use filter</label>
                    </div>
                    <button type="button" class="btn btn-primary" @click="saveDoc">Сохранить</button>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-filter-document">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Фильтр документов</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Дата с</label>
                                <input  type="date" 
                                        name="dateBegin" 
                                        id="dateBegin" 
                                        class="form-control datetimepicker-input"
                                        v-model="filter.dateBegin">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Дата по</label>
                                <input  type="date" 
                                        name="dateEnd" 
                                        id="dateEnd" 
                                        class="form-control datetimepicker-input" 
                                        :min="filter.dateBegin"
                                        :disabled="!filter.dateBegin"
                                        v-model="filter.dateEnd">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Отдел</label>                                
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="filter.departmentId">
                                    <option selected="selected" value="0">
                                        Все отделы
                                    </option>
                                    <option v-for="department in departments" 
                                            :value="department.id" 
                                            :key="department.id">
                                                {{department.name}}
                                    </option>                          
                                </select>                                
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                             <div class="form-group">
                                <label>Поставщик</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="filter.supplierId">
                                    <option selected="selected"
                                            value="0">
                                        Все поставщики
                                    </option>
                                    <option v-for="supplier in suppliers" 
                                            :value="supplier.id" 
                                            :key="supplier.id">
                                                {{supplier.name}}
                                    </option>                          
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Сумма c</label>                    
                                <input  type="text" 
                                        name="purchaseSumFrom" 
                                        id="purchaseSumFrom"
                                        class="form-control"
                                        v-model="filter.sum1Begin">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Сумма по</label>                    
                                <input  type="text" 
                                        name="purchaseSumTo" 
                                        id="purchaseSumTo" 
                                        class="form-control"
                                        v-model="filter.sum1End">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" @click="resetFilter">Сбросить</button>
                    <button type="button" class="btn btn-primary" @click="applyFilter(filter)">Применить</button>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>

</template>

<script>
import FormValidator from '../../mixins/FormValidator';
import Grid from '../../components/Grid';
import { mapGetters, mapActions } from 'vuex';

export default {
    mixins: [FormValidator],
    name: 'IncomeDocumentsMain',
    data() {
        return {            
            pagination: {},
            newDocument: {
                date                : null,
                supplierId          : 0,
                departmentId        : 0,
                employeeId          : 0,
                purchaseSum         : 0,
                retailSum           : 0
            },           
            employees: [],
            departmentShift: '',
            url: '/api/income-documents',            
            useFilter: false
        }
    },
    methods: {
        ...mapActions(['fetchData', 'applyFilter', 'saveDocument', 'getDepartmentsDictionary', 'getSuppliersDictionary']),        
        makePagination(links, meta) {
            this.pagination = {...links, ...meta}
        },        
        getEmployeesInChargeOfDepartment() {
            if (this.document.date && this.document.departmentId != 0) {
                let url = `/api/shift-employees-on-date/${this.document.departmentId}/${this.document.date}`;
                 axios.get(url, 
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => {
                        let employees = res.data.data;
   
                        if (employees.length == 0) {
                            this.departmentShift = "<strong><a href='/shifts'>Сотрудники не назначены</a></strong>";
                            this.document.employeeId = 0;                            
                        } else if (employees.length == 1) {
                            this.departmentShift = '';                            
                            this.document.employeeId = employees[0].id;
                        } else {
                            this.departmentShift = '';
                            this.employees = employees;
                        }
                        this.employees = employees;
                    })
                    .catch(err => console.log(err));
            }
        },
        closeModal() {
            this.clearForm();
        },
        clearForm() {
            this.document.date = null;
            this.document.supplierId = 0;
            this.document.departmentId = 0;
            this.document.employeeId = 0;            
            this.document.purchaseSum = 0;
            this.document.retailSum = 0;
            this.employees = [];
            this.errors = [];
        },
        saveDoc() {
            let doc = {
                    date                : this.newDocument.date,
                    debit_id            : this.newDocument.supplierId,
                    credit_id           : this.newDocument.departmentId,
                    credit_person_id    : this.newDocument.employeeId,
                    sum1                : parseFloat(this.newDocument.purchaseSum.replace(",", ".")),
                    sum2                : parseFloat(this.newDocument.retailSum.replace(",", "."))
                }
            this.saveDocument(doc)
                .then(res => {
                    this.clearForm();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        title:'Good job!',
                        text:'Документ успешно создан',
                        icon:'success',
                    });
                })
                .catch(err => this.errors = err.response.data.errors);            
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
        }

    },
    computed: {
        ...mapGetters(['documents', 'filter', 'suppliers', 'departments']),
        totalPurchaseSum() {
            let total =  this.documents.reduce((a, b) => a + b.sum1*1, 0.00);
            return total;
        },
        totalRetailSum() {
            let total =  this.documents.reduce((a, b) => a + b.sum2*1, 0.00);
            return total;
        },        
    },
    created() {
        // this.fetchData();
        this.getSuppliersDictionary();
        this.getDepartmentsDictionary();
    },
    mounted() {
    
    },
    watch: {
        'document.date'(newValue, oldValue) {            
            this.getEmployeesInChargeOfDepartment();
            if (this.hasError('date')) {
                delete this.errors.date;
            }
            
        },
        'document.departmentId'(newValue, oldValue) {
            this.getEmployeesInChargeOfDepartment();
            if (this.hasError('credit_id')) {
                delete this.errors.credit_id;
            }
        },
        'document.supplierId'(newValue, oldValue) {            
            if (this.hasError('debit_id')) {
                delete this.errors.debit_id;
            }
        },
        'document.employeeId'(newValue, oldValue) {
            if (this.hasError('credit_person_id')) {
                delete this.errors.credit_person_id;
            }
        },
        'document.purchaseSum'(newValue, oldValue) {
            if (this.hasError('sum1')) {
                delete this.errors.sum1;
            }
        },
        'document.retailSum'(newValue, oldValue) {
            if (this.hasError('sum2')) {
                delete this.errors.sum2;
            }
        },
        'filter.date_begin'(newValue, oldValue) {
            if (!newValue) {
                var el = document.getElementById('date_end');
                el.value = ""
                this.filter.date_end = null;
            }
        },    
    },
    components: {
        Grid
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
