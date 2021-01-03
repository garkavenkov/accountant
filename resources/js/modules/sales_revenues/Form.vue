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
                    <!-- <div class="row"> -->
                        <div class="col-md-12">                 
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

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Касса</label>
                                <select class="form-control select2" 
                                        style="width: 100%;" 
                                        @change="getDepartmentsDictionary(newDocument.cashId)"
                                        v-bind:class="{'is-invalid' : hasError('credit_id')}"
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
                                            {{getError('credit_id')}}
                                </span>
                            </div>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Отдел</label>
                                <select class="form-control select2" 
                                        style="width: 100%;" 
                                         v-bind:class="{'is-invalid' : hasError('debet_id')}"
                                        v-model="newDocument.departmentId">
                                    <option selected="selected" disabled value="0">
                                        Выбирите отдел
                                    </option>
                                    <option v-for="department in departments" 
                                            :value="department.id" 
                                            :key="department.id">
                                                {{department.name}}
                                    </option>                          
                                </select>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('debet_id')}}
                                </span>
                            </div>
                        </div>                        
                    <!-- </div> -->
                    <!-- <div class="row">                         -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Сумма</label>                    
                                <input  type="text" 
                                        name="amount" 
                                        id="amount" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('credit')}"
                                        v-model="newDocument.amount">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('credit')}}
                                </span>
                            </div>
                        </div>
                    <!-- </div> -->
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
                cashId              : 0,
                departmentId        : 0,                
                amount              : 0,
            },   
            useFilter: false        
        }        
    },
    methods: {
        ...mapActions(['getCashesDictionary',  'getDepartmentsDictionary', 'saveDocument']),
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
            this.useFilter  = false;
        },
        clearForm() {
            this.errors = [];
            this.newDocument.amount         = 0;
            
            this.newDocument.cashId         = this.filter.creditId ? this.filter.creditId :  0 ;
            this.newDocument.date           = this.filter.dateBegin ? this.filter.dateBegin :null;
            this.newDocument.departmentId   = this.filter.debetId ? this.filter.debetId : 0;
            
        },
    },
    computed: {
        ...mapGetters(['cashes', 'departments', 'filter'])
    },
    watch: {
        useFilter() {
            // console.log(`newValue: ${newValue} | oldValue: ${oldValue}`);
             if (this.useFilter) {
                 // Use filter date if set
                if (this.filter.dateBegin) {
                    document.getElementById('date').setAttribute("min", this.filter.dateBegin)
                    this.newDocument.date = this.filter.dateBegin;
                }
                // Use supplier if set
                if (this.filter.creditId) {
                    this.newDocument.cashId = this.filter.creditId
                }
                // Use department if set
                if (this.filter.debetId) {
                    this.newDocument.departmentId = this.filter.debetId
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