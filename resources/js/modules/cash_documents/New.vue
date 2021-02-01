<template>

<div>

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Новый кассовый документ</h3>
                <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div> -->
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Касса</label>
                            <select class="form-control select2" 
                                    style="width: 100%;" 
                                    v-bind:class="{'is-invalid' : hasError('cash_id')}"
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
                                        {{getError('cash_id')}}
                            </span>
                        </div>                  
                    </div>                    
                    <div class="col-md-4">
                        <div class="form-group">                        
                            <label>Тип докумена</label>
                            <select class="form-control select2" 
                                    style="width: 100%;"
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
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>

</div>

</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import FormValidator from '../../mixins/FormValidator';

export default {
    name: 'CashDocumentsNew',
    mixins: [FormValidator],
    data() {
        return {
            newDocument: {
                date            :   moment().format('YYYY-MM-DD'),
                cashId          :   0,
                operationId     :   0,
            }
        }
    },
    methods: {
        ...mapActions('CashDocument', ['getCashesDictionary', 'getOperationTypeDictionary'])
    },
    computed: {
        ...mapGetters('CashDocument', ['cashes', 'types'])
    },
    created() {
        this.getCashesDictionary();
        this.getOperationTypeDictionary()
    }
}
</script>