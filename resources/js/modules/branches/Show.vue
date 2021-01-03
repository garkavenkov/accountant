<template>
    <div>
        <router-link to="/">Back</router-link>
         <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <!-- <img class="profile-user-img img-fluid img-circle"
                                        src="../../dist/img/user4-128x128.jpg"
                                        alt="User profile picture"> -->
                            </div>

                            <h3 class="profile-username text-center">{{branch.name}}</h3>

                            <!-- <p class="text-muted text-center">Software Engineer</p> -->

                            <ul class="list-group list-group-unbordered mb-3">
                              <li class="list-group-item">
                                <strong><i class="fas fa-map-marker-alt mr-1"></i>Adress</strong>
                                <a class="float-right">{{branch.address}}</a>
                              </li>
                              <li class="list-group-item">
                                <b>Opened</b> <a class="float-right">{{branch.opened}}</a>
                              </li>
                              <li class="list-group-item">
                                <b>Closed</b> <a class="float-right">{{branch.closed}}</a>
                              </li>
                            </ul>

                            <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Edit Area -->
                    
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Action area</h3>
                        </div>
                     
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Education</strong>

                            <p class="text-muted">
                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>
            
                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                            <p class="text-muted">Malibu, California</p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                            <p class="text-muted">
                                <span class="tag tag-danger">UI Design</span>
                                <span class="tag tag-success">Coding</span>
                                <span class="tag tag-info">Javascript</span>
                                <span class="tag tag-warning">PHP</span>
                                <span class="tag tag-primary">Node.js</span>
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                        </div>
                     
                    </div>
                    
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#departments" data-toggle="tab">Departments</a></li>
                                <li class="nav-item"><a class="nav-link" href="#employees" data-toggle="tab">Employees</a></li>
                                <li class="nav-item"><a class="nav-link" href="#cashes" data-toggle="tab">Cashes</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="departments">                                
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <!-- <th style="width: 1%">
                                                    #
                                                </th> -->
                                                <th style="width: 25%">
                                                    Name
                                                </th>
                                                <th style="width: 45%">
                                                    Description
                                                </th>                                                
                                                <th style="width: 15%" class="text-center">
                                                    Status
                                                </th>
                                                <th style="width: 15%">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="department in branch.departments" :key="department.id">
                                                <!-- <td>
                                                    #
                                                </td> -->
                                                <td>
                                                    {{department.name}}
                                                </td>
                                                <td>
                                                    {{department.description}}
                                                </td>
                                                <td class="project-state">
                                                    <span class="badge badge-success">Активен</span>
                                                </td>
                                                <td class="project-actions text-right">
                                                    <a class="btn btn-primary btn-sm" href="/departments">
                                                        <i class="fas fa-folder">
                                                        </i>
                                                        View
                                                    </a>
                                                    <!-- <a class="btn btn-info btn-sm" href="#">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="#">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Delete
                                                    </a> -->
                                                </td>
                                            </tr>                                        
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="employees">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <!-- <th style="width: 1%">
                                                    #
                                                </th> -->
                                                <th style="width: 40%">
                                                    Фамилия И.О.
                                                </th>
                                                <th style="width: 25%">
                                                    Отдел
                                                </th>
                                                <th style="width: 25%">
                                                    Должность
                                                </th>
                                                <th style="width: 10%" class="text-center">
                                                    Status
                                                </th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="employee in branch.employees" :key="employee.id">
                                                <!-- <td>
                                                    #
                                                </td> -->
                                                <td>
                                                    {{employee.full_name}}
                                                </td>
                                                <td>
                                                    {{employee.department}}
                                                </td>
                                                <td>
                                                    {{employee.position}}
                                                </td>
                      
                                                <td class="project-state">
                                                    <span class="badge badge-success">Работает</span>
                                                </td>                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>                            
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="cashes">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <!-- <th style="width: 1%">
                                                    #
                                                </th> -->
                                                <th style="width: 100%">
                                                    Name
                                                </th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="cash in branch.cashes" :key="cash.id">
                                                <!-- <td>
                                                    #
                                                </td> -->
                                                <td>
                                                    {{cash.name}}
                                                </td>                                                
                                            </tr>                                        
                                        </tbody>
                                    </table>
                                </div>
                            <!-- /.tab-pane -->
                            </div>
                          <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    
        <!-- <div class="card">
            <div class="card-header">
                <h3 class="card-title">Projects Detail</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Estimated budget</span>
                                        <span class="info-box-number text-center text-muted mb-0">2300</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Total amount spent</span>
                                        <span class="info-box-number text-center text-muted mb-0">2000</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Estimated project duration</span>
                                        <span class="info-box-number text-center text-muted mb-0">20 </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Recent Activity</h4>
                                    <div class="post">
                                        <div class="user-block">                  
                                            <span class="username">
                                                <a href="#">Jonathan Burke Jr.</a>
                                            </span>
                                            <span class="description">Shared publicly - 7:45 PM today</span>
                                        </div>                                        
                                        <p>
                                            Lorem ipsum represents a long-held tradition for designers,
                                            typographers and the like. Some people hate it and argue for
                                            its demise, but others ignore.
                                        </p>

                                        <p>
                                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                                        </p>
                                    </div>    
                                    <div class="post clearfix">
                                        <div class="user-block">                                            
                                            <span class="username">
                                                <a href="#">Sarah Ross</a>
                                            </span>
                                            <span class="description">Sent you a message - 3 days ago</span>
                                        </div>                                        
                                        <p>
                                            Lorem ipsum represents a long-held tradition for designers,
                                            typographers and the like. Some people hate it and argue for
                                            its demise, but others ignore.
                                        </p>
                                        <p>
                                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 2</a>
                                        </p>
                                    </div>
                                    <div class="post">
                                        <div class="user-block">                                            
                                            <span class="username">
                                                <a href="#">Jonathan Burke Jr.</a>
                                            </span>
                                            <span class="description">Shared publicly - 5 days ago</span>
                                    </div>                                    
                                    <p>
                                        Lorem ipsum represents a long-held tradition for designers,
                                        typographers and the like. Some people hate it and argue for
                                        its demise, but others ignore.
                                    </p>
                
                                    <p>
                                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v1</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary"><i class="fas fa-paint-brush"></i> AdminLTE v3</h3>
                        <p class="text-muted">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</p>
                        <br>
                        <div class="text-muted">
                            <p class="text-sm">Client Company
                                <b class="d-block">Deveint Inc</b>
                            </p>
                            <p class="text-sm">Project Leader
                                <b class="d-block">Tony Chicken</b>
                            </p>
                        </div>
                        <h5 class="mt-5 text-muted">Project files</h5>
                        <ul class="list-unstyled">
                            <li>
                                <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Functional-requirements.docx</a>
                            </li>
                            <li>
                                <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> UAT.pdf</a>
                            </li>
                            <li>
                                <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-envelope"></i> Email-from-flatbal.mln</a>
                            </li>
                            <li>
                                <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-image "></i> Logo.png</a>
                            </li>
                            <li>
                                <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Contract-10_12_2014.docx</a>
                            </li>
                        </ul>
                        <div class="text-center mt-5 mb-3">
                            <a href="#" class="btn btn-sm btn-primary">Add files</a>
                            <a href="#" class="btn btn-sm btn-warning">Report contact</a>
                        </div>
                    </div>
                </div>
            </div>            
        </div> -->

    </div>

</template>

<script>
export default {
    name: 'BranchesShow',
    props: ['id'],
    data() {
        return {
            branch: {}
        }
    },
    methods: {
        fetchData() {               
            axios.get(`/api/branches/${this.id}`, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => this.branch = res.data.data)
                .catch(err => console.log(err));
                
        }
    },
    created() {
        this.fetchData();
    }
}
</script>