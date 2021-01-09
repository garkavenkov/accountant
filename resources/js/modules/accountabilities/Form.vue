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
                                <label>Касса</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        name="cash"
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Подотчетное лицо</label>
                                <select class="form-control select2" 
                                        name="employee"
                                        id="employee"
                                        style="width: 100%;" 
                                        v-bind:class="{'is-invalid' : hasError('credit_id')}"
                                        v-model="newDocument.employeeId">
                                    <option selected="selected" disabled value="0">
                                        Выбирите подотчетное лицо
                                    </option>
                                    <option v-for="employee in employees" 
                                            :value="employee.id" 
                                            :key="employee.id">
                                                {{employee.fullName}}
                                    </option>                          
                                </select>
                                <span   id="employee-error" 
                                        class="error invalid-feedback">
                                            {{getError('credit_id')}}
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
                                <label>Назначение</label>
                                <textarea   class="form-control" 
                                            name="purpose"
                                            id="purpose"
                                            v-bind:class="{'is-invalid' : hasError('purpose')}"
                                            v-model="newDocument.purpose"    
                                            rows="3" 
                                            placeholder="Назначение платежа">
                                </textarea>                               
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('purpose')}}
                                </span>
                            </div>
                        </div>       
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
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

import Grid from '../../components/Grid';
import FormValidator from '../../mixins/FormValidator';

export default {
    name: 'AccountabilityForm',
    mixins: [FormValidator],
    data() {
        return {
            newDocument: {
                date                : new Date().toISOString().slice(0,10),
                cashId              : 0,
                employeeId          : 0,           
                purpose             : '',
                amount              : 0,
            },   
            useFilter: false,
        }        
    },
    methods: {
        ...mapActions(['saveDocument', 'getCashesDictionary',  'getEmployeesDictionary']),
        saveDoc() {
            let doc = {
                    date                : this.newDocument.date,
                    debet_id            : this.newDocument.cashId,
                    credit_id           : this.newDocument.employeeId,
                    purpose             : this.newDocument.purpose,
                    debet               : this.newDocument.amount,
                }
            this.saveDocument(doc)
                .then(res => {
                    this.clearForm();
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
        },
        clearForm() {
            this.errors = [];
            this.newDocument.amount         = 0;
            this.newDocument.cashId         = 0;
            this.newDocument.date           = null;
            this.newDocument.employeeId     = 0;
            this.newDocument.purpose        = '';
            this.useFilter                  = false;
        },
    },
    computed: {
        ...mapGetters(['filter', 'cashes', 'employees']),
    },
    watch: {
        'newDocument.employeeId'() {
            if (this.newDocument.employeeId != 0) {
                let el = document.getElementById('employee');
                let employee = el.options[el.selectedIndex].text;                
                this.newDocument.purpose = `Выдача наличности под отчет сотруднику ${employee}`;
            }
        },
        useFilter() {
            // console.log(`newValue: ${newValue} | oldValue: ${oldValue}`);
             if (this.useFilter) {
                 // Use filter date if set
                if (this.filter.dateBegin) {
                    document.getElementById('date').setAttribute("min", this.filter.dateBegin)
                }
                if (this.filter.dateEnd) {
                    document.getElementById('date').setAttribute("max", this.filter.dateEnd)
                }

                // Use supplier if set
                if (this.filter.debetId) {
                    this.newDocument.cashId = this.filter.debetId
                }
                // Use department if set
                if (this.filter.creditId) {
                    this.newDocument.employeeId = this.filter.creditId
                }
            } else {
                document.getElementById('date').value = new Date().toISOString().slice(0,10);
                this.newDocument.date = new Date().toISOString().slice(0,10);
                this.newDocument.cashId = 0;
                this.newDocument.employeeId = 0;
                this.newDocument.amount = 0;                
            }    
        },
    },
    created() {
        // this.getCashesDictionary();
        // this.getSuppliersDictionary();
    },
}
</script>