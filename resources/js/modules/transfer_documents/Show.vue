<template>
<div>
    <router-link to="/">Back</router-link>
    <div class="row">
        <div class="col-10 offset-1">
            <!-- <div class="invoice p-3 mb-3">                 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Monthly Recap Report</h5>
                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                <a href="#" class="dropdown-item">Action</a>
                                <a href="#" class="dropdown-item">Another action</a>
                                <a href="#" class="dropdown-item">Something else here</a>
                                <a class="dropdown-divider"></a>
                                <a href="#" class="dropdown-item">Separated link</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <div class="card">                             -->
                                <!-- <div class="card-body"> -->
                                    <dl class="row">
                                        <dt class="col-sm-4">Отдел передает</dt>
                                        <dd class="col-sm-8">{{document.department_gives}}</dd>
                                        <dt class="col-sm-4">Сотрудник</dt>
                                        <dd class="col-sm-8">{{document.employee_gives}}</dd>
                                        <dt class="col-sm-4">Сумма</dt>
                                        <dd class="col-sm-8">{{ document.given_sum | formatNumber(2) }}</dd>
                                        <template v-if="correctGivenSum">
                                            <dt class="col-sm-4">Расчетная сумма</dt>
                                            <dd class="col-sm-8">
                                                {{ totalGivenSum | formatNumber(2) }}&nbsp;
                                                <button class="btn btn-info btn-sm" 
                                                        title="Скорректировать сумму закупки " 
                                                        @click="updateDoc({given_sum: totalGivenSum})">
                                                    Изменить
                                                </button>                                            
                                            </dd>
                                        </template>
                                    </dl>
                                <!-- </div> -->
                            <!-- </div> -->
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="card"> -->
                                <!-- <div class="card-body"> -->
                                    <dl class="row">
                                        <dt class="col-sm-4">Отдел принимает</dt>
                                        <dd class="col-sm-8">{{document.department_takes}}</dd>
                                        <dt class="col-sm-4">Сотрудник</dt>
                                        <dd class="col-sm-8">{{document.employee_takes}}</dd>
                                        <dt class="col-sm-4">Сумма</dt>
                                        <dd class="col-sm-8">
                                            <template v-if="!isEditable">
                                                {{ document.taken_sum | formatNumber(2) }}                                            
                                                <button class="btn btn-info btn-xs" 
                                                        title="Редактировать сумму" 
                                                        @click="editTakenSum">
                                                    <i class="fas fa-edit"></i>
                                                </button>   
                                            </template>
                                            <template v-else>
                                            
                                                    <input  type="text"
                                                        v-model="newTakenSum"
                                                    />
                                                    
                                            
                                                
                                                <button class="btn btn-info btn-xs" 
                                                        title="Сохранить" 
                                                        @click="updateTakenSum">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                                <button class="btn btn-danger btn-xs" 
                                                        title="Отмена" 
                                                        @click="isEditable=false">
                                                    <i class="fas fa-times"></i>
                                                </button>   
                                            </template>
                                            
                                        </dd>
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
                                <!-- </div> -->
                            <!-- </div> -->
                        </div>                            
                    </div>
                
                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="card">                            
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">Отдел передает</dt>
                                    <dd class="col-sm-8">{{document.department_gives}}</dd>
                                    <dt class="col-sm-4">Сотрудник</dt>
                                    <dd class="col-sm-8">{{document.employee_gives}}</dd>
                                    <dt class="col-sm-4">Сумма</dt>
                                    <dd class="col-sm-8">{{ document.given_sum | formatNumber(2) }}</dd>
                                    <template v-if="correctGivenSum">
                                        <dt class="col-sm-4">Расчетная сумма</dt>
                                        <dd class="col-sm-8">
                                            {{ totalGivenSum | formatNumber(2) }}&nbsp;
                                            <button class="btn btn-info btn-sm" 
                                                    title="Скорректировать сумму закупки " 
                                                    @click="updateDoc({given_sum: totalGivenSum})">
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
                    </div>                            
                </div> -->
                    <div class="row">
                        <button class="btn btn-primary"
                                @click="newDocumentItemForm">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-secondary"
                                v-if="document.items.length > 0"
                                @click="makeExpenseDocument">
                            <i class="fas fa-share-alt"></i>
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
                                        <td class="text-right">{{totalGivenSum | formatNumber(2)}}</td>
                                        <td class="text-right">{{totalTakenSum | formatNumber(2)}}</td>                                                                        
                                        <td class="text-right"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                 <div class="row no-print">
                    <div class="col-12">
                        <button type="button" class="btn btn-danger float-right" @click="deleteDoc(document.id)" v-if="document.status == 0">
                            <i class="far fa-credit-card"></i> 
                            Delete
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


