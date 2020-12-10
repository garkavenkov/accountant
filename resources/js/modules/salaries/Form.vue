<template>
    <div class="modal fade" id="modal-new-document">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Начисление зарплаты</h4>
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
                                <label>Сотрудник</label>
                                <select class="form-control select2" 
                                        style="width: 100%;" 
                                        @change="getEmployeeSalary(newDocument.date)"
                                        v-bind:class="{'is-invalid' : hasError('credit_id')}"
                                        v-model="newDocument.employeeId">
                                    <option selected="selected" 
                                            disabled 
                                            value="0">
                                        Выберите сотрудника
                                    </option>
                                    <option v-for="employee in employees" 
                                            :value="employee.id" 
                                            :key="employee.id">
                                                {{employee.fullName}}
                                    </option>                          
                                </select>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('credit_id')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <template v-if="currentSalary.amount">
                        <div class="row">
                            <div class="col-md-8">
                                {{currentSalary.salaryDescription}}
                            </div>
                            <div class="col-md-4">
                                <p class="text-right" @click="takeThisSum" >
                                    {{currentSalary.amount }}
                                </p>
                            </div>                        
                        </div>
                        <template  v-if="currentSalary.salaryCode=='percent'">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="dateInterval" value="dates" v-model="salaryPercentMode">
                                            <label for="dateInterval" class="custom-control-label">Диапазон дат</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="shiftInterval" value="shift" v-model="salaryPercentMode">
                                            <label for="shiftInterval" class="custom-control-label">Смена</label>
                                        </div>
                                    </div>
                                </div>                
                            </div>
                            <div class="row" v-if="salaryPercentMode == 'dates'">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Начальная дата</label>                                
                                        <input  type="date" 
                                                name="dateBegin" 
                                                id="dateBegin" 
                                                v-model="dateBegin"
                                                class="form-control datetimepicker-input">                                                                    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Конечная дата</label>                                
                                        <input  type="date" 
                                                name="dateEnd" 
                                                id="dateEnd"
                                                :min="dateBegin"
                                                v-model="dateEnd"
                                                :disabled="!dateBegin"
                                                class="form-control datetimepicker-input">                                                                    
                                    </div>
                                </div>                        
                            </div>
                            <div class="row" v-if="salaryPercentMode == 'shift'">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Смена</label>
                                        <select class="form-control select2"
                                                style="width: 100%;"
                                                @change="calculateShiftSalary($event)"
                                                v-model="shift.id">
                                            <option selected="selected"
                                                    disabled
                                                    value="0">
                                                Выберите смену
                                            </option>
                                            <option v-for="shift in shifts"
                                                    :value="shift.id"
                                                    :key="shift.id">
                                                        {{shift.department}} [ {{shift.dateBegin}} - {{shift.dateEnd}} ]
                                            </option>
                                        </select>    
                                        <!-- <button type="button" class="btn btn-info" @click="saveDoc">Сохранить</button>                                             -->
                                    </div>
                                </div>                                
                            </div>
                        </template>
                        <div class="row" v-if="currentSalary.salaryCode=='daily'">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Начальная дата</label>                                
                                    <input  type="date" 
                                            name="dateBegin" 
                                            id="dateBegin" 
                                            v-model="dateBegin"
                                            class="form-control datetimepicker-input">                                                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Конечная дата</label>                                
                                    <input  type="date" 
                                            name="dateEnd" 
                                            id="dateEnd" 
                                            :min="dateBegin"
                                            v-model="dateEnd"
                                            :disabled="!dateBegin"
                                            class="form-control datetimepicker-input">                                                                    
                                </div>
                            </div>                        
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Касса</label>
                                    <select class="form-control select2"
                                            style="width: 100%;"
                                            v-bind:class="{'is-invalid' : hasError('debet_id')}"
                                            v-model="newDocument.cashId">
                                        <option selected="selected"
                                                disabled
                                                value="0">
                                            Выберите кассу
                                        </option>
                                        <option v-for="cash in cashes"
                                                :value="cash.id"
                                                :key="cash.id">
                                                    {{cash.name}}
                                        </option>
                                    </select>
                                    <span   id="supplier-error"
                                            class="error invalid-feedback">
                                                {{getError('debet_id')}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Сумма</label>                    
                                    <input  type="text" 
                                            name="amount" 
                                            id="amount" 
                                            class="form-control" 
                                            v-bind:class="{'is-invalid' : hasError('debet')}"
                                            v-model="newDocument.amount">
                                    <span   id="supplier-error" 
                                            class="error invalid-feedback">
                                                {{getError('debet')}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                  <div class="form-group">
                                    <label>Основание</label>                    
                                    <textarea   name="purpose" 
                                                id="purpose" 
                                                class="form-control" 
                                                rows="3"
                                                v-bind:class="{'is-invalid' : hasError('purpose')}"
                                                v-model="newDocument.purpose">
                                    </textarea>
                                    <span   id="supplier-error" 
                                            class="error invalid-feedback">
                                                {{getError('purpose')}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="modal-footer justify-content-between">
                    <!-- data-dismiss="modal" -->
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal">Close</button>
                    <!-- <div class="custom-control custom-switch" v-if="filter.isFiltered">
                        <input type="checkbox" id="useFilter" class="custom-control-input" v-model="useFilter">
                        <label for="useFilter" class="custom-control-label">Use filter</label>
                    </div> -->
                    <button type="button" class="btn btn-primary" @click="saveDoc">Сохранить</button>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import FormValidator from '../../mixins/FormValidator';

export default {
    name: 'SalesRevenueForm',
    mixins: [FormValidator],
    data() {
        return {
            newDocument: {
                date                : moment().format("YYYY-MM-DD"),
                cashId              : 0,
                employeeId          : 0,                
                purpose             : '',
                amount              : 0,
            },   
            // useFilter: false        
            currentSalary: {},
            dateBegin               :   null,
            dateEnd                 :   null,
            salaryPercentMode       :   'dates',
            shifts                  :   [],
            shift: {
                id                  :   0,
                dateBegin           :   null,
                dateEnd             :   null
            }
        }        
    },
    methods: {
        ...mapActions(['getEmployeesDictionary', 'getCashesDictionary', 'saveDocument']),
        saveDoc() {
            let doc = {
                    date                : this.newDocument.date,
                    debet_id            : this.newDocument.cashId,
                    credit_id           : this.newDocument.employeeId,                    
                    purpose             : this.newDocument.purpose,
                    debet               : this.newDocument.amount
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
        getEmployeeSalary(date) {
            axios.get(`api/employees/${this.newDocument.employeeId}/current-salary/${this.newDocument.date}`,
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => this.currentSalary = res.data.data);
        },
        closeModal() {        
            this.clearForm();
        },
        calculateShiftSalary(e) {            
            axios.get(`api/shift-salary/${this.shift.id}/${this.newDocument.employeeId}`,
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                )
                .then(res => this.newDocument.amount = res.data.salary);
        },
        clearForm() {
            this.errors = [];
            this.newDocument.date           = moment().format("YYYY-MM-DD");
            this.newDocument.employeeId     = 0;            
            this.newDocument.cashId         = 0;
            this.newDocument.purpose        = "";
            this.newDocument.amount         = 0;
            this.useFilter                  = false;

            this.dateBegin                  = null;
            this.dateEnd                    = null;
            this.salaryPercentMode          = 'dates';
        },
        takeThisSum() {
            this.newDocument.amount = this.currentSalary.amount
        }
    },
    computed: {
        ...mapGetters(['employees', 'cashes', 'filter'])

    },
    watch: {
        'newDocument.date'(newValue, oldValue) {    
            this.getEmployeesDictionary(this.newDocument.date);
        },
        'newDocument.employeeId'(newValue, oldValue) {
            if (newValue == 0) {
                this.currentSalary = {};
                this.errors = [];
            } else {
                this.dateBegin = null;
                this.dateBegin = null;
                this.newDocument.amount = 0;                
                this.errors = [];
                this.getEmployeesDictionary(this.newDocument.date);
            }            
        },
        'newDocument.amount'(newValue, oldValue) {
            let purpose = '';
            
            if (this.currentSalary.salaryCode == 'salary' && newValue > 0) {
                let year    = this.newDocument.date.substring(0,4);
                let month   = '';
                switch (Number(this.newDocument.date.substring(5,7))) {
                    case 1:
                        month = 'январь'
                        break;
                    case 2:
                        month = 'февраль'
                        break;
                    case 3:
                        month = 'март'
                        break;       
                    case 4:
                        month = 'апрель'
                        break;
                    case 5:
                        month = 'май'
                        break;
                    case 6:
                        month = 'июнь'
                        break;
                    case 7:
                        month = 'июль'
                        break;
                    case 8:
                        month = 'август'
                        break;
                    case 9:
                        month = 'сентябрь'
                        break;
                    case 10:
                        month = 'октябрь'
                        break;
                    case 11:
                        month = 'ноябрь'
                        break;
                    case 12:
                        month = 'декабрь'
                        break;
                    default:
                        month = ''
                        break;
                }

                if (newValue == this.currentSalary.amount) {
                    purpose = `Начисленная зарплата за ${month} ${year}г.`;
                } else {
                    purpose = `Аванс за ${month} ${year}г.`;
                }
            }

            if (this.currentSalary.salaryCode == 'daily' && newValue > 0) {
                if (this.dateBegin) {
                    purpose = `Начисленная зарплата за ${moment(this.dateBegin).format('DD.MM.YYYY')}`;
                } 
                if (this.dateEnd) {
                    let days_count = 
                    purpose = `Начисленная зарплата за период с ${moment(this.dateBegin).format('DD.MM.YYYY')} по ${moment(this.dateEnd).format('DD.MM.YYYY')}` ;
                }
                
                // console.log('Daily purpose: ' + purpose);
            }

            if (this.currentSalary.salaryCode == 'percent' && newValue > 0) {
                // if (this.dateBegin) {
                    purpose = `${this.currentSalary.salaryDescription} на отделе ${this.shifts.data.department} за период с ${this.shifts.data.dateBegin} по ${this.shifts.data.dateEnd}`;
                // } 
                // if (this.dateEnd) {
                //     let days_count = 
                //     purpose = `Начисленная зарплата за период с ${moment(this.dateBegin).format('DD.MM.YYYY')} по ${moment(this.dateEnd).format('DD.MM.YYYY')}` ;
                // }                
                // console.log('Daily purpose: ' + purpose);
            }
            
            this.newDocument.purpose = purpose;
        },
        salaryPercentMode(newValue, oldValue) {
            if (newValue == 'shift') {
                
                axios.get(`/api/employees-shifts/${this.newDocument.employeeId}`,
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => this.shifts = res.data);
            } else {
                this.shift = {
                    id: 0
                };
            }
        },
        dateBegin(newValue, oldValue) {
            if (this.currentSalary.salaryCode == 'daily') {
                this.newDocument.amount = this.currentSalary.amount;
                // this.newDocument.purpose = "Начисленная зарплата за " + this.dateBegin;
            }
        },
        dateEnd(newValue, oldValue) {
            if (this.currentSalary.salaryCode == 'daily') {
                dateBegin = moment(this.dateBegin, "Y-m-d");
                dateEnd   = moment(this.dateEnd, "Y-m-d");
                let days  = dateEnd.diff(dateBegin, "days") + 1 ;
                console.log(days);
                this.newDocument.amount = this.currentSalary.amount * days;
                this.newDocument.purpose = "Начисленная зарплата за период с " + this.dateBegin + " по " + this.dateEnd;
            }
        },
        useFilter() {
            // console.log(`newValue: ${newValue} | oldValue: ${oldValue}`);
             if (this.useFilter) {
                 // Use filter date if set
                if (this.filter.date) {
                    document.getElementById('date').setAttribute("min", this.filter.date)
                }
                // Use supplier if set
                if (this.filter.cashId) {
                    this.newDocument.cashId = this.filter.cashId
                }
                // Use department if set
                if (this.filter.departmentId) {
                    this.newDocument.departmentId = this.filter.departmentId
                }
            } else {
                document.getElementById('date').value = new Date().toISOString().slice(0,10);
                this.newDocument.date = new Date().toISOString().slice(0,10);
                this.newDocument.cashId = 0;
                this.newDocument.departmentId = 0;                
                this.newDocument.amount = 0;                
            }    
        },
    },
    created() {
        this.getEmployeesDictionary();
        this.getCashesDictionary();
    }
}
</script>