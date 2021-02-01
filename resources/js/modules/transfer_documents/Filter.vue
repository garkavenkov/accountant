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
                            <select-field caption="Отдел передает"
                                    hint="Все отделы"
                                    :disabledHint=false
                                    :options="departmentsGive"
                                    v-model="filter.debetId"
                                    name="name">
                            </select-field>                           
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                             <select-field caption="Отдел принимает"
                                    hint="Все отделы"
                                    :disabledHint=false
                                    :options="departmentsTake"
                                    v-model="filter.creditId"
                                    name="name">
                            </select-field>                            
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
    name: 'TransferDocumentFilterForm',
    data() {
        return {
            departmentsTake: this.departmentsGive
        }
    },
    methods: {
        ...mapActions(['getDepartmentsDictionary', 'applyFilter']),
        resetFilter() {
            this.filter.dateBegin       =   null;
            this.filter.dateEnd         =   null;
            this.filter.debetId         =   0;
            this.filter.creditId        =   0;
            this.filter.sum1Begin       =   0;
            this.filter.sum1End         =   0;
            this.filter.isFiltered      =   false;
            this.filter.queryStr        =   '';
            document.getElementById('dateBegin').value = new Date().toISOString().slice(0,10);
            document.getElementById('dateEnd').value = "";
        },      
    },
    computed: {
        ...mapGetters(['filter', 'departmentsGive'])
    },
    created() {
        this.getDepartmentsDictionary()
    },
    watch: {
        'filter.debetId'(newValue, oldValue) {     
            if (newValue != 0 ) {                
                this.departmentsTake = this.departmentsGive.filter(department => 
                    department.id != this.filter.debetId
                );                        
            } else {
                this.departmentsTake = this.departmentsGive;
            }
        }
    },
    components: {
        SelectField
    }
}
</script>