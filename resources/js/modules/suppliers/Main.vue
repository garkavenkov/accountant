<template>
<div>

    <grid   :dataTable="suppliers"
            :pagination="pagination"
            filteredField="name"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Поставщики
                <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-new-supplier"
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
                <th scope="col">Наименование</th>
                <th scope="col">Полное наименование</th>
                <th scope="col">Описание</th>
            </tr>            
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id">
                <td class="text-center">
                    <router-link :to="{name: 'SuppliersShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>                    
                </td>
                <td>{{data.name}}</td>
                <td>{{data.full_name}}</td>
                <td>{{data.description}}</td>
            </tr>     
        </template>
        <template v-slot:footer>
            <tr>
                <td colspan="4" class="font-weight-bold">Итого поставщиков: {{suppliers.length}}</td>                
            </tr>
        </template>       
    </grid>

    <supplier-form></supplier-form>


</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Grid from '../../components/Grid';
import SupplierForm from './Form';

export default {
    name: 'SuppliersMain',
    data() {
        return {
            pagination: {}
        }
    },
    methods: {
        ...mapActions(['fetchData'])
    },
    computed: {
        ...mapGetters(['suppliers'])
    },
    created() {
        this.fetchData();
    },
    components: {
        Grid,
        SupplierForm
    }
}    
</script>

