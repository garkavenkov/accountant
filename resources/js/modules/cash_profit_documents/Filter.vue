<template>
    <div class="modal fade" id="modal-filter-document">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Фильтр документ</h4>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Касса</label>
                            <select class="form-control select2" 
                                    style="width: 100%;"
                                    v-model="filter.creditId">
                                <option selected="selected" value="0">
                                    Выберите кассу
                                </option>
                                <option v-for="cash in cashes" 
                                        :value="cash.id" 
                                        :key="cash.id">
                                            {{cash.name}}
                                </option>                          
                            </select>
                        </div>
                    </div>
                    
                    <!-- <div class="col-md-12">
                        <div class="form-group">
                            <label>Группа расходов</label>
                            <select class="form-control select2" 
                                    style="width: 100%;"
                                    v-model="groupId"
                                    @change="getExpenseCaterogories">
                                <option selected="selected" value="0">
                                    Все группы расходов
                                </option>
                                <option v-for="group in groups" 
                                        :value="group.id" 
                                        :key="group.id">
                                            {{group.name}}
                                </option>                          
                            </select>
                        </div>
                    </div>                                                
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Категория расходов</label>
                            <select class="form-control select2" 
                                    style="width: 100%;"
                                    v-model="categoryId"
                                    :disabled="groupId == 0"
                                    @change="getExpenses">
                                <option selected="selected" value="0">
                                    Все категории расходов
                                </option>
                                <option v-for="category in categories" 
                                        :value="category.id" 
                                        :key="category.id">
                                            {{category.name}}
                                </option>                          
                            </select>
                        </div>
                     </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Статья расходов</label>
                            <select class="form-control select2" 
                                    style="width: 100%;"
                                    :disabled="categoryId == 0"
                                    v-model="expenseId">
                                <option selected="selected" value="0">
                                    Все статьи расходов
                                </option>
                                <option v-for="expense in expenses" 
                                        :value="expense.id" 
                                        :key="expense.id">
                                            {{expense.name}}
                                </option>                          
                            </select>
                        </div>
                    </div> -->
                    <!-- <div class="row">                         -->
                        <!-- <div class="col-md-12">
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
                        </div> -->
                    <!-- </div> -->
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
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import FormValidator from '../../mixins/FormValidator';

export default {
    name: 'CashProfitDocumentsFilter',
    mixins: [FormValidator],
    data() {
        return {            
            groups: [],
            groupId: 0,
            categories: [],
            categoryId: 0,
            expenses: [],
            expenseId: 0
        }        
    },
    methods: {
        ...mapActions(['getCashesDictionary',  'getDictionary', 'applyFilter']),
        getProfitCaterogories() {
            this.getDictionary(`ProfitItem?owner_id=${this.groupId}`)
                .then(res => {
                    this.categories = res
                });

        },
        getProfits() {
            this.getDictionary(`ProfitItem?owner_id=${this.categoryId}`)
                .then(res => {
                    this.expenses = res
                });
        },
        resetFilter() {
            this.filter.dateBegin       =   moment().format('YYYY-MM-DD');
            this.filter.dateEnd         =   null;
            this.filter.cashId          =   0;
            this.filter.profitId        =   0;
            this.filter.sum1Begin       =   0;
            this.filter.sum1End         =   0;
            this.filter.isFiltered      =   false;
            this.filter.queryStr        =   '';
            // document.getElementById('dateBegin').value = new Date().toISOString().slice(0,10);
            // document.getElementById('dateEnd').value = "";
        },        
    },
    computed: {
        ...mapGetters(['cashes', 'filter'])
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