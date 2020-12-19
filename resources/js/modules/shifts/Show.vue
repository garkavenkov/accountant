<template>

<div>
    <router-link to="/">Back</router-link>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">                    
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <h3 class="text-center">{{shift.department}}</h3>                            
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <strong><i class="fas fa-user-plus mr-1"></i> Начало смены</strong>
                                    <a class="float-right">{{shift.dateBegin}}</a>
                                </li>
                                <li class="list-group-item">
                                    <strong><i class="fas fa-user-minus mr-1"></i> Окончание смены</strong>
                                    <a class="float-right">{{shift.dateEnd}}</a>
                                </li>
                            </ul>                        
                        </div>                       
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-danger" @click="deleteShift">Удалить</button>
                    </div>          
                </div>
            </div>            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">                                
                            <li class="nav-item"><a class="nav-link active" href="#employees" data-toggle="tab">Сотрудники</a></li>
                            <li class="nav-item"><a class="nav-link" href="#miscelaneous" data-toggle="tab">Miscellaneous</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="employees">
                                <button class="btn btn-primary"
                                        data-toggle="modal" 
                                        data-target="#modal-add-employee"
                                        data-backdrop="static" 
                                        data-keyboard="true">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <!-- <button type="button" class="btn btn-primary" @click="addEmployee">Добавить</button> -->
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <!-- <th style="width: 2%">
                                                #
                                            </th>                                             -->
                                            <th style="width: 90%">
                                                Фамилия И.О.
                                            </th>
                                            <th style="width: 10%">
                                                
                                            </th>
                                            <!-- <th style="width: 10%" class="text-center">
                                                Status
                                            </th>                                                 -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="employee in shift.employees" :key="employee.id">
                                            <td>{{employee.full_name}}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger" @click="removeEmployee(employee.id)" title="Удалить сотрудника из смены">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="miscelaneous">
                                <form class="form-horizontal">                                    
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                          <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                    <!-- /.nav-tabs-custom -->
            </div>              
        </div>            
    </div>
    <employee-form :shiftId = "id" />
    
</div>

</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import EmployeeForm from './EmployeeForm.vue';

export default {
    components: { EmployeeForm },
    name: 'ShiftsShow',
    props: ['id'],
    data() {
        return {
            // shift: {
            //     employees: []
            // }
        }
    },
    methods: {
        ...mapActions(['fetchDocument', 'deleteDocument', 'getEmployeesDictionary', 'removeEmployeeFromShift']),
        deleteShift() {
            this.deleteDocument(this.id)
                .then(res => {
                      Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        // title:'Good job!',
                        text:'Смена успешно удалена',
                        icon:'success',
                    });                    
                    this.$router.go(-1);
                })
        },
        removeEmployee(employeeId) {            
            this.removeEmployeeFromShift({shiftId:this.id, employeeId})
                .then(res => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        // title:'Good job!',
                        text: res.data.message,
                        icon:'success',
                    });                    
                });
        }
    },
    computed: {
        ...mapGetters(['shift'])
    },
    created() {
        this.fetchDocument(this.id);
    }
}
</script>