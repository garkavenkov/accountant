<template>
    <div class="modal fade" id="modal-new-document">
        <div class="modal-dialog modal-md">
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
                            <!-- <date-field label="Дата"
                                        id="date"
                                        v-model="document.date"
                                        :error="errors['date']">
                            </date-field> -->
                            <div class="form-group">
                                <label>Дата</label>                                
                                <input  type="date" 
                                        name="date" 
                                        id="date" 
                                        class="form-control datetimepicker-input" 
                                        v-bind:class="{'is-invalid' : hasError('date')}"
                                        v-model="document.date">                                
                                <span   id="date-error" 
                                        class="error invalid-feedback">
                                            {{getError('date')}}
                                </span>
                            </div>         
                        </div>                
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select-field caption="Отдел передает"
                                    hint="Виберите отдел"
                                    :options="departmentsGive"
                                    id="departmentGivesId"
                                    v-model="document.departmentGivesId"
                                    :error="errors['debet_id']">
                            </select-field>
                        </div>
                        <div class="col-md-6">
                            <select-field caption="Отдел принимает"
                                    hint="Виберите отдел"
                                    :options="departmentsTake"
                                    id="departmentTakesId"
                                    v-model="document.departmentTakesId"
                                    :error="errors['credit_id']">
                            </select-field>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select-field caption="Сотрудник"
                                    hint="Выберите сотрудника"
                                    :options="employeesGive"
                                    id="employeeGivesId"
                                    v-model="document.employeeGivesId"
                                    name="full_name"
                                    :error="errors['debet_person_id']">
                            </select-field>
                            <span v-if="departmentGivesShift.length > 0"  v-html="departmentGivesShift"></span>
                        </div>
                        <div class="col-md-6">
                            <select-field caption="Сотрудник"
                                    hint="Выберите сотрудника"
                                    :options="employeesTake"
                                    id="employeeTakesId"
                                    v-model="document.employeeTakesId"
                                    name="full_name"
                                    :error="errors['credit_person_id']">
                            </select-field>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input-field    
                                        label="Сумма"
                                        id="givenSum"
                                        v-model="document.givenSum"                                        
                                        :error="errors['sum1']">
                            </input-field>
                        </div>
                        <div class="col-md-6">
                              <input-field    
                                        label="Сумма"
                                        id="takenSum"
                                        v-model="document.takenSum"
                                        @dblclick='document.takenSum = document.givenSum'
                                        :error="errors['sum2']">
                            </input-field>                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal">Close</button>
                    <div class="custom-control custom-switch" v-if="filter.isFiltered">
                        <input type="checkbox" id="useFilter" class="custom-control-input" v-model="useFilter">
                        <label for="useFilter" class="custom-control-label">Use filter</label>
                    </div>
                    <button type="button" class="btn btn-primary" @click="saveDoc($event)">Сохранить</button>                    
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</template>

<script>
import { mapGetters, mapActions } from 'vuex';

import SelectField      from '../../components/SelectField';
import InputField       from '../../components/InputField';
import DateField        from '../../components/DateField';
import FormValidator    from '../../mixins/FormValidator';

