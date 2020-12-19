<template>
    <div class="modal fade" id="modal-new-document">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Новая смена</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">                    
                        <div class="col-md-12">
                            <select-field caption="Отдел"
                                    hint="Виберите отдел"
                                    :options="departments"                            
                                    v-model="shift.departmentId"
                                    :error="errors['department_id']">
                            </select-field>
                            <!-- <div class="form-group">
                                <label>Отдел</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        v-bind:class="{'is-invalid' : hasError('department_id')}"
                                        v-model="shift.departmentId">
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
                            </div> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Начальная дата</label>                                
                                <input  type="date" 
                                        name="dateBegin" 
                                        id="dateBegin" 
                                        v-model="shift.dateBegin"
                                        v-bind:class="{'is-invalid' : hasError('date_begin')}"
                                        class="form-control datetimepicker-input">                                                                    
                                <span   id="date_begin-error" 
                                        class="error invalid-feedback">
                                            {{getError('date_begin')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Конечная дата</label>                                
                                  <!-- :min="shift.dateBegin" -->
                                <input  type="date" 
                                        name="dateEnd" 
                                        id="dateEnd"
                                      
                                        v-model="shift.dateEnd"
                                        :disabled="!shift.dateBegin"                                        
                                        class="form-control datetimepicker-input"
                                        v-bind:class="{'is-invalid' : hasError('date_end')}">
                                <span   id="date_end-error" 
                                        class="error invalid-feedback">
                                            {{getError('date_end')}}
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

import SelectField      from '../../components/SelectField';
import FormValidator from '../../mixins/FormValidator';

export default {
    name: 'ShiftForm',
    mixins: [FormValidator],
    data() {
        return {
            shift: {
                departmentId        : 0,                
                dateBegin           : null,
                dateEmd             : null,
            },            
        }        
    },
    methods: {
        ...mapActions(['getDepartmentsDictionary', 'saveDocument']),
        saveDoc() {
            let doc = {
                    department_id   : this.shift.departmentId,
                    date_begin      : this.shift.dateBegin,
                    date_end        : this.shift.dateEnd,                    
                }
            this.saveDocument(doc)
                .then(res => {
                    this.clearForm();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        title:'Good job!',
                        text:'Смена успешно создана',
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
            this.shift.departmentId = 0;            
            this.shift.dateBegin    = null;
            this.shift.dateEnd      = null;
        },
    },
    computed: {
        ...mapGetters(['departments'])
    },
    components: {
        SelectField
    },
    watch: {
        'shift.departmentId'(newValue, oldValue) {
            if (this.hasError('department_id')) {
                delete this.errors.department_id;
            }
        },
        'shift.dateBegin'(newValue, oldValue) {
            if (this.hasError('date_begin')) {
                delete this.errors.date_begin;
            }
        },
        'shift.dateEnd'(newValue, oldValue) {
            if (this.hasError('date_end')) {
                delete this.errors.date_end;
            }
        }
    }
}
</script>