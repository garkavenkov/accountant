<template>

<div class="row">
    <div class="col-10 offset-1">

        <div class="card">
            
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-coins"></i>
                    Подотчетный документ
                </h3>
                <div class="card-tools">                  
                  <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-cog"></i>
                      <span class="sr-only">Toggle Dropdown</span>
                      <div class="dropdown-menu" role="menu" style="">
                        <a class="dropdown-item" href="#" @click="closeAccountability" v-if="readyToClose">Закрыть очет</a>
                        <a class="dropdown-item" href="#" @click="openAccountability" v-if="!readyToClose">Открыть очет</a>
                        <!-- <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a> -->
                      </div>
                    </button>
                </div>                
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Информация
                                </h3>
                            </div>
                            <div class="card-body">
                                <div>
                                    <p class="field-title">Дата</p>
                                    <p>{{document.date}}</p>
                                </div>
                                <div>
                                    <p class="field-title">Касса</p>
                                    <p>{{document.cash}}</p>
                                </div>
                                <div>
                                    <p class="field-title">Подотчетное лицо</p>
                                    <p>{{document.employeeFullName}}</p>
                                </div>
                                <div>
                                    <p class="field-title">Назначение</p>
                                    <p>{{document.purpose}}</p>
                                </div>
                                <div>
                                    <p class="field-title">Сумма</p>
                                    <p>{{document.amount | formatNumber(2) }}</p>
                                </div>
                                <div>
                                    <p class="field-title">Статус</p>
                                    <p>{{document.status}}</p>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-primary"
                                    data-toggle="modal" 
                                    data-target="#modal-expense-form"
                                    data-backdrop="static" 
                                    data-keyboard="true">
                                        <i class="fas fa-plus"></i>
                                        
                                </button>                                
                            </div>
                            <div class="card-body">
                                <div class="row" v-if="document.items.length > 0">                
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Тип</th>
                                                <th>Описание</th>
                                                <th>Сумма</th>
                                                <th v-if="document.statusCode !== 2"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,index) in document.items" :key="item.id">
                                                <td>{{index + 1 }}</td>
                                                <td>{{item.typeName}}</td>
                                                <td>{{item.owner}}</td>
                                                <td>{{item.purpose}}</td>
                                                <td>{{item.amount | formatNumber(2) }}</td>
                                                <!-- <td>{{item.amount }}</td> -->
                                                <td v-if="document.statusCode !== 2">
                                                    <button class="btn btn-sm btn-danger" title="Удалить запись из отчета" @click="removeItem(item.id)">
                                                        <i class="fas fa-trash"></i>                  
                                                    </button>
                                                    <button class="btn btn-sm btn-waring" title="Редактировать запись" v-if="item.typeCode != 'income' ">
                                                        <i class="fas fa-pencil"></i>                  
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">Итого</td>
                                                <td>{{totalAmount | formatNumber(2) }}</td>
                                                <!-- <td>{{totalAmount}}</td> -->
                                                <td  v-if="document.statusCode !== 2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="row" v-else>
                                    <p class="text-ceter">Записи отсутствуют</p>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                <div class="text-right">
                    <button 
                        v-if="!(document.status_code && 1) != 1 "
                        class="btn btn-danger btn-sm" 
                        title="Удалить документ" 
                        @click="deleteDoc(document.id)">
                            Удалить
                    </button> 
                    
                </div>
            </div>

        </div>        
    
    </div>

    <expense-form></expense-form>
</div>

</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import ExpenseForm from './ExpenseForm';

export default {
    name: 'AccountabilitiesShow',
    props: ['id'],
    data() {
        return {
            url: 'api/accountability-items'
        }
    },
    methods: {
        ...mapActions(['fetchDocument', 'deleteDocument', 'close', 'open']),
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
                });
        },
        removeItem(id) {
            this.deleteDocument({id, url: this.url})
                .then(res => {
                    // console.log(res);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        // title:'Good job!',
                        // text: res.data.message,
                        text: res.data.message,
                        icon:'success',
                    });
                    this.fetchDocument(this.id);
                })
        },
        closeAccountability() {
            this.close(this.id)
                .then(res => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        // title:'Good job!',
                        // text: res.data.message,
                        text: res.data.message,
                        icon:'success',
                    });
                })
        },
        openAccountability() {
            this.open(this.id)
                .then(res => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        // title:'Good job!',
                        // text: res.data.message,
                        text: res.data.message,
                        icon:'success',
                    });
                })
        }

    },
    computed: {
        ...mapGetters(['document']),
        totalAmount() {
            return this.document.items.reduce((a,b) => a + b.amount * 1.0, 0.00);
        },
        readyToClose() {
            return ( (this.document.amount == this.totalAmount) && ((this.document.status_code & 2) != 2)) ? true : false;
        }
    },
    created() {
        this.fetchDocument(this.id)
    },
    components: {
        ExpenseForm
    }
}
</script>

<style scoped>
    .field-title {
        margin-bottom: 0.1rem;
        font-weight: bold;
    }
</style>