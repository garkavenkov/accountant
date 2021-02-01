<template>
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
                                        v-model="document.date" 
                                        tabindex="1">
                                <span   id="date-error" 
                                        class="error invalid-feedback">
                                            {{getError('date')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <select-field 
                                    caption="Поставщик"
                                    hint="Выберите поставщика"
                                    :options="suppliers"                            
                                    v-model="document.supplierId"
                                    :error="errors['debet_id']">
                            </select-field>                           
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select-field caption="Отдел"
                                    hint="Виберите отдел"
                                    :options="departments"                            
                                    v-model="document.departmentId"
                                    :error="errors['credit_id']">
                            </select-field>                            
                        </div>
                        <div class="col-md-6">
                            <select-field caption="Сотрудник"
                                    hint="Выберите сотрудника"
                                    :options="employees"
                                    v-model="document.employeeId"
                                    name="full_name"
                                    :error="errors['credit_person_id']">
                            </select-field>
                            <span v-if="departmentShift.length > 0"  v-html="departmentShift"></span>                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input-field    
                                        label="Сумма поставщика"
                                        id="purchaseSum"
                                        v-model="document.purchaseSum"
                                        :error="errors['sum1']">
                            </input-field>                          
                        </div>
                        <div class="col-md-6">
                            <input-field    
                                        label="Сумма отдела"
                                        id="retailSum"
                                        v-model="document.retailSum"
                                        :error="errors['sum2']">
                            </input-field>                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal" tabindex="8">Close</button>
                    <div class="custom-control custom-switch" v-if="filter.isFiltered">
                        <input type="checkbox" id="useFilter" class="custom-control-input" v-model="useFilter" tabindex="9">
                        <label for="useFilter" class="custom-control-label">Use filter</label>
                    </div>
                    <button type="button" class="btn btn-primary" @click="saveDoc($event)" tabindex="7">Сохранить</button>
                </div>
            </div>        
        </div>        
    </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';

import SelectField      from '../../components/SelectField';
import InputField       from '../../components/InputField';
import DateField        from '../../components/DateField';
import FormValidator    from '../../mixins/FormValidator';


export default {
    name: 'IncomeDocumentForm',
    mixins: [FormValidator],
    components: {
        SelectField,
        InputField,
        DateField
    },
    data() {
        return {
            document: {
                date            : new Date().toISOString().slice(0,10),
                departmentId    : 0,                
                employeeId      : 0,
                supplierId      : 0,
                purchaseSum     : 0,
                retailSum       : 0
            },           
            
            departmentShift     : '',                        
            employees           : [],

            useFilter: false
        }
    },
    methods: {
        ...mapActions(['saveDocument']),
        saveDoc(e) {
            let doc = {
                date                : this.document.date,
                debet_id            : this.document.supplierId,
                credit_id           : this.document.departmentId,
                credit_person_id    : this.document.employeeId,
                sum1                : parseFloat(this.document.purchaseSum.replace(",", ".")),
                sum2                : parseFloat(this.document.retailSum.replace(",", "."))
            }
            this.saveDocument(doc)
                .then(res => {
                    this.clearForm(e.ctrlKey);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        // title:'Good job!',
                        text:'Документ успешно создан',
                        icon:'success',
                    });
                })
                .catch(err => {
                    this.errors = err.response.data.errors
                });
        },
        closeModal() {
            this.clearForm();
            this.useFilter = false;
        },         
        clearForm(ctrlIsPressed) {
            
            if (!ctrlIsPressed) {
              
                if (this.useFilter) {
                    this.document.supplierId    = this.filter.debetId   ? this.filter.debetId   : 0;
                    this.document.departmentId  = this.filter.creditId  ? this.filter.creditId  : 0;
                } else {
                    this.document.date = new Date().toISOString().slice(0,10);
                    this.document.departmentId  = 0;            
                    this.document.employeeId    = 0;        
                    this.employees = [];
                } 

            } else {
                document.querySelector('#purchaseSum').focus();
            }
            
            this.document.purchaseSum   = 0;
            this.document.retailSum     = 0;            
            this.errors = [];
        },
        getEmployeesInChargeOfDepartment(departmentId, date) {
            if (date && departmentId != 0) {
                let url = `/api/shift-employees-on-date/${departmentId}/${date}`;
                return new Promise((resolve, reject) => {
                    axios.get(url, 
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => resolve(res.data.data))
                    .catch(err => reject(err));
                });                 
            }
        },
    },
    computed: {
        ...mapGetters(['departments', 'filter', 'suppliers', ]),
    },    
    watch: {    
        'document.date'(newValue, oldValue) {
            if (this.hasError('date')) {
                delete this.errors.date;
            }            
        },
        'document.departmentId'(newValue, oldValue) {     
            if (newValue != 0 ) {
                this.getEmployeesInChargeOfDepartment(this.document.departmentId, this.document.date )
                    .then(res => {
                        let employees = res;
                     
                        this.departmentShift = '';

                        if (employees.length == 0) {
                            this.departmentShift = "<strong><a href='/shifts'>Сотрудники не назначены</a></strong>";
                            this.document.employeeId = 0;                            
                        } else if (employees.length == 1) {
                            this.document.employeeId = employees[0].id;
                        }

                        this.employees =  employees                     
                    })

            } 

            if (this.hasError('credit_id')) {
                delete this.errors.credit_id;
            }
        },        
        'document.employeeId'(newValue, oldValue) {
            if (this.hasError('credit_person_id')) {
                delete this.errors.credit_person_id;
            }
        },
        'document.supplierId'(newValue, oldValue) {
            if (this.hasError('debet_id')) {
                delete this.errors.debet_id;
            }
        },
        'document.purchaseSum'(newValue, oldValue) {
            if (this.hasError('sum')) {
                delete this.errors.sum;
            }
        },        
        'document.retailSum'(newValue, oldValue) {
            if (this.hasError('sum2')) {
                delete this.errors.sum2;
            }
        }, 
        useFilter() {
            if (this.useFilter) {
                if (this.filter.dateBegin) {
                    document.getElementById('date').setAttribute("min", this.filter.dateBegin)
                    this.document.date = this.filter.dateBegin;
                }
                if (this.filter.dateEnd) {
                    document.getElementById('date').setAttribute("max", this.filter.dateEnd)
                    this.document.date = this.filter.dateBegin;
                }
                this.document.supplierId     = this.filter.debetId ? this.filter.debetId : 0;
                this.document.departmentId   = this.filter.creditId ? this.filter.creditId : 0;
            }
        }
    }
}
</script>