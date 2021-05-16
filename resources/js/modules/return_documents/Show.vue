<template>

<div class="row">
    <div class="col-6 offset-3">

        <div class="card">
            
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-coins"></i>
                    Возврат товара поставщику
                </h3>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Отдел</dt>
                    <dd class="col-sm-8">{{document.department}}</dd>

                    <dt class="col-sm-4">Сотрудник</dt>
                    <dd class="col-sm-8">{{document.employee_full_name}}</dd>

                    <dt class="col-sm-4">Поставщик</dt>
                    <dd class="col-sm-8">{{document.supplier}}</dd>

                    <dt class="col-sm-4">Розничная сумма </dt>
                    <dd class="col-sm-8">{{document.retailSum | formatNumber(2) }}</dd>
                    
                    <dt class="col-sm-4">Сумма закупки </dt>
                    <dd class="col-sm-8">{{document.purchaseSum | formatNumber(2) }}</dd>

                    <dt class="col-sm-4">Сумма возврата </dt>
                    <dd class="col-sm-8">{{document.return | formatNumber(2) }}</dd>

                    <dt class="col-sm-4">Статус</dt>
                    <dd class="col-sm-8">{{document.status}}</dd>
                </dl>
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                <div class="text-right">                    
                    <button 
                        v-if="deletable"
                        class="btn btn-danger btn-sm" 
                        title="Удалить документ" 
                        @click="deleteDoc(document.id)">
                            Удалить
                    </button> 
                    
                </div>
            </div>

        </div>        
    
    </div>
</div>

</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'ReturnDocumentsShow',
    props: ['id'],
    data() {
        return {

        }
    },
    methods: {
        ...mapActions(['fetchDocument', 'deleteDocument']),
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
        }
    },
    computed: {
        ...mapGetters(['document']),
        deletable() {
            return this.document.statusCode == 0 ? true : false
        }
    },
    created() {
        this.fetchDocument(this.id)
    }
}
</script>