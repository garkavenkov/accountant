<template>
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
                                <label>Касса</label>                                
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="filter.debetId">
                                    <option selected="selected" value="0">
                                        Все кассы
                                    </option>
                                    <option v-for="cash in cashes" 
                                            :value="cash.id" 
                                            :key="cash.id">
                                                {{cash.name}}
                                    </option>                          
                                </select>                                
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                             <div class="form-group">
                                <label>Подотчетное лицо</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="filter.creditId">
                                    <option selected="selected"
                                            value="0">
                                        Все подотчетные лица
                                    </option>
                                    <option v-for="employee in employees" 
                                            :value="employee.id" 
                                            :key="employee.id">
                                                {{employee.name}}
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
                                        name="sumBegin" 
                                        id="sumBegin"
                                        class="form-control"
                                        v-model="filter.sumBegin">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Сумма по</label>                    
                                <input  type="text" 
                                        name="sumEnd" 
                                        id="sumEnd" 
                                        class="form-control"
                                        v-model="filter.sumEnd">
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
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
    name: 'PaymentFilterForm',
    data() {
        return  {            
        }
    },
    methods: {
        ...mapActions(['applyFilter']),
         resetFilter() {
            this.filter.dateBegin       =   null;
            this.filter.dateEnd         =   null;
            this.filter.cashId          =   0;
            this.filter.supplierId      =   0;
            this.filter.sum1Begin       =   0;
            this.filter.sum1End         =   0;
            this.filter.isFiltered      =   false;
            this.filter.queryStr        =   '';
            document.getElementById('dateBegin').value = new Date().toISOString().slice(0,10);
            document.getElementById('dateEnd').value = "";
        }
    },
    computed: {
        ...mapGetters(['filter', 'cashes', 'employees']),        
    },
    created() {
        // this.getCashesDictionary();
        // this.getSuppliersDictionary();
    }

}
</script>