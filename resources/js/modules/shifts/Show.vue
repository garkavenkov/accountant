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
                                    <a class="float-right">{{shift.date_begin}}</a>
                                </li>
                                <li class="list-group-item">
                                    <strong><i class="fas fa-user-minus mr-1"></i> Окончание смены</strong>
                                    <a class="float-right">{{shift.date_end}}</a>
                                </li>
                            </ul>                        
                        </div>                       
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
</div>

</template>

<script>
export default {
    name: 'ShiftsShow',
    props: ['id'],
    data() {
        return {
            shift: {
                employees: []
            }
        }
    },
    methods: {
       fetchData() {               
            axios.get(`/api/shifts/${this.id}`, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => this.shift = res.data.data)
                .catch(err => console.log(err));
                
        },
    },
    created() {
        this.fetchData();
    }
}
</script>