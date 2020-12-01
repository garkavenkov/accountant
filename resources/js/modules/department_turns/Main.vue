<template>
<div>

     <grid  :dataTable="data"
            :pagination="pagination"
            filteredField="department"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Обороты на отделах
                <!-- <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-new-document"
                        data-backdrop="static" 
                        data-keyboard="true">
                    <i class="fas fa-plus"></i>
                </button> -->
                <button type="button" 
                        class="btn btn-info" 
                        v-on:click="fetchData"
                        title="Обновить данные">
                    <i class="fas fa-sync-alt"></i>
                </button>                
                <!-- <button class="btn btn-info "
                        data-toggle="modal" 
                        data-target="#modal-filter-document"
                        data-backdrop="static" 
                        data-keyboard="true">
                    <i class="fas fa-filter"></i>
                </button> -->
            </h3>
        </template>           
        <template v-slot:header>
            <tr>                
                <th rowspan="2" class="align-middle">Отдел</th>
                <th rowspan="2" class="text-center align-middle">Входящий остаток на {{data.date_begin}}</th>
                <th colspan="4" class="text-center">Приход</th>
                <th colspan="6" class="text-center">Расход</th>
                <th rowspan="2" class="text-center align-middle">Исходящий остаток на {{data.date_end}}</th>
            </tr>
            <tr>
                <th class="text-center">Поставщики</th>
                <th class="text-center">Отделы</th>
                <th class="text-center">Дооценка</th>
                <th class="text-center">Итого</th>
               
                <th class="text-center">Торговая выручка</th>
                <th class="text-center">Отделы</th>
                <th class="text-center">Списание</th>
                <th class="text-center">Уценка</th>
                <th class="text-center">Расход</th>
                <th class="text-center">Итого</th>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.departmentId">
                <td class="text-left">
                    <router-link :to="{name: 'DepartmentTurnsShow', params: {id: data.departmentId, date_begin: data.date}}">
                        <!-- <i class="far fa-eye"></i> -->
                        {{data.department}}
                    </router-link>
                </td>
                <!-- <td>{{data.department}}</td> -->
                <td class="text-right">{{data.incomeRest | formatNumber(2)}}</td>
                <td class="text-right">{{data.credit.income | formatNumber(2)}}</td>
                <td class="text-right">{{data.credit.transfer | formatNumber(2)}}</td>
                <td class="text-right">{{data.credit.markup | formatNumber(2)}}</td>
                <td class="text-right">{{data.credit.total | formatNumber(2)}}</td>
                <td class="text-right">{{data.debet.sales | formatNumber(2)}}</td>
                <td class="text-right">{{data.debet.transfer | formatNumber(2)}}</td>
                <td class="text-right">{{data.debet.writedown | formatNumber(2)}}</td>
                <td class="text-right">{{data.debet.markdown | formatNumber(2)}}</td>
                <td class="text-right">{{data.debet.expense | formatNumber(2)}}</td>
                <td class="text-right">{{data.debet.total | formatNumber(2)}}</td>
                <td class="text-right">{{data.outcomeRest | formatNumber(2)}}</td>
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <!-- <td colspan="5" class="font-weight-bold">Итого документов: {{documents.length}}</td>
                <td class="text-right font-weight-bold">{{totalMarkdownSum | formatNumber(2)}}</td>
                <td></td> -->
            </tr>
        </template>       
    </grid>

</div>
</template>

<script>

import Grid             from '../../components/Grid';

export default {
    name: 'DepartmentRestsMain',    
    data() {
        return {
            date_begin: "2020-11-01", //new Date().toISOString().slice(0,10),
            date_end: new Date().toISOString().slice(0,10),
            data: [ 

                // {
                //     "departmentId" : 1,
                //     "department" : "Вино-водочный",
                //     "date" : "2020-11-01",
                //     "incomeRest" : 100000,
                //     "credit" : {
                //         "total"     : 1952,
                //         "income"    : 0,
                //         "transfer"  : 1952,
                //         "markup"    : 0,
                //     },
                //     "debet" : {
                //         "total" : 167,
                //         "sales" : 0,
                //         "transfer" : 0,
                //         "markdown" : 0,
                //         "writedown" : 0,
                //         "expense" : 167,
                //     },
                //     "outcomeRest" : 101785,   
                // }
            ]
        }
    },
    methods: {        
        fetchData() {
            axios.get(`api/department-turns?id=0&date_begin=${this.date_begin}&date_end=${this.date_end}`, {
                    'headers': {
                        'Authorization': 'Bearer ' + window.api_token,
                        'Accept': 'application/json',
                    } 
                })
                .then(res => {
                    console.log(res);

                    this.data = res.data.data;
                });
        }
    },
    created() {
        this.fetchData();
    },
    components: {
        Grid
    },
}
</script>