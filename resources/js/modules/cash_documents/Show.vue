<template>

<div class="row">
    <router-link to="/">Back</router-link>
    <div class="col-6 offset-3">

        <div class="card">
            
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-coins"></i>
                    Кассовый документ
                </h3>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Тип документа</dt>
                    <dd class="col-sm-8">{{document.operation}}</dd>

                    <dt class="col-sm-4">№ документа</dt>
                    <dd class="col-sm-8">{{document.number}}</dd>

                    <dt class="col-sm-4">Дата</dt>
                    <dd class="col-sm-8">{{document.date}}</dd>
                    <!-- <dd class="col-sm-8">{{document.amount | formatNumber(2) }}</dd> -->

                    <!-- <dt class="col-sm-4">Статус</dt>
                    <dd class="col-sm-8">{{document.status}}</dd> -->
                </dl>
                <dl class="row">
                    <dt class="col-sm-4">Дебет</dt>
                    <dd class="col-sm-8">{{document.debet_name}}</dd>

                    <dt class="col-sm-4">Кредит</dt>
                    <dd class="col-sm-8">{{document.credit_name}}</dd>
                    
                    <dt class="col-sm-4">Назначение</dt>
                    <dd class="col-sm-8">{{document.purpose}}</dd>

                    <dt class="col-sm-4">Сумма</dt>                    
                    <dd class="col-sm-8">
                        <template v-if="document.credit > 0" >
                            {{document.credit | formatNumber(2)}}
                        </template>
                        <template v-else>
                            {{document.debet | formatNumber(2)}}
                        </template>
                    </dd>

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
                        v-if="document.status_code != 1"
                        class="btn btn-success btn-sm" 
                        title="Провести документ" 
                        @click="approveDoc(document.id)">
                            Провести
                    </button> 
                    <button 
                        v-if="document.status_code == 1"
                        class="btn btn-warning btn-sm" 
                        title="Распровести документ" 
                        @click="stornoDoc(document.id)">
                            Распровести
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
    name: 'CashDocumentsShow',
    props: ['id'],
    data() {
        return {
            document: {},
            links: {}
        }
    },
    methods: {
        fetchDocument(id) {
            // let page_url = state.filter.isFiltered ? (url + '?' + state.filter.queryStr) : url;
            let page_url = `/api/cash-documents/${id}`;
            axios
                .get(page_url,
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => {
                    // console.log(res.data.data);
                    this.document = res.data.data;
                    this.links = res.data.meta.links;
                    // this.makePagination(res.data.links, res.data.meta);
                })
                .catch(err => console.log(err));
        },
        approveDoc(id) {
            axios
                .get(`/api/approve-cash-document/${id}`,
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
                        title:'Good job!',
                        text:'Документ успешно проведен',
                        icon:'success',
                    });
                    this.document = res.data.data
                });

        },
        stornoDoc(id) {
            axios
                .get(`/api/storno-cash-document/${id}`,
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
                        title:'Good job!',
                        text:'Документ успешно распроведен',
                        icon:'success',
                    });
                    this.document = res.data.data
                });

        }

        // ...mapActions('SalesRevenue', ['fetchDocument', 'deleteDocument']),
        // deleteDoc(id) {
        //     this.deleteDocument(id)            
        //         .then(res => {
        //             Swal.fire({
        //                 toast: true,
        //                 position: 'top-end',
        //                 showConfirmButton: false,
        //                 timer: 3000,
        //                 // title:'Good job!',
        //                 text:'Документ успешно удален',
        //                 icon:'success',
        //             });                    
        //             this.$router.go(-1);
        //         });
        // }
    },
    computed: {
        // ...mapGetters('SalesRevenue', ['document'])
    },
    created() {
        this.fetchDocument(this.id)
    }
}
</script>