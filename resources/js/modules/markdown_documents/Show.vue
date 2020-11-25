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
                                    <dt class="col-sm-4">Отдел</dt>
                                    <dd class="col-sm-8">{{document.department}}</dd>
                                    <dt class="col-sm-4">Сотрудник</dt>
                                    <dd class="col-sm-8">{{document.employeeFullName}}</dd>
                                    <dt class="col-sm-4">Сумма</dt>
                                    <dd class="col-sm-8">{{ document.markdownSum | formatNumber(2) }}</dd>
                                    <template v-if="correctMarkdownSum">
                                        <dt class="col-sm-4">Расчетная сумма</dt>
                                        <dd class="col-sm-8">
                                            {{ totalMarkdownSum | formatNumber(2) }}&nbsp;
                                            <button class="btn btn-info btn-sm" 
                                                    title="Скорректировать сумму уценки" 
                                                    @click="updateDoc({markdownSum: totalMarkdownSum})">
                                                Изменить
                                            </button>                                            
                                        </dd>
                                    </template>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">Отдел принимает</dt>
                                    <dd class="col-sm-8">{{document.department_takes}}</dd>
                                    <dt class="col-sm-4">Сотрудник</dt>
                                    <dd class="col-sm-8">{{document.employee_takes}}</dd>
                                    <dt class="col-sm-4">Сумма</dt>
                                    <dd class="col-sm-8">{{ document.taken_sum | formatNumber(2) }}</dd>
                                    <template v-if="correctTakenSum">
                                        <dt class="col-sm-4">Расчетная сумма</dt>
                                        <dd class="col-sm-8">
                                            {{ totalTakenSum | formatNumber(2) }}&nbsp;
                                            <button class="btn btn-info btn-sm" 
                                                    title="Скорректировать розничную сумму " 
                                                    @click="updateDoc({taken_sum: totalTakenSum})">
                                                Изменить
                                            </button>                                            
                                        </dd>
                                    </template>
                                </dl>
                            </div>
                        </div>
                    </div>                             -->
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
                                    <th>№</th>
                                    <th>Наименование</th>
                                    <th class="text-center">Ед. изм.</th>
                                    <th class="text-center">Количество</th>
                                    <th class="text-center">Старая цена</th>
                                    <th class="text-center">Новая цена</th>
                                    <th class="text-center">Уценка</th>                                                                                                                
                                    <th></th>
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
                                    <td class="text-right">{{ item.purchasePrice - item.retailPrice | formatNumber(2) }}</td>
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
                                    <td class="text-right">{{totalMarkdownSum }}</td>                                    
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                 <div class="row no-print">
                    <div class="col-12">
                        <button type="button" class="btn btn-danger float-right" @click="deleteDoc(document.id)" v-if="document.status == 0">
                            <i class="far fa-credit-card"></i> 
                            Delete
                        </button>
                        <!-- <button type="button" class="btn btn-danger float-right" @click="deleteDoc(document.id)">
                            <i class="far fa-credit-card"></i> 
                            Delete
                        </button> -->
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


import { mapActions, mapGetters } from 'vuex'
import DocumentItemForm from './DocumentItemForm';

export default {
    name: 'MarkdownDocumentsShow',
    props: ['id'],
    data() {
        return { 
            item: {
                documentId      : this.id,
                name            : '',
                measureId       : 0,
                quantity        : 0,
                oldPrice        : 0,
                newPrice        : 0
            },
            title: '',
            action: '',
            submitText: ''
        }
    },
    methods: {
        ...mapActions(['deleteDocument', 'fetchDocument', 'fetchDocumentItem', 'deleteDocumentItem', 'updateDocument']),
        deleteDoc(id) {
            this.deleteDocument(id)            
                .then(res => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        // title:'Good job!',
                        text:'Документ успешно удален',
                        icon:'success',
                    });                    
                    this.$router.go(-1);
                })
                .catch(err => {
                    if (err.response) console.log(err);
                })
        },
      
        newDocumentItemForm() {
            this.title="Новая спецификация";
            this.action='create',
            this.submitText='Добавить',
            $('#modal-document-item').modal('toggle');
        },            
               
        openEditItemForm(id) {
            this.fetchDocumentItem(id)
                .then(res => {
                    
                    this.item = res;
                    
                    this.title="Редактирование спецификации";
                    this.action='update',
                    this.submitText='Изменить',
                    
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
            console.log(data);
            let doc = {
                date                : (data.date) ? data.date  : this.document.date,
                debet_id            : (data.departmentId) ? data.departmentId : this.document.departmentId,
                debet_person_id     : (data.employeeId) ? data.employeeId : this.document.employeeId,
                sum2                : (data.markdownSum) ? parseFloat(data.markdownSum) : parseFloat(this.document.markdownSum)
            }
            // console.log(doc);
            this.updateDocument(doc)
                .then(res => {
                    console.log(res);
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
                })
                .catch(err => console.log(err));
        },
    },
    computed: {
        ...mapGetters(['document']),
        totalMarkdownSum() {
            let total =  this.document.items.reduce((a, b) => a + b.quantity * ( b.purchasePrice - b.retailPrice), 0);
            return total;
        },        
        correctMarkdownSum() {
            return (this.document.markdownSum != this.totalMarkdownSum) && this.document.items.length > 0  ? true : false
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