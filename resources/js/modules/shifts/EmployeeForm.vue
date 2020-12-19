<template>
    <div class="modal fade" id="modal-add-employee">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Выберите сорудника</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">                    
                        <div class="col-md-12">
                            <select-field caption="Сотрудник"
                                    hint="Виберите сотрудника"
                                    :options="employees"
                                    name="fullName"
                                    v-model="shift.employeeId"
                                    :error="errors['employee_id']">
                            </select-field>                            
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
    name: 'ShiftEmployeeForm',
    mixins: [FormValidator],
    props: ['shiftId'],
    data() {
        return {
            shift: {
                employeeId  : 0,                
            },            
        }        
    },
    methods: {
        ...mapActions(['saveDocument', 'getEmployeesDictionary', 'addEmployeeIntoShift']),
        saveDoc() {
            let doc = {
                    employee_id : this.shift.employeeId,
                    shift_id    : this.shiftId
                }
            this.addEmployeeIntoShift(doc)
                .then(res => {
                    this.clearForm();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        title:'Good job!',
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
            this.shift.employeeId = 0;            
        },
    },
    computed: {
        ...mapGetters(['employees'])
    },
    components: {
        SelectField
    },
    created() {
            this.getEmployeesDictionary();
    },
    watch: {
        'shift.employeeId'(newValue, oldValue) {
            if (this.hasError('department_id')) {
                delete this.errors.department_id;
            }
        }        
    }
}
</script>