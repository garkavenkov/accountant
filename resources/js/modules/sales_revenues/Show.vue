<template>

<div class="row">
    <div class="col-6 offset-3">

        <div class="card">
            
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-coins"></i>
                    Торговая выручка
                </h3>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Отдел</dt>
                    <dd class="col-sm-8">{{document.department}}</dd>

                    <dt class="col-sm-4">Касса</dt>
                    <dd class="col-sm-8">{{document.cash}}</dd>

                    <dt class="col-sm-4">Сумма</dt>
                    <dd class="col-sm-8">{{document.amount | formatNumber(2) }}</dd>

                    <dt class="col-sm-4">Статус</dt>
                    <dd class="col-sm-8">{{document.status}}</dd>
                </dl>
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                <div class="text-right">
                    <!-- <a href="#" class="btn btn-sm bg-teal">
                        <i class="fas fa-comments"></i>
                    </a> -->
                    <!-- <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-user"></i> View Profile
                    </a> -->
                    <button 
                        v-if="document.status ==0 "
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
    name: 'SalesRevenueShow',
    props: ['id'],
    data() {
        return {

        }
    },
    methods: {
        ...mapActions('SalesRevenue', ['fetchDocument', 'deleteDocument']),
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
                });
        }
    },
    computed: {
        ...mapGetters('SalesRevenue', ['document'])
    },
    created() {
        this.fetchDocument(this.id)
    }
}
</script>