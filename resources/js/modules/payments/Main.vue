<template>
<div>
     <grid  :dataTable="documents"
            :pagination="pagination"
            filteredField="supplier"
            @fetchData="fetchData"> 

        <template v-slot:title>
            <h3 class="card-title">Расчет с поставщиками
                <button class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#modal-new-document"
                        data-backdrop="static" 
                        data-keyboard="true"
                        title="Добавить документ">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" 
                        class="btn btn-info" 
                        v-on:click="fetchData"
                        title="Обновить данные">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button class="btn btn-info "
                        data-toggle="modal" 
                        data-target="#modal-filter-document"                        
                        data-backdrop="static" 
                        data-keyboard="true"
                        title="Фильтр документов">
                    <i class="fas fa-filter"></i>
                </button>
                <button type="button" 
                        class="btn btn-info" 
                        v-on:click="selectMode"
                        title="Выбрать записи"
                        v-if="documents.length > 0">
                    <i class="fas fa-tasks"></i>
                    <span class="float-right badge bg-primary" v-if="selectedRecords.length > 0">{{selectedRecords.length}}</span>
                </button>
                <button class="btn btn-info "
                        data-toggle="modal" 
                        data-target="#modal-tag-form"
                        data-backdrop="static" 
                        data-keyboard="true"
                        v-if="selectedRecords.length > 0">
                    <i class="fas fa-tags"></i>
                </button>
            </h3>
        </template>           
        <template v-slot:header>
            <tr>
                 <td v-if="inSelectMode">
                    <input type="checkbox" name="selectAll" id="selectAll" @change="selectAll($event)">
                </td>
                <td v-else></td>
                <td class="text-center">Дата</td>
                <td class="text-center">№</td>
                <!-- <td class="text-center">Тип</td> -->
                <td>Касса</td>
                <td>Поставщик</td>
                <td>Основание</td>                
                <td class="text-right">Сумма</td>                
                <td></td>
            </tr>
        </template>
        <template v-slot:default="slotProps">
            <tr v-for="data in slotProps.paginatedData" :key="data.id" :class="{ selected: data.selected }">
                <td class="text-center"  v-if="!inSelectMode">
                    <router-link :to="{name: 'PaymentsShow', params: {id: data.id}}">
                        <i class="far fa-eye"></i>
                    </router-link>
                    <!-- <i class="far fa-eye"></i> -->
                </td>
                 <td v-else>
                    <input type="checkbox" v-model="data.selected" @change="handleClick(data)">
                </td>
                <td class="text-center">{{data.date}}</td>
                <td>{{data.number}}</td>
                <!-- <td>{{data.operation}}</td> -->
                <td>{{data.cash}}</td>
                <td>{{data.supplier}}</td>
                <td>{{data.purpose}}</td>
                <td class="text-right">{{data.amount | formatNumber(2) }}</td>   
                <td>
                    <i class="far fa-file"  v-if="data.statusCode == 0"></i>
                    <i class="fas fa-check" v-else-if="data.statusCode == 1"></i> 
                </td>
            </tr>     
        </template>
        <template v-slot:footer>
             <tr v-if="selectedRecords.length>0">
                <td colspan="6" class="font-weight-italic">Выделено документов: {{selectedRecords.length}}</td>
                <td class="text-right font-weight-italic">{{totalSelectedAmount | formatNumber(2)}}</td>                
                <td></td>
            </tr>
            <tr>
                <td colspan="6" class="font-weight-bold">Итого документов: {{documents.length}}</td>                
                <td class="text-right font-weight-bold">{{totalAmount | formatNumber(2) }}</td>
                <td></td>
            </tr>
        </template>       
    </grid>

    <document-form></document-form>
    <filter-documents></filter-documents> 
   

</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import Grid from '../../components/Grid';
import FilterDocuments from './Filter';
import DocumentForm from './Form';

export default {
    name: 'PaymentsMain',
    data() {
        return {
            pagination: {},
            inSelectMode: false,
            selectedRecords: [],
        }
    },
    methods: {
        ...mapActions('Payment', ['fetchData']),
        selectMode() {
            if (this.inSelectMode) {
                this.inSelectMode = false;
                this.selectedRecords = [];
                this.documents.forEach(document => delete document.selected);
            } else {
                this.inSelectMode = true;
            }
        },
        selectAll(e) {
            if (e.target.checked) {
                this.selectedRecords = this.documents
                this.documents.map(document => document.selected = true);
            } else {
                this.selectedRecords = [];
                this.documents.map(document => delete document.selected);
            }
        },
        handleClick(record) {
            this.selectedRecords = this.documents.filter(document => document.selected);
            // if (record.selected) {
            //     this.selectedRecords.push(record);
            // } else {
            //     this.selectedRecords = this.selectedRecords.filter(item => item.id != record.id);
            // }
        }
    },
    computed: {
        ...mapGetters('Payment', ['documents']),
        totalSelectedAmount() {
            let total =  this.selectedRecords.reduce((a, b) => a + b.amount * 1, 0.00);
            return total;
        },        
        totalAmount() {
            let total =  this.documents.reduce((a, b) => a + b.amount * 1, 0.00);
            return total;
        }        
    },
    components: {
        Grid,
        FilterDocuments,
        DocumentForm
    },
    created() {
        this.fetchData();
        // this.getOperationTypeDictionary();
    }
}
</script>