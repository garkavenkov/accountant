<template>
<div>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Движение средств на отделе</h3>
                </div>                

                <div class="card-body">                    
                    <div class="row">
                        <!-- <form class="form-inline">
                            <label class="sr-only" for="inlineFormInputName2">Name</label>
                            <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Jane Doe">

                            <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                </div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Username">
                            </div>

                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="checkbox" id="inlineFormCheck">
                                <label class="form-check-label" for="inlineFormCheck">
                                    Remember me
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2">Submit</button>
                        </form> -->
                        <div class="col-md-3">
                            <select-field 
                                caption="Отдел"
                                hint="Выберите отдел"
                                id="department"
                                :options="departments"
                                v-model="turns.departmentId"
                                name="name">
                            </select-field>

                            <div class="form-group">
                                <label>Дата начала</label>                                
                                <input  type="date" 
                                        name="date" 
                                        id="date" 
                                        class="form-control datetimepicker-input" 
                                        v-model="turns.dateBegin">                                
                            </div>
                            <div class="form-group">
                                <label>Дата окончания</label>                                
                                <input  type="date" 
                                        name="date" 
                                        id="date" 
                                        class="form-control datetimepicker-input" 
                                        v-model="turns.dateEnd">                                
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="autosetRest" v-model="turns.autosetRest">
                                    <label for="autosetRest" class="custom-control-label">Фиксировать остаток</label>
                                </div>                        
                            </div>
                            <button type="button" class="btn btn-primary" @click="getTurns">Расчитать</button>
                        </div>

                        <div class="col-md-9" v-if="data.department">
                            <div class="row">
                                <h3>Входящий остаток на утро {{data.date | formatDate }} <span>{{data.incomeRest | formatNumber(2)}}</span></h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div v-for="(value, name, index) in data.credit" :key="index" >
                                        {{name}} - {{value}}
                                    </div>
                                </div>
        
                                <div class="col-md-6">
                                    <div v-for="(value,name,index) in data.debet" :key="index" >
                                        {{name}} - {{value}}
                                    </div>
                                </div>                  
                            </div>
                            <div class="row" style="justify-content: space-between">
                                <h3>Исходящий остаток на вечер {{data.date | formatDate }} <span>{{data.outcomeRest | formatNumber(2)}}</span></h3>
                                <button class="btn btn-info" title="Установить остаток" @click="setRest">Установить</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="row">
                      
                    </div>                
                </div>              

            </div>            
        </div>
    </div>
     
</div>
</template>

<script>

import SelectField from '../../components/SelectField';

export default {
    name: 'DepartmentTurnsMain',    
    data() {
        return {
            departments: [],
            turns: {
                departmentId    : 0,
                dateBegin       : moment().format('YYYY-MM-DD'),
                dateEnd         : moment().format('YYYY-MM-DD'),
                autosetRest     : true
            },
            data: {}
        }
    },
    methods: {
        getDepartmentsDictionary() {
            axios.get("/api/select-dictionary/department?type=goods", 
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => {
                        this.departments = res.data
                    })               
        },
        getTurns() {
            let setRest = this.turns.autosetRest ? '&set_rest=1' : '';
            axios.get(`api/department-turns?id=${this.turns.departmentId}&date_begin=${this.turns.dateBegin}&date_end=${this.turns.dateEnd}${setRest}`, {
                    'headers': {
                        'Authorization': 'Bearer ' + window.api_token,
                        'Accept': 'application/json',
                    } 
                })
                .then(res => {
                    this.data = res.data;
                });
        },
        setRest() {
            // axios.get(`api/department-set-rest-on-date?id=${this.turns.departmentId}`)
        }

    },
    created() {
        this.getDepartmentsDictionary();
    },
    components: {
        SelectField
    },
}
</script>