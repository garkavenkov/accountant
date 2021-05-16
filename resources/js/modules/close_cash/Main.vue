<template>
   
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Закрыть кассовый день</h3>
                <div class="card-tools">
                  <!-- <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <!-- <a href="#" class="btn btn-tool btn-sm" @click="setRest">
                    <i class="fas fa-cog"></i>
                  </a> -->
                  <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-cog"></i>
                      <span class="sr-only">Toggle Dropdown</span>
                      <div class="dropdown-menu" role="menu" style="">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                      </div>
                    </button>
                </div>
            </div>                

            <div class="card-body">                    
                <div class="row">                       
                    <div class="col-md-3">
                            <select-field 
                                caption="Касса"
                                hint="Выберите кассу"
                                id="cash"
                                :options="cashes"
                                v-model="turns.cashId"
                                name="name">
                            </select-field>

                            <div class="form-group">
                                <label>Дата</label>                                
                                <input  type="date" 
                                        name="date" 
                                        id="date" 
                                        class="form-control datetimepicker-input" 
                                        v-model="turns.dateBegin">                                
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="autosetRest" v-model="turns.autosetRest">
                                    <label for="autosetRest" class="custom-control-label">Фиксировать остаток</label>
                                </div>                        
                            </div>
                            <!-- <div class="form-check">
                                <input class="form-check-input" id="autoset-rest" name="autoset-rest" type="checkbox" v-model="turns.autosetRest">
                                <label class="form-check-label" for="autoset-rest">Фиксировать остаток</label>
                            </div> -->
                            <button type="button" class="btn btn-primary" @click="getTurns" :disabled="turns.cashId == 0">Расчитать</button>
                    </div>
                    <div class="col-md-9">
                        <template  v-if="data.incomeRest">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="d-flex flex-column text-left">
                                    <span class="font-weight-bold">
                                        Входящий остаток
                                    </span>
                                    <span class="text-muted">{{data.date | formatDate}}</span>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <!-- <span class="font-weight-bold">
                                        <i class="ion ion-android-arrow-up text-success"></i> 12%
                                    </span> -->
                                    <!-- {{data.incomeRest | formatNumber(2)}} -->
                                    {{data.incomeRest | formatNumber(2)}}

                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <!-- <i class="ion ion-ios-refresh-empty"></i> -->
                                    Обороты по кредиту
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <!-- {{data.debet | formatNumber(2)}} -->
                                    <!-- <span class="font-weight-bold">
                                        <i class="ion ion-android-arrow-up text-success"></i> 12%
                                    </span>
                                    <span class="text-muted">CONVERSION RATE</span> -->
                                    {{data.creditTurns | formatNumber(2)}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <!-- <i class="ion ion-ios-refresh-empty"></i> -->
                                    Обороты по дебету
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <!-- {{data.debet | formatNumber(2)}} -->
                                    <!-- <span class="font-weight-bold">
                                        <i class="ion ion-android-arrow-up text-success"></i> 12%
                                    </span>
                                    <span class="text-muted">CONVERSION RATE</span> -->
                                    {{data.debetTurns | formatNumber(2)}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="d-flex flex-column text-left">
                                    <span class="font-weight-bold">
                                        Исходящий остаток
                                    </span>
                                    <span class="text-muted">{{data.date | formatDate}}</span>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <!-- <span class="font-weight-bold">
                                        <i class="ion ion-android-arrow-up text-success"></i> 12%
                                    </span> -->
                                    <!-- {{data.incomeRest | formatNumber(2)}} -->
                                    {{data.outcomeRest | formatNumber(2)}}

                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3" v-if="data.message">
                                <p class="d-flex flex-column text-left">
                                    <span class="font-weight-bold">
                                        {{data.message}}
                                    </span>
                                </p>                                
                            </div>
                        </template>
                        <template v-if="error.message">
                             <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-danger">
                                    <!-- <i class="ion ion-ios-refresh-empty"></i> -->
                                    {{error.message}}
                                </p>
                                <button class="btn btn-info"
                                    data-toggle="modal" 
                                    data-target="#modal-set-rest"
                                    data-backdrop="static" 
                                    data-keyboard="true">
                                        <i class="fas fa-hammer"></i>
                                </button>
                                <!-- <button type="button" class="btn btn-primary" @click="setRest">Установить</button> -->
                            </div>
                            <!-- <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <button type="button" class="btn btn-primary" @click="setRest">Установить</button>
                            </div> -->
                        </template>

                    </div>
                    
                </div>
            </div>
                
            <!-- <div class="card-footer">
                <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                                <h5 class="description-header">$35,210.43</h5>
                                <span class="description-text">TOTAL REVENUE</span>
                            </div>
                        </div>                    
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                                <h5 class="description-header">$10,390.90</h5>
                                <span class="description-text">TOTAL COST</span>
                            </div>
                        </div>
                  
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                                <h5 class="description-header">$24,813.53</h5>
                                <span class="description-text">TOTAL PROFIT</span>
                            </div>
                        </div>                  
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                                <h5 class="description-header">1200</h5>
                                <span class="description-text">GOAL COMPLETIONS</span>
                            </div>                        
                        </div>
                </div>                
            </div>               -->

        </div>            
    </div>    

    <rest-form :cashId="turns.cashId"></rest-form>
</div>
</template>

<script>

import SelectField  from '../../components/SelectField';
import RestForm     from './SetRestForm';

export default {
    name: 'CloseCashMain',    
    data() {
        return {
            cashes: [],
            turns: {
                cashId: 0,
                dateBegin:  moment().format('YYYY-MM-DD'),
                autosetRest: true
            },
            data: {},
            error: {}
        }
    },
    methods: {
        getCashesDictionary() {
            axios.get("/api/select-dictionary/cash", 
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => {
                        this.cashes = res.data
                    })               
        },
        getTurns() {
            let setRest = this.turns.autosetRest ? '&set_rest=1' : '';
            axios.get(`api/cash-turns?id=${this.turns.cashId}&date_begin=${this.turns.dateBegin}&date_end=${this.turns.dateBegin}${setRest}`, {
                    'headers': {
                        'Authorization': 'Bearer ' + window.api_token,
                        'Accept': 'application/json',
                    } 
                })
                .then(res => {                    
                    this.error = {};
                    this.data = res.data;
                })
                .catch(err => {
                    this.data = {};
                    this.error = err.response.data;                    
                })
        },
        setRest() {
            // axios.get(`api/department-set-rest-on-date?id=${this.turns.departmentId}`)
        }

    },
    created() {
        this.getCashesDictionary();
    },
    components: {
        SelectField,
        RestForm
    },
}
</script>

