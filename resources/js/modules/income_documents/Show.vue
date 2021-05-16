<template>

<div>        
    <router-link to="/">Back</router-link>


    <div class="row">
        <div class="col-10 offset-1">
            <div class="invoice p-3 mb-3">                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">Поставщик</dt>
                                    <dd class="col-sm-8">{{document.supplier}}</dd>
                                    <dt class="col-sm-4"></dt>
                                    <dd class="col-sm-8"></dd>
                                    <dt class="col-sm-4">Сумма</dt>
                                    <dd class="col-sm-8">{{ document.purchaseSum | formatNumber(2) }}</dd>
                                    <template v-if="correctPurchaseSum">
                                        <dt class="col-sm-4">Расчетная сумма</dt>
                                        <dd class="col-sm-8">
                                            {{ totalPurchaseSum | formatNumber(2) }}&nbsp;
                                            <button class="btn btn-info btn-sm" 
                                                    title="Скорректировать сумму закупки " 
                                                    @click="updateDoc({sum1: totalPurchaseSum})">
                                                Изменить
                                            </button>                                            
                                        </dd>
                                    </template>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">Отдел</dt>
                                    <dd class="col-sm-8">{{document.department}}</dd>
                                    <dt class="col-sm-4">Сотрудник</dt>
                                    <dd class="col-sm-8">{{document.employee_full_name}}</dd>
                                    <dt class="col-sm-4">Сумма</dt>
                                    <dd class="col-sm-8">{{ document.retailSum | formatNumber(2) }}</dd>
                                    <template v-if="correctRetailSum">
                                        <dt class="col-sm-4">Расчетная сумма</dt>
                                        <dd class="col-sm-8">
                                            {{ totalRetailSum | formatNumber(2) }}&nbsp;
                                            <button class="btn btn-info btn-sm" 
                                                    title="Скорректировать розничную сумму " 
                                                    @click="updateDoc({sum2: totalRetailSum})">
                                                Изменить
                                            </button>                                            
                                        </dd>
                                    </template>
                                </dl>
                            </div>
                        </div>
                    </div>                            
                </div>
                <div class="row">
                    
                    <button class="btn btn-primary"
                            @click="newDocumentItemForm">
                        <i class="fas fa-plus"></i>
                    </button>                        
                </div>                    
                <div class="row">
                    <div class="col-12 table-responsive" v-if="document.items.length > 0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2">№</th>
                                    <th rowspan="2">Наименование</th>
                                    <th rowspan="2" class="text-center">Ед. изм.</th>
                                    <th rowspan="2" class="text-center">Количество</th>
                                    <th colspan="2" class="text-center">Стоимость</th>                    
                                    <th colspan="2" class="text-center">Сумма</th>                                                                            
                                    <th rawspan="2" class="text-center">Торговая наценка</th>
                                    <th colspan="2"></th>
                                </tr>
                                <tr>
                                    <th class="text-center">закупки</th>
                                    <th class="text-center">розницы</th>
                                    <th class="text-center">закупки</th>
                                    <th class="text-center">розницы</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in document.items" :key="item.id">
                                    <td>{{item.number}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.measure}}</td>
                                    <td class="text-right">{{ item.quantity | formatNumber(2) }}</td>
                                    <td class="text-right">{{ item.purchasePrice | formatNumber(2) }}</td>
                                    <td class="text-right">{{ item.retailPrice | formatNumber(2) }}</td>
                                    <td class="text-right">{{ item.purchaseSum | formatNumber(2)  }}</td>
                                    <td class="text-right">{{ item.retailSum | formatNumber(2) }}</td>
                                    <td class="text-right">{{ item.gain | formatNumber(2) }}</td>
                                    <td class="actions-btn-group">
                                        <button class="btn btn-info btn-xs"                                                
                                                @click="openEditItemForm(item.id)"
                                                title="Редактирование спецификации">
                                            <i class="fas fa-edit"></i>
                                        </button>                                        
                                        <button class="btn btn-danger btn-xs" 
                                                @click="openDeleteItemModal(item.id)"
                                                title="Удалить спецификацию"> 
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">Итого</td>
                                    <td class="text-right">{{totalPurchaseSum | formatNumber(2)}}</td>
                                    <td class="text-right">{{totalRetailSum | formatNumber(2)}}</td>                                                                        
                                    <td class="text-right"></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">                        
                    <div class="col-6">
                        <p class="lead">Payment Methods:</p>                            
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                            plugg
                            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="lead">Amount Due 2/22/2014</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>$250.30</td>
                                </tr>
                                <tr>
                                    <th>Tax (9.3%)</th>
                                    <td>$10.34</td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td>$5.80</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>$265.24</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>                    
                <div class="row no-print">
                    <div class="col-12">
                        <!-- <button type="button" class="btn btn-danger float-right" @click="deleteDoc(document.id)" v-if="document.statusCode == 0">
                            <i class="far fa-credit-card"></i> 
                            Delete
                        </button> -->
                        <button type="button" class="btn btn-danger float-right" @click="deleteDoc(document.id)">
                            <i class="far fa-credit-card"></i> 
                             {{document.statusCode}}
                        </button>
                    </div>
                </div>
            </div>
        </div>        
    </div>      

    <document-item-form :data="item"
                        :action="action"
                        :submitText="submitText"
                        :title="title">    
    </document-item-form>

    <div class="modal fade" id="modal-delete-item">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Удаление спецификации</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Вы действительно хотите удалить запись?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal" @click="closeDeteleItem">Отмена</button>
                    <button type="button" class="btn btn-outline-light" @click="deleteItem(itemId)">Удалить</button>
                </div>
            </div>          
        </div>        
    </div>

