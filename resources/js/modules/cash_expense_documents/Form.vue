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
                                <span   id="cash-error" 
                                        class="error invalid-feedback">
                                            {{getError('debet_id')}}
                                </span>
                            </div>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Группа расходов</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="groupId"
                                        @change="getExpenseCaterogories">
                                    <option selected="selected" disabled value="0">
                                        Выберите группу расходов
                                    </option>
                                    <option v-for="group in groups" 
                                            :value="group.id" 
                                            :key="group.id">
                                                {{group.name}}
                                    </option>                          
                                </select>
                                <!-- <span   id="expense-error" 
                                        class="error invalid-feedback">
                                            {{getError('debet_id')}}
                                </span> -->
                            </div>
                        </div>                                                
                    <!-- </div> -->
                    <div class="col-md-12">
                            <div class="form-group">
                                <label>Категория расходов</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="categoryId"
                                        @change="getExpenses">
                                    <option selected="selected" disabled value="0">
                                        Выберите категорию расходов
                                    </option>
                                    <option v-for="category in categories" 
                                            :value="category.id" 
                                            :key="category.id">
                                                {{category.name}}
                                    </option>                          
                                </select>
                                <!-- <span   id="expense-error" 
                                        class="error invalid-feedback">
                                            {{getError('debet_id')}}
                                </span> -->
                            </div>
                        </div>
                          <div class="col-md-12">
                            <div class="form-group">
                                <label>Статья расходов</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-bind:class="{'is-invalid' : hasError('credit_id')}"
                                        v-model="newDocument.expenseId">
                                    <option selected="selected" disabled value="0">
                                        Выберите статью расходов
                                    </option>
                                    <option v-for="expense in expenses" 
                                            :value="expense.id" 
                                            :key="expense.id">
                                                {{expense.name}}
                                    </option>                          
                                </select>
                                <span   id="expense-error" 
                                        class="error invalid-feedback">
                                            {{getError('credit_id')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Основание</label>                    
                                <textarea   name="purpose" 
                                            id="purpose" 
                                            class="form-control" 
                                            rows="2"
                                            v-bind:class="{'is-invalid' : hasError('purpose')}"
                                            v-model="newDocument.purpose">
                                </textarea>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                        {{getError('purpose')}}
                                </span>
                            </div>
                        </div>
                    <!-- <div class="row">                         -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Сумма</label>                    
                                <input  type="text" 
                                        name="amount" 
                                        id="amount" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('debet')}"
                                        v-model="newDocument.amount">
                                <span   id="amount-error" 
                                        class="error invalid-feedback">
                                            {{getError('debet')}}
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
    name: 'CashExpenseDocumentsForm',
    mixins: [FormValidator],
    data() {
        return {
            newDocument: {
                date                : null,
                cashId              : 0,
                expenseId           : 0,
                purpose             : '',
                amount              : 0,
            },   
            useFilter: false,
            groups: [],
            groupId: 0,
            categories: [],
            categoryId: 0,
            expenses: []
        }        
    },
    methods: {
        ...mapActions(['getCashesDictionary',  'getDictionary', 'saveDocument']),
        saveDoc() {
            let doc = {
                    date                : this.newDocument.date,
                    debet_id            : this.newDocument.cashId,
                    credit_id           : this.newDocument.expenseId,
                    purpose             : this.newDocument.purpose,
                    debet               : parseFloat(this.newDocument.amount.replace(",", "."))
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
            this.useFilter  = false;
        },
        clearForm() {
            this.errors = [];
            this.newDocument.amount         = 0;
            
            this.newDocument.cashId         = this.filter.debetId   ? this.filter.debetId  : 0 ;
            this.newDocument.date           = this.filter.dateBegin ? this.filter.dateBegin : null;
            // this.newDocument.departmentId   = this.filter.debetId   ? this.filter.debetId   : 0;            
        },
        getExpenseCaterogories() {
            this.getDictionary(`ExpenseItem?owner_id=${this.groupId}`)
                .then(res => {
                    this.categories = res
                });

        },
        getExpenses() {
            this.getDictionary(`ExpenseItem?owner_id=${this.categoryId}`)
                .then(res => {
                    this.expenses = res
                });
        }
    },
    computed: {
        ...mapGetters(['cashes', 'filter'])
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
                // Use cash if set
                if (this.filter.debetId) {
                    this.newDocument.cashId = this.filter.debetId
                }
                // Use expense if set
                if (this.filter.creditId) {
                    this.newDocument.expenseId = this.filter.debetId
                }
            } else {
                document.getElementById('date').value = new Date().toISOString().slice(0,10);
                this.newDocument.date = new Date().toISOString().slice(0,10);
                this.newDocument.cashId = 0;
                this.newDocument.expenseId = 0;
                this.newDocument.puspose = ''
                this.newDocument.amount = 0;                
            }    
        },
    },
    created() {
        this.getCashesDictionary();
        this.getDictionary('ExpenseItem?owner_id=0')
            .then(res => {
                this.groups = res
            });
    }
}
</script>