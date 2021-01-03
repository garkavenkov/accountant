<template>

<div>
    <grid   :dataTable="employees"
            :pagination="pagination"
            filteredField="surname"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Сотрудники
                <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-new-employee"
                        data-backdrop="static" 
                        data-keyboard="true">
                    <i class="fas fa-plus"></i>
                </button>
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
                <th>#</th>
                <th class="text-center">Фамилия</th>
                <th class="text-center">Имя</th>
                <th class="text-center">Отчество</th>
                <th class="text-center">Подразделение</th>
                <th class="text-center">Отдел</th>
                <th class="text-center">Должность</th>
                <th class="text-center">Принят</th>
                <th class="text-center">Уволен</th>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'EmployeesShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                </td>
                <td>{{data.surname}}</td> 
                <td>{{data.name}}</td>
                <td>{{data.patronymic}}</td>
                <td>{{data.branch}}</td>
                <td>{{data.department}}</td>
                <td>{{data.position}}</td>
                <td>{{data.hired}}</td>
                <td>{{data.fired}}</td>
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <td colspan="7" class="font-weight-bold">Итого сотрудников: {{employees.length}}</td>
                <td></td>
            </tr>
        </template>       
    </grid>

    <employee-form></employee-form>

</div>

</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Grid from '../../components/Grid';
import EmployeeForm from './Form.vue';

export default {
    name: 'EmployeesMain',
    data() {
        return {
            pagination: {}
        }
    },
    methods: {
        ...mapActions(['fetchData'])
    },
    computed: {
        ...mapGetters(['employees'])
    },
    created() {
        this.fetchData();
    },    
    components: {
        Grid,
        EmployeeForm
    }
}    
</script>