</div>

</template>

<script>

import FormValidator from '../../mixins/FormValidator';
import {mapActions, mapGetters} from 'vuex';
import DocumentItemForm from './DocumentItemForm';

export default {
    name: 'IncomeDocumentsShow',
    props: ['id'],
    mixins: [FormValidator],
    data() {
        return {            
            item: {
                documentId      : this.id,
                name            : '',
                measureId       : 0,
                quantity        : 0,
                purchasePrice   : 0,
                retailPrice     : 0
            },
            title: '',
            action: '',
            submitText: ''
        }
    },
    methods: {
        ...mapActions(['deleteDocument', 'fetchDocument', 'saveDocumentItem', 'deleteDocumentItem', 'updateDocument', 'fetchDocumentItem', 'updateDocumentItem']),
        deleteDoc(id) {
            this.deleteDocument({id})            
                .then(res => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        // title:'Good job!',
                        text:red.data.message,
                        icon:'success',
                    });                    
                    this.$router.go(-1);
                })
                .catch(err => {
                    if (err.response) console.log(err);
                    // Swal.fire({
                    //     toast: true,
                    //     position: 'top-end',
                    //     showConfirmButton: false,
                    //     timer: 3000,
                    //     // title:'Good job!',
                    //     text: err,
                    //     icon:'error',
                    // });                    
                })
        },      
     
        newDocumentItemForm() {
            this.title="Новая спецификация";
            this.action='create';
            this.submitText='Добавить';
            $('#modal-document-item').modal('toggle');
        },
        openEditItemForm(id) {
            this.fetchDocumentItem(id)
                .then(res => {
                    
                    this.item = res;
                    
                    this.title="Редактирование спецификации";
                    this.action='update';
                    this.submitText='Изменить';
                    
                    $('#modal-document-item').modal('toggle');            
                })
                .catch(err => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,                        
                        text:'Спецификация не найдена',
                        icon:'error',
                    });                    
                })
        },
       
       
        openDeleteItemModal(id) {
            this.itemId = id;
            $('#modal-delete-item').modal('toggle');            
        },
      
        
        closeDeteleItem() {            
            this.itemId = null;
        },
        deleteItem(id) {
            this.deleteDocumentItem(id)
                .then(res => {
                    if (res.status == 204) {
                        this.itemId = null;
                        $('#modal-delete-item').modal('hide');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            title:'Good job!',
                            text:'Спецификация успешно удалена',
                            icon:'success',
                        });
                    }
                });
        },
        updateDoc(data) {
            let doc = {
                date                : (data.date) ? data.date  : this.document.date,
                debet_id            : (data.departmentId) ? data.departmentId : this.document.departmentId,
                debet_person_id     : (data.employeeId) ? data.employeeId : this.document.employeeId,
                sum1                : (data.purchaseSum) ? parseFloat(data.purchaseSum) : parseFloat(this.document.purchaseSum),
                sum2                : (data.retailSum) ? parseFloat(data.retailSum) : parseFloat(this.document.retailSum)
            }
            this.updateDocument(data)
                .then(res => {
                    if (res.status == 201) {                            
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            title:'Good job!',
                            text:'Документ был успешно изменен ',
                            icon:'success',
                        });
                    }
                });
        },
    },
    computed: {
        ...mapGetters(['document']),
        totalPurchaseSum() {
            let total =  this.document.items.reduce((a, b) => a + b.purchaseSum, 0);
            return total;
        },
        totalRetailSum() {
            let total =  this.document.items.reduce((a, b) => a + b.retailSum, 0);
            return total;
        },
        correctPurchaseSum() {
            return (this.document.purchaseSum != this.totalPurchaseSum) && this.document.items.length > 0  ? true : false
        },
        correctRetailSum() {
            return (this.document.retailSum != this.totalRetailSum) && this.document.items.length > 0  ? true : false
        }
    },
    created() {
        this.fetchDocument(this.id);
    },
    components: {
        DocumentItemForm
    } 
}
</script>

<style scoped>
    .actions-btn-group {
        display: flex;
        justify-content: space-evenly;
    }
</style>