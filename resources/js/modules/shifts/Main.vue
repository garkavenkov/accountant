<template>
    
<div>
    <grid   :dataTable="shifts"
            :pagination="pagination"
            filteredField="department"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Смены
                 <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-new-document"
                        data-backdrop="static" 
                        data-keyboard="true">
                    <i class="fas fa-plus"></i>
                </button>
            </h3>
        </template>           
        <template v-slot:header>
            <tr>
                <td></td>
                <td>Отдел</td>
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
    
    <document-form></document-form>

</div>

</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import DocumentForm from './Form';
import Grid from '../../components/Grid';

export default {
    name: 'ShiftsMain',
    data() {
        return {
            pagination: {},
        }
    },
    methods: {
        ...mapActions(['fetchData', 'getDepartmentsDictionary']),   
    },    
    computed: {
        ...mapGetters(['shifts', 'departments'])
    },
    created() {
        this.fetchData();
        this.getDepartmentsDictionary();
    },
    components: {
        Grid,
        DocumentForm
    }
}
</script>