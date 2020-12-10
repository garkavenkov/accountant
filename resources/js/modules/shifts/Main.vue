<template>
    
<div>
    <grid   :dataTable="shifts"
            :pagination="pagination"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Смены
                <!-- <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-default"
                        data-backdrop="static" 
                        data-keyboard="true">
                    <i class="fas fa-plus"></i>
                </button> -->
            </h3>
        </template>           
        <template v-slot:header>
            <tr>
                <td></td>
                <td>Отдел</td>
                <!-- <td>№</td>
                <td>Поставщик</td>
                <td>Отдел</td>
                <td>Сотрудник</td> -->
                <td class="text-center">Начало смены</td>
                <td class="text-center">Конец смены</td>
            </tr>
        </template>
        <tr v-for="shift in shifts" :key="shift.id">
            <td class="text-center">
                <router-link :to="{name: 'ShiftsShow', params: {id: shift.id}}">
                    <i class="far fa-eye"></i>
                </router-link>
            </td>
            <td>{{shift.department}}</td>
            <td class="text-center">{{shift.dateBegin}}</td>
            <td class="text-center">{{shift.dateEnd}}</td>            
        </tr>            
    </grid>

</div>

</template>

<script>

import Grid from '../../components/Grid';

export default {
    name: 'ShiftsMain',
    data() {
        return {
            shifts: [],
            pagination: {},
        }
    },
    methods: {
         fetchData(url) {               
            let page_url = url || '/api/shifts';
            axios.get(page_url, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => {
                    this.shifts = res.data.data
                    this.makePagination(res.data.links, res.data.meta);
                })
                .catch(err => console.log(err));
                
        },
         makePagination(links, meta) {
            this.pagination = {...links, ...meta}
        },
    },
    created() {
        this.fetchData();
    },
    components: {
        Grid
    }
}
</script>