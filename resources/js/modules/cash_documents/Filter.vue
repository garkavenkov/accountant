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
                            <label>Тип операции</label>                                
                            <select class="form-control select2" 
                                    style="width: 100%;"
                                    v-model="filter.operationId">
                                <option selected="selected" value="0">
                                    Все операции
                                </option>
                                <option v-for="type in types" 
                                        :value="type.id" 
                                        :key="type.id">
                                            {{type.name}}
                                </option>                          
                            </select>                                
                        </div>
                    </div>
                </div>                    
                <div class="row">
                    <div class="col-md-12">
                         <div class="form-group">
                            <label>Дебет</label>
                            <!-- <select class="form-control select2" 
                                    style="width: 100%;"
                                    v-model="filter.departmentId">
                                <option selected="selected"
                                        value="0">
                                    Все отделы
                                </option>
                                <option v-for="department in departments" 
                                        :value="department.id" 
                                        :key="department.id">
                                            {{department.name}}
                                </option>                          
                            </select> -->
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
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'CashDocumentFilterForm',
    data() {
        return {
            // filter: {
            //     dateBegin: null,
            //     dateEnd: null,
            //     sumBegin: 0,
            //     sumEnd: 0,
            //     typeId: 0,
            // },
            types: []
        }
    },
    methods: {
        ...mapActions('CashDocument',   ['applyFilter']),
        
        resetFilter() {

        },
        getOperationTypes() {
            axios
                .get(`/api/select-dictionary/CashOperation`, 
                    {
                       'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => this.types = res.data);            
        }
    },
    computed: {
        ...mapGetters('CashDocument', ['filter'])
    },
    created() {
        this.getOperationTypes();
    }
}
</script>