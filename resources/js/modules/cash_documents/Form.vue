<template>
    <div class="modal fade" id="modal-new-document">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Новый кассовый документ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">                 
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

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Тип докумена</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        @change="operationWasChanged(newDocument.operationId)"
                                        v-bind:class="{'is-invalid' : hasError('operation_id')}"                                        
                                        v-model="newDocument.operationId">
                                    <option selected="selected" 
                                            disabled 
                                            value="0">
                                        Выберите тип документа
                                    </option>
                                    <option v-for="type in types" 
                                            :value="type.id" 
                                            :key="type.id">
                                                {{type.name}}
                                    </option>                          
                                </select>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('operation_id')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Дебет</label>
                                <select class="form-control select2" 
                                        style="width: 100%;" 
                                         v-bind:class="{'is-invalid' : hasError('debet_id')}"
                                        v-model="newDocument.debetId">
                                    <option selected="selected" disabled value="0">
                                        Выбирите отдел
                                    </option>
                                    <option v-for="debet in debets" 
                                            :value="debet.id" 
                                            :key="debet.id">
                                                {{debet.name}}
                                    </option>                          
                                </select>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('debet_id')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Кредит</label>
                                <select class="form-control select2" 
                                        style="width: 100%;" 
                                         v-bind:class="{'is-invalid' : hasError('credit_id')}"
                                        v-model="newDocument.creditId">
                                    <option selected="selected" disabled value="0">
                                        Выбирите отдел
                                    </option>
                                    <option v-for="credit in credits" 
                                            :value="credit.id" 
                                            :key="credit.id">
                                                {{credit.name}}
                                    </option>                          
                                </select>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('credit_id')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Назначение</label>
                                <input  type="text" 
                                        name="purpose" 
                                        id="                    " 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('purpose')}"
                                        v-model="newDocument.purpose">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('purpose')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Сумма</label>                    
                                <input  type="text" 
                                        name="amount" 
                                        id="amount" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('amount')}"
                                        v-model="newDocument.amount">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('amount')}}
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
                date                : null,
                operationId         : 0,
                debetId             : 0,
                creditId            : 0,                
                amount              : 0,
            },   
            useFilter: false,
            credits: [],
            debets: []
        }        
    },
    methods: {
        ...mapActions('CashDocument', []),
        operationWasChanged(operationId) {
            console.log(operationId);
        },
        saveDoc() {
            let doc = {
                    date                : this.newDocument.date,
                    debet_id            : this.newDocument.departmentId,
                    credit_id           : this.newDocument.cashId,                    
                    credit              : parseFloat(this.newDocument.amount.replace(",", "."))
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
        closeModal() {        
            this.clearForm();
        },
        clearForm() {
            this.errors = [];
            this.newDocument.amount         = 0;
            this.newDocument.cashId         = 0;
            this.newDocument.date           = null;
            this.newDocument.departmentId   = 0;
            this.useFilter                  = false;
        },
    },
    computed: {
        ...mapGetters('CashDocument', ['filter', 'types'])
    },
    watch: {
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
        // this.getCashesDictionary();
    }
}
</script>