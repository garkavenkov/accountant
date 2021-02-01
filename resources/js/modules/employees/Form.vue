<template>
    <div class="modal fade" id="modal-new-employee">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Новый сотрудник</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                                        
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Фамилия</label>                    
                                <input  type="text" 
                                        name="surname" 
                                        id="surname" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('surname')}"
                                        v-model="newEmployee.surname">
                                <span   id="surname-error" 
                                        class="error invalid-feedback">
                                            {{getError('surname')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Имя</label>                    
                                <input  type="text" 
                                        name="name" 
                                        id="name" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('name')}"
                                        v-model="newEmployee.name">
                                <span   id="name-error" 
                                        class="error invalid-feedback">
                                            {{getError('name')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Отчество</label>                    
                                <input  type="text" 
                                        name="patronymic" 
                                        id="patronymic" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('patronymic')}"
                                        v-model="newEmployee.patronymic">
                                <span   id="patronymic-error" 
                                        class="error invalid-feedback">
                                            {{getError('patronymic')}}
                                </span>
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Описание</label>                    
                                <textarea   name="address" 
                                            id="address" 
                                            class="form-control" 
                                            rows="2"
                                            v-bind:class="{'is-invalid' : hasError('address')}"
                                            v-model="newEmployee.address">
                                </textarea>
                                <span   id="address-error"
                                        class="error invalid-feedback">
                                        {{getError('address')}}
                                </span>
                            </div>
                        </div>
                    </div>             
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Должность</label>
                                <select class="form-control select2"
                                        style="width: 100%;"
                                        v-bind:class="{'is-invalid' : hasError('position_id')}"
                                        v-model="newEmployee.positionId">
                                    <option selected="selected"
                                            disabled
                                            value="0">
                                        Выберите должность
                                    </option>
                                    <option v-for="position in positions"
                                            :value="position.id"
                                            :key="position.id">
                                                {{position.name}}
                                    </option>
                                </select>
                                <span   id="supplier-error"
                                        class="error invalid-feedback">
                                            {{getError('position_id')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Отдел</label>
                                <select class="form-control select2"
                                        style="width: 100%;"
                                        v-bind:class="{'is-invalid' : hasError('department_id')}"
                                        v-model="newEmployee.departmentId">
                                    <option selected="selected"
                                            disabled
                                            value="0">
                                        Выберите отдел
                                    </option>
                                    <option v-for="department in departments"
                                            :value="department.id"
                                            :key="department.id">
                                                {{department.name}}
                                    </option>
                                </select>
                                <span   id="department-error"
                                        class="error invalid-feedback">
                                            {{getError('department_id')}}
                                </span>
                            </div>
                        </div>                        
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Дата рождения</label>
                                <input  type="date" 
                                        name="birthdate" 
                                        id="birthdate" 
                                        class="form-control datetimepicker-input" 
                                        v-bind:class="{'is-invalid' : hasError('birthdate')}"
                                        v-model="newEmployee.birthdate">
                                <span   id="birthdate-error" 
                                        class="error invalid-feedback">
                                            {{getError('birthdate')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Принят</label>
                                <input  type="date" 
                                        name="hired" 
                                        id="hired" 
                                        class="form-control datetimepicker-input" 
                                        v-bind:class="{'is-invalid' : hasError('hired')}"
                                        v-model="newEmployee.hired">                                
                                <span   id="hired-error" 
                                        class="error invalid-feedback">
                                            {{getError('hired')}}
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
    name: 'EmployeeForm',
    mixins: [FormValidator],
    data() {
        return {
            newEmployee: {
                departmentId        : 0,
                positionId          : 0,
                surname             : '',
                name                : '',
                patronymic          : '',
                address             : '',
                birthdate           : null,
                hired               : new Date().toISOString().slice(0,10),
                fired               : null
            },
        }        
    },
    methods: {
        ...mapActions(['saveDocument', 'getDepartmentsDictionary', 'getPositionsDictionary']),        
        saveDoc() {
            let doc = {
                    department_id       : this.newEmployee.departmentId,
                    position_id         : this.newEmployee.positionId,
                    surname             : this.newEmployee.surname,
                    name                : this.newEmployee.name,
                    patronymic          : this.newEmployee.patronymic,
                    address             : this.newEmployee.address,
                    birthdate           : this.newEmployee.birthdate,
                    hired               : this.newEmployee.hired,
                    fired               : this.newEmployee.fired                    
                }
            this.saveDocument(doc)
                .then(res => {
                    this.clearForm();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        text:'Сотрудник успешно добавлен',
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
            this.newEmployee.departmentId   =   0;
            this.newEmployee.positionId     =   0;
            this.newEmployee.surname        =   '';
            this.newEmployee.name           =   '';
            this.newEmployee.patronymic     =   '';
            this.newEmployee.address        =   '';
            this.newEmployee.birthdate      =   null;
            this.newEmployee.hired          =   null;
            this.newEmployee.fired          =   null;
        },        
    },
    computed: {     
        ...mapGetters(['departments', 'positions'])
    },
    watch: {
    },
    created() {
        this.getDepartmentsDictionary();        
        this.getPositionsDictionary();        
    },
    components: {        
    }
}
</script>