<template>
<div>
 
    <grid   :dataTable="departments"
            :pagination="pagination"
            filteredField="name"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Отделы
                <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-new-document"
                        data-backdrop="static" 
                        data-keyboard="true"
                        title="Добавить отдел">
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
                        data-keyboard="true"
                        title="Фильтр документов">
                    <i class="fas fa-filter"></i>
                </button> -->
            </h3>
        </template>           
        <template v-slot:header>             
            <tr>
                <th scope="col">#</th>
                <th scope="col">Подразделение</th>
                <th scope="col">Наименование</th>
                <th scope="col">Тип</th>
                <th scope="col">Дата открытия</th>
                <th scope="col">Дата закрытия</th>
            </tr>            
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'DepartmentsShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>                    
                </td>
                <td>{{data.branch}}</td>
                <td>{{data.name}}</td>
                <td>{{data.type}}</td>
                <td class="text-center">{{data.opened}}</td>
                <td class="text-center">{{data.closed}}</td>                
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <td colspan="4" class="font-weight-bold">Итого отделов: {{departments.length}}</td>                
            </tr>
        </template>       
    </grid>

    <department-form></department-form>


</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Grid from '../../components/Grid';
import DepartmentForm from './Form';

export default {
    name: 'DepartmentsMain',
    data() {
        return {
            pagination: {}
        }
    },
    methods: {
        ...mapActions(['fetchData'])
    },
    computed: {
        ...mapGetters(['departments'])
    },
    created() {
        this.fetchData();
    },
    components: {
        Grid,
        DepartmentForm
    }
}    
</script>