export default {
    name: 'TransferDocumentForm',
    mixins: [FormValidator],
    data() {
        return {
            document: {
                date                : new Date().toISOString().slice(0,10),
                departmentGivesId   : 0,
                departmentTakesId   : 0,
                employeeGivesId     : 0,
                employeeTakesId     : 0,
                givenSum            : 0,
                takenSum            : 0
            },           
            
            departmentGivesShift    : '',
            departmentTakesShift    : '',

            departmentsTake:    [],
            departmentsGive:    [],

            employeesGive:      [],
            employeesTake:      [],
            useFilter: false
        }
    },
    methods: {        
        ...mapActions(['getDepartmentsDictionary', 'saveDocument']),
        saveDoc(e) {
            let doc = {
                date                : this.document.date,
                debet_id            : this.document.departmentGivesId,
                debet_person_id     : this.document.employeeGivesId,
                credit_id           : this.document.departmentTakesId,                
                credit_person_id    : this.document.employeeTakesId,
                sum1                : parseFloat(this.document.givenSum.replace(",", ".")),
                sum2                : parseFloat(this.document.takenSum.replace(",", "."))
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
                .catch(err => this.errors = err.response.data.errors);            
        },
        closeModal() {
            this.clearForm();
            this.useFilter = false;
        },
        clearForm(ctrlIsPressed) {

            this.document.date              = this.filter.dateBegin ? this.filter.dateBegin         : new Date().toISOString().slice(0,10) ;
            this.document.departmentGivesId = this.filter.debetId   ? this.filter.debetId           : ( ctrlIsPressed ? this.document.departmentGivesId : 0) ;
            this.document.departmentTakesId = this.filter.creditId  ? this.filter.creditId          : ( ctrlIsPressed ? this.document.departmentTakesId : 0) ;
            this.document.employeeGivesId   = (this.filter.debetId  || ctrlIsPressed) ? this.document.employeeGivesId : 0;
            this.document.employeeTakesId   = (this.filter.creditId || ctrlIsPressed) ? this.document.employeeTakesId : 0;
            this.document.givenSum          = 0;
            this.document.takenSum          = 0;
            
            this.employeesGive              = (this.filter.debetId || ctrlIsPressed)  ? this.employeesGive : [];
            this.employeesTake              = (this.filter.creditId || ctrlIsPressed) ? this.employeesTake : [];
            // this.departmentsTake = [];

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
        saveAndFillItems() {
            console.log('saveAndFillItems');
        }
    },
    computed: {
        ...mapGetters(['departments', 'filter']),        
    },
    watch: {
        'document.date'(newValue, oldValue) {            
            // this.getEmployeesInChargeOfDepartment();
            if (this.hasError('date')) {
                delete this.errors.date;
            }
            
        },
        'document.departmentGivesId'(newValue, oldValue) {     
            if (newValue != 0 ) {
                this.getEmployeesInChargeOfDepartment(this.document.departmentGivesId, this.document.date )
                    .then(res => {
                        let employees = res;
                     
                        this.departmentGivesShift = '';

                        if (employees.length == 0) {
                            this.departmentGivesShift = "<strong><a href='/shifts'>Сотрудники не назначены</a></strong>";
                            this.document.employeeGivesId = 0;                            
                        } else if (employees.length == 1) {
                            this.document.employeeGivesId = employees[0].id;
                        }

                        this.employeesGive =  employees

                        this.departmentsTake = this.departments.filter(department => 
                            department.id != this.document.departmentGivesId
                        );
                    })

            }  else {
                this.departmentsGive = this.departments   
            }

            if (this.hasError('debet_id')) {
                delete this.errors.debet_id;
            }
        },
        'document.departmentTakesId'(newValue, oldValue) {            
            if (newValue != 0) {
                this.getEmployeesInChargeOfDepartment(this.document.departmentTakesId, this.document.date )
                    .then(res => {
                        
                        let employees = res;

                        this.departmentTakesShift = '';

                        if (employees.length == 0) {
                            this.departmentTakesShift = "<strong><a href='/shifts'>Сотрудники не назначены</a></strong>";
                            this.document.employeeTakesId = 0;                            
                        } else if (employees.length == 1) {
                            this.document.employeeTakesId = employees[0].id;
                        }
                        
                        this.employeesTake =  employees

                        this.departmentsGive = this.departments.filter(department => 
                            department.id != this.document.departmentTakesId
                        );
                    })
            } else {
                this.departmentsTake = this.departments;
            }

            if (this.hasError('credit_id')) {
                delete this.errors.credit_id;
            }
        },
        'document.employeeGivesId'(newValue, oldValue) {
            if (this.hasError('debet_person_id')) {
                delete this.errors.debet_person_id;
            }
        },
        'document.employeeTakesId'(newValue, oldValue) {
            if (this.hasError('credit_person_id')) {
                delete this.errors.credit_person_id;
            }
        },
        'document.givenSum'(newValue, oldValue) {
            if (this.hasError('sum1')) {
                delete this.errors.sum1;
            }
        },
        'document.takenSum'(newValue, oldValue) {
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
                this.document.departmentGivesId = this.filter.debetId ? this.filter.debetId : 0;
                this.document.departmentTakesId = this.filter.creditId ? this.filter.creditId : 0;
            }
        }
    },
    created() {        
        this.getDepartmentsDictionary()
            .then(res => {                
                this.departmentsTake = res;
                this.departmentsGive = res;
            })
    },
    components: {
        SelectField,
        InputField,
        DateField
    }
}
</script>