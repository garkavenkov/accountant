<template>
    <div class="modal fade" id="modal-new-document">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Новый отдел</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Подразделение</label>
                            <select class="form-control select2"
                                    style="width: 100%;"
                                    v-bind:class="{'is-invalid' : hasError('branch_id')}"
                                    v-model="newDepartment.branchId">
                                <option selected="selected"
                                        disabled
                                        value="0">
                                    Выберите подразделение
                                </option>
                                <option v-for="branch in branches"
                                        :value="branch.id"
                                        :key="branch.id">
                                            {{branch.name}}
                                </option>
                            </select>
                            <span   id="supplier-error"
                                    class="error invalid-feedback">
                                        {{getError('branch_id')}}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Тип</label>
                            <select class="form-control select2"
                                    style="width: 100%;"
                                    v-bind:class="{'is-invalid' : hasError('department_type_id')}"
                                    v-model="newDepartment.typeId">
                                <option selected="selected"
                                        disabled
                                        value="0">
                                    Выберите тип
                                </option>
                                <option v-for="type in types"
                                        :value="type.id"
                                        :key="type.id">
                                            {{type.name}}
                                </option>
                            </select>
                            <span   id="supplier-error"
                                    class="error invalid-feedback">
                                        {{getError('department_type_id')}}
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Наименование</label>                    
                                <input  type="text" 
                                        name="name" 
                                        id="name" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('name')}"
                                        v-model="newDepartment.name">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('name')}}
                                </span>
                            </div>
                        </div>
                    </div>                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Описание</label>                    
                                <textarea   name="description" 
                                            id="description" 
                                            class="form-control" 
                                            rows="2"
                                            v-bind:class="{'is-invalid' : hasError('description')}"
                                            v-model="newDepartment.description">
                                </textarea>
                                <span   id="description-error"
                                        class="error invalid-feedback">
                                        {{getError('description')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Дата открытия</label>                                
                                <input  type="date" 
                                        name="opened" 
                                        id="opened" 
                                        class="form-control datetimepicker-input" 
                                        v-bind:class="{'is-invalid' : hasError('opened')}"
                                        v-model="newDepartment.opened">                                
                                <span   id="date-error" 
                                        class="error invalid-feedback">
                                            {{getError('opened')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Дата закрытия</label>                                
                                <input  type="date" 
                                        name="closed" 
                                        id="closed" 
                                        class="form-control datetimepicker-input" 
                                        v-bind:class="{'is-invalid' : hasError('closed')}"
                                        v-model="newDepartment.closed">                                
                                <span   id="date-error" 
                                        class="error invalid-feedback">
                                            {{getError('closed')}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal">Close</button>                    
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
    name: 'DepartmentForm',
    mixins: [FormValidator],
    data() {
        return {
            newDepartment: {
                branchId            : 0,
                typeId              : 0,
                name                : '',
                description         : '',
                opened              : new Date().toISOString().slice(0,10),
                closed              : null
            },
        }        
    },
    methods: {
        ...mapActions(['saveDocument', 'getDepartmentTypesDictionary', 'getBranchesDictionary']),        
        saveDoc() {
            let doc = {
                    branch_id           : this.newDepartment.branchId,
                    department_type_id  : this.newDepartment.typeId,
                    name                : this.newDepartment.name,
                    description         : this.newDepartment.description,
                    opened              : this.newDepartment.opened,
                    closed              : this.newDepartment.closed                    
                }
            this.saveDocument(doc)
                .then(res => {
                    this.clearForm();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        text:'Отдел успешно добавлен',
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
            this.newDepartment.branchId     = 0;
            this.newDepartment.typeId       = 0;
            this.newDepartment.name         = '';
            this.newDepartment.description  = '';
            this.newDepartment.opened       = null;
            this.newDepartment.closed       = null;
        },        
    },
    computed: {     
        ...mapGetters(['types', 'branches'])
    },
    watch: {
    },
    created() {
        this.getDepartmentTypesDictionary();        
        this.getBranchesDictionary();        
    },
    components: {        
    }
}
</script>