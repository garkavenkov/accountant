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
                                <label>Отдел</label>                                
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="filter.creditId">
                                    <option selected="selected" value="0">
                                        Все отделы
                                    </option>
                                    <option v-for="department in departments" 
                                            :value="department.id" 
                                            :key="department.id">
                                                {{department.name}}
                                    </option>                          
                                </select>                                
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                             <div class="form-group">
                                <label>Поставщик</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-model="filter.debetId">
                                    <option selected="selected"
                                            value="0">
                                        Все поставщики
                                    </option>
                                    <option v-for="supplier in suppliers" 
                                            :value="supplier.id" 
                                            :key="supplier.id">
                                                {{supplier.name}}
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
                                        name="purchaseSumFrom" 
                                        id="purchaseSumFrom"
                                        class="form-control"
                                        v-model="filter.sum1Begin">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Сумма по</label>                    
                                <input  type="text" 
                                        name="purchaseSumTo" 
                                        id="purchaseSumTo" 
                                        class="form-control"
                                        v-model="filter.sum1End">
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

import { mapActions, mapGetters } from 'vuex';

import SelectField  from '../../components/SelectField';

export default {
    name: 'ReturnDocumentFilterForm',
    data() {
        return {
            
        }
    },
    methods: {
        ...mapActions(['applyFilter']),
        resetFilter() {
            this.filter.dateBegin       =   null;
            this.filter.dateEnd         =   null;
            this.filter.debetId         =   0;
            this.filter.sum2Begin       =   0;
            this.filter.sum2End         =   0;
            this.filter.isFiltered      =   false;
            this.filter.queryStr        =   '';
            document.getElementById('dateBegin').value = new Date().toISOString().slice(0,10);
            document.getElementById('dateEnd').value = "";
        },      
    },
    computed: {
        ...mapGetters(['filter', 'departments', 'suppliers'])
    },
    created() {
        // this.getDepartmentsDictionary()
    },
    watch: {
        'filter.date_begin'(newValue, oldValue) {
            if (!newValue) {
                var el = document.getElementById('date_end');
                el.value = ""
                this.filter.date_end = null;
            }
        },    
    },
    components: {
        SelectField
    }    
}
</script>