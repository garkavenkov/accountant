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
                                <label>Группа доходов</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="groupId"
                                        @change="getProfitCaterogories">
                                    <option selected="selected" disabled value="0">
                                        Выберите группу доходов
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
                                <label>Категория доходов</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="categoryId"
                                        @change="getProfits">
                                    <option selected="selected" disabled value="0">
                                        Выберите категорию доходов
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
                                <label>Статья доходов</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-bind:class="{'is-invalid' : hasError('debet_id')}"
                                        v-model="newDocument.profitId">
                                    <option selected="selected" disabled value="0">
                                        Выберите статью доходов
                                    </option>
                                    <option v-for="profit in profits" 
                                            :value="profit.id" 
                                            :key="profit.id">
                                                {{profit.name}}
                                    </option>                          
                                </select>
                                <span   id="expense-error" 
                                        class="error invalid-feedback">
                                            {{getError('debet_id')}}
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
                                        v-bind:class="{'is-invalid' : hasError('credit')}"
                                        v-model="newDocument.amount">
                                <span   id="amount-error" 
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
    name: 'CashProfitDocumentsForm',
    mixins: [FormValidator],
    data() {
        return {
            newDocument: {
                date                : null,
                cashId              : 0,
                profitId            : 0,
                purpose             : '',
                amount              : 0,
            },   
            useFilter: false,
            groups: [],
            groupId: 0,
            categories: [],
            categoryId: 0,
            profits: []
        }        
    },
    methods: {
        ...mapActions(['getCashesDictionary',  'getDictionary', 'saveDocument']),
        saveDoc() {
            let doc = {
                    date                : this.newDocument.date,
                    credit_id           : this.newDocument.cashId,
                    debet_id            : this.newDocument.profitId,
                    purpose             : this.newDocument.purpose,
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
            
            this.newDocument.cashId         = this.filter.creditId  ? this.filter.creditId  : 0 ;
            this.newDocument.date           = this.filter.dateBegin ? this.filter.dateBegin : null;
            this.newDocument.departmentId   = this.filter.debetId   ? this.filter.debetId   : 0;            
        },
        getProfitCaterogories() {
            this.getDictionary(`ProfitItem?owner_id=${this.groupId}`)
                .then(res => {
                    this.categories = res
                });

        },
        getProfits() {
            this.getDictionary(`ProfitItem?owner_id=${this.categoryId}`)
                .then(res => {
                    this.profits = res
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
                    this.newDocument.profitId = this.filter.debetId
                }
            } else {
                document.getElementById('date').value = new Date().toISOString().slice(0,10);
                this.newDocument.date = new Date().toISOString().slice(0,10);
                this.newDocument.cashId = 0;
                this.newDocument.profitId = 0;
                this.newDocument.puspose = ''
                this.newDocument.amount = 0;                
            }    
        },
    },
    created() {
        this.getCashesDictionary();
        this.getDictionary('ProfitItem?owner_id=0')
            .then(res => {
                this.groups = res
            });
    }
}
</script>