import { mapActions, mapGetters } from 'vuex'
import DocumentItemForm from './DocumentItemForm';

export default {
    name: 'TransferDocumentsShow',
    props: ['id'],
    data() {
        return { 
            item: {
                documentId     : this.id,
                name            : '',
                measureId       : 0,
                quantity        : 0,
                purchasePrice   : 0,                
                retailPrice     : 0
            },
            title: '',
            action: '',
            submitText: '',
            isEditable: false,
            newTakenSum: 0,
        }
    },
    methods: {
        ...mapActions(['deleteDocument', 'fetchDocument', 'fetchDocumentItem', 'deleteDocumentItem', 'updateDocument']),
        deleteDoc(id) {
            this.deleteDocument({id})            
                .then(res => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
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
        editTakenSum() {
            this.newTakenSum = this.document.taken_sum;
            this.isEditable = true;
        },
        updateTakenSum() {
            if (!isNaN(this.newTakenSum) && (this.newTakenSum >= this.document.given_sum)) {
                // this.updateDoc({taken_sum: parseFloat(this.newTakenSum)})
                this.updateDocument({sum2: this.newTakenSum})
                    .then(res => {
                        console.log(res);
                        if (res.status == 201) {                            
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                // title:'Good job!',
                                text:'Документ был успешно изменен ',
                                icon:'success',
                            });
                            this.isEditable = false;
                        }
                    })
                    .catch(err => console.log(err));
            } else {

            }
            
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
                debet_id            : (data.department_gives_id) ? data.department_gives_id : this.document.department_gives_id,
                debet_person_id     : (data.employee_gives_id) ? data.employee_gives_id : this.document.employee_gives_id,
                credit_id           : (data.department_takes_id) ? data.department_takes_id : this.document.department_takes_id,                
                credit_person_id    : (data.employee_gives_id) ? data.employee_gives_id : this.document.employee_takes_id,
                sum1                : (data.given_sum) ? parseFloat(data.given_sum) :  parseFloat(this.document.given_sum),
                sum2                : (data.taken_sum) ? parseFloat(data.taken_sum) : parseFloat(this.document.taken_sum)
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
        makeExpenseDocument() {
            let doc = {
                date                : this.document.date,
                debet_id            : this.document.department_takes_id,
                debet_person_id     : this.document.employee_takes_id,
                sum2                : parseFloat(this.totalTakenSum)
            }
            axios.post('api/expense-documents', doc, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }    
                    }
                )
                .then(res => {
                    let data = {
                        from  : this.id,
                        to    : res.data.data.id,
                        ids   : this.document.items.map(item => item.id)//.join(',')
                    }
                    axios.post('api/clone-document-items', data, 
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            }                        
                        }
                    )
                    .then(res => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            text:'Документ успешно создан',
                            icon:'success',
                         });
                    })                    
                })
        }
    },
    computed: {
        ...mapGetters(['document']),
         totalGivenSum() {
            let total =  this.document.items.reduce((a, b) => a + b.quantity * b.purchasePrice, 0);
            return total;
        },
        totalTakenSum() {
            let total =  this.document.items.reduce((a, b) => a + b.quantity * b.retailPrice, 0);
            return total;
        },
        correctGivenSum() {
            return (this.document.given_sum != this.totalGivenSum) && this.document.items.length > 0  ? true : false
        },
        correctTakenSum() {
            return (this.document.taken_sum != this.totalTakenSum) && this.document.items.length > 0  ? true : false
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