<template>
   
<div class="row">
    <!-- <div class="col-md-10 offset-md-1"> -->
        <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Связать товарные накладные с кассовыми документами</h3>
                <div class="card-tools">
                  <!-- <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <!-- <a href="#" class="btn btn-tool btn-sm" @click="setRest">
                    <i class="fas fa-cog"></i>
                  </a> -->
                  <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-cog"></i>
                      <span class="sr-only">Toggle Dropdown</span>
                      <div class="dropdown-menu" role="menu" style="">
                        <a class="dropdown-item" href="#" @click="searchPairs">Search Pairs</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                      </div>
                    </button>
                </div>
            </div>                

            <div class="card-body">
                <div class="row">

                </div>
                <div class="row">                       
                    <div class="col-md-5">
                    <!-- <div class="col"> -->
                        <div class="card">
                            <div class="card-header" :class="{'border-0': !documentFilterIsShown}">
                                <h4 class="card-title">Товарные накладные
                                </h4>
                                <div class="card-tools">
                                    <a href="#" class="btn btn-tool btn-sm" @click="documentFilterIsShown = !documentFilterIsShown">
                                        <i class="fas fa-filter"></i>
                                    </a>
                                </div>
                            </div>  
                            <div class="panel-collapse in collapse" :class="{show: documentFilterIsShown}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select-field caption="Подразделение"
                                                    hint="Все подразделения"
                                                    :options="branches"
                                                    :disabledHint="false"
                                                    id="branches"
                                                    v-model="filterDocument.branchId"
                                                    name="name">
                                            </select-field>                           
                                        </div>
                                        <div class="col-md-6">
                                            <select-field caption="Поставщик"
                                                    hint="Все поставщики"
                                                    :options="suppliers"
                                                    :disabledHint="false"
                                                    id="suppliers"
                                                    v-model="filterDocument.supplierId"
                                                    name="name">
                                            </select-field>                           
                                        </div>
                                    </div>
                                    <div class="row">                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Дата с</label>
                                                <input  type="date" 
                                                        name="dateBegin" 
                                                        id="dateBegin" 
                                                        class="form-control datetimepicker-input"
                                                        v-model="filterDocument.dateBegin">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Дата по</label>
                                                <input  type="date" 
                                                        name="dateEnd" 
                                                        id="dateEnd" 
                                                        class="form-control datetimepicker-input" 
                                                        :min="filterDocument.dateBegin"
                                                        :disabled="!filterDocument.dateBegin"
                                                        v-model="filterDocument.dateEnd">
                                            </div>
                                        </div>
                                    </div>        
                                    <div class="row">
                                        <button class="btn btn-primary" @click="getUnpaidDocuments">
                                            Применить
                                        </button>
                                    </div>
                                </div>
                            </div>                          
                            <div class="card-body table-responsive p-0">
                                <table v-if="documents.length > 0" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Поставщик</th>
                                            <th>Отдел</th>
                                            <th>Сумма</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="document in documents" :key="document.id">
                                            <td>{{document.date}}</td>
                                            <td>{{document.supplier}}</td>
                                            <td>{{document.department}}</td>
                                            <td>{{document.purchaseSum | formatNumber(2)}}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" v-if="!document.selected" @click="selectDocument(document)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" v-else @click="unselectDocument(document)">
                                                    <i class="fas fa-minus"></i>
                                                </button>                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Документы для связи</h4>
                            </div>
                            <div class="card-body" v-if="links.length > 0">
                                <div>Найдено {{links.length}} связей</div>
                                <button class="btn btn-secondary" @click="linkPairs" v-if="links.length > 0">Связать</button>
                            </div>
                            <div class="card-body" v-if="selectedDocuments.length > 0 || selectedPayments.length > 0">
                                <div>{{selectedDocuments}}</div>
                                <div>{{selectedPayments}}</div>
                                <button class="btn btn-secondary" @click="linkDocuments" v-if="selectedDocuments.length > 0 && selectedPayments.length > 0">Связать</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                    <!-- <div class="col"> -->
                        <div class="card">
                            <div class="card-header" :class="{'border-0': !paymentFilterIsShown}">
                                <h4 class="card-title">Кассовые документы</h4>
                                <div class="card-tools">
                                    <a href="#" class="btn btn-tool btn-sm" @click="paymentFilterIsShown = !paymentFilterIsShown">
                                        <i class="fas fa-filter"></i>
                                    </a>
                                </div>                                
                            </div>
                            <div class="panel-collapse in collapse" :class="{show: paymentFilterIsShown}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select-field caption="Касса"
                                                        hint="Все кассы"
                                                        :options="cashes"
                                                        :disabledHint="false"
                                                        v-model="filterPayment.cashId"
                                                        name="name">
                                                </select-field>                           
                                            </div>
                                            <div class="col-md-6">
                                                <select-field caption="Поставщик"
                                                        hint="Все поставщики"
                                                        :options="suppliers"
                                                        :disabledHint="false"
                                                        v-model="filterPayment.supplierId"
                                                        name="name">
                                                </select-field>                           
                                            </div>
                                        </div>
                                        <div class="row">                        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Дата с</label>
                                                    <input  type="date" 
                                                            name="paymentDateBegin" 
                                                            id="paymentDateBegin" 
                                                            class="form-control datetimepicker-input"
                                                            v-model="filterPayment.dateBegin">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Дата по</label>
                                                    <input  type="date" 
                                                            name="paymentDateEnd" 
                                                            id="paymentDateEnd" 
                                                            class="form-control datetimepicker-input" 
                                                            :min="filterPayment.dateBegin"
                                                            :disabled="!filterPayment.dateBegin"
                                                            v-model="filterPayment.dateEnd">
                                                </div>
                                            </div>
                                        </div>        
                                        <div class="row">
                                            <button class="btn btn-primary" @click="getUnlinkedPayments">
                                                Применить
                                            </button>
                                        </div>
                                    </div>
                                </div>                          
                            <div class="card-body table-responsive p-0">
                                <table v-if="payments.length > 0" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Дата</th>
                                            <th>Касса</th>
                                            <th>Поставщик</th>
                                            <th>Сумма</th>                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="payment in payments" :key="payment.id">
                                            <td>                                                
                                                <button class="btn btn-sm btn-primary" v-if="!payment.selected" @click="selectPayment(payment)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" v-else @click="unselectPayment(payment)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </td>
                                            <td>{{payment.date}}</td>
                                            <td>{{payment.cash}}</td>
                                            <td>{{payment.supplier}}</td>
                                            <td>{{payment.amount | formatNumber(2)}}</td>                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>            
    </div>    
    
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import SelectField  from '../../components/SelectField';

export default {
    name: 'LinkPaymentsMain',    
    data() {
        return {            
            links: [],
            link: {},
            documents: [],
            payments: [],
            selectedDocuments: [],
            selectedPayments: [],
            documentFilterIsShown: false,
            paymentFilterIsShown: false,
            filterDocument: {
                branchId: 0,
                supplierId: 0,
                dateBegin: moment().format("YYYY-MM-DD"),
                // dateEnd: moment().format("YYYY-MM-DD"),
                dateEnd: null
            },
            filterPayment: {
                cashId: 0,
                supplierId: 0,
                dateBegin: moment().format("YYYY-MM-DD"),
                // dateEnd: moment().format("YYYY-MM-DD"),
                dateEnd: null
            }
        }
    },
    methods: {        
        ...mapActions('LinkPayment', ['getBranchesDictionary', 'getSuppliersDictionary', 'getCashesDictionary']),
        // getDocuments() {
        //     let filterDocuments = {
        //         branchId: 1,
        //         dateBegin: "2021-01-02"
        //     };
        
        //     this.getUnpaidDocuments(filterDocuments);
        // },
        getUnpaidDocuments() {
            let url =  `/api/get-unpaid-documents?branch_id=${this.filterDocument.branchId}&date_begin=${this.filterDocument.dateBegin}`;
            this.selectedDocuments = [];
            if (this.filterDocument.dateEnd) {
                url = url + `&date_end=${this.filterDocument.dateEnd}`;
            }
            if (this.filterDocument.supplierId > 0) {
                url = url + `&supplier_id=${this.filterDocument.supplierId}`;
            }

            axios
                .get(url, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }   
                    }
                )
                .then(res => {
                    this.documents = res.data.data
                });
                //.catch(err => reject(err));
        },        
        // getPayments() {
        //     let filterPayments = {
        //         cashId: 1,
        //         dateBegin: "2021-01-02"
        //     };
        
        //     this.getUnlinkedPayments(filterPayments);
        // },
        getUnlinkedPayments() {
            let url =  `/api/get-unlinked-payments?cash_id=${this.filterPayment.cashId}&date_begin=${this.filterPayment.dateBegin}`;
            this.selectedPayments = [];
            if (this.filterPayment.dateEnd) {
                url = url + `&date_end=${this.filterPayment.dateEnd}`;
            }
            if (this.filterPayment.supplierId > 0) {
                url = url + `&supplier_id=${this.filterPayment.supplierId}`;
            }
            axios
                .get(url, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }   
                    }
                )
                .then(res => {
                    this.payments = res.data.data
                });
                //.catch(err => reject(err));
        },
        selectDocument(document) {
            this.selectedDocuments.push(document);
            // this.link.documentId = document.id;
            this.documents.forEach(function(el) {
                if (el.id == document.id) {
                    el.selected = true
                } 
            });      
            this.$forceUpdate();
        },        
        unselectDocument(document) {
            let index = this.selectedDocuments.indexOf(document);
            this.selectedDocuments.splice(index, 1);
            this.documents.forEach(function (el) {
                if (el.id == document.id) {
                    delete el.selected;
                }
            });
            this.$forceUpdate();
        },
        selectPayment(payment) {
            this.selectedPayments.push(payment);
            // this.link.paymentId = payment.id;
            this.payments.forEach(function(el) {
                if (el.id == payment.id) {
                    el.selected = true
                } 
            });      
            this.$forceUpdate();
        },
        unselectPayment(payment) {
            let index = this.selectedPayments.indexOf(payment);
            this.selectedPayments.splice(index, 1);
            this.payments.forEach(function (el) {
                if (el.id == payment.id) {
                    delete el.selected;
                }
            });
            this.$forceUpdate();
        },
        searchPairs() {
            this.links = [];            
            this.documents.forEach(d => {
                this.payments.find(p => {
                    if ((p.branchId == d.branchId) && (p.supplierId == d.supplierId) && (Math.round(p.amount) == Math.round(d.purchaseSum))) {
                        this.links.push({documentId: d.id, paymentId: p.id})
                    }
                })
            });
        },
        linkPairs() {           

            let linksStr = this.links.map(link => link.documentId + ':' + link.paymentId).join(';');
            
            axios
                .post('api/link-documents', 
                    {
                        'data'  : linksStr,
                        'type'  :  'payment'
                    },
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }   
                    }
                )
                .then(res => {
                    if (res.status == 201) {
                        // this.links = [];
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            // title:'Good job!',
                            text: res.data.message,
                            icon:'success',
                        });
                        let linkedDocuments = this.links.map(link => link.documentId);
                        let linkedPayments  = this.links.map(link => link.paymentId);
                       
                        this.documents = this.documents.filter(document => !linkedDocuments.includes(document.id) );
                        this.payments  = this.payments.filter(payment => !linkedPayments.includes(payment.id) );
                        this.links = [];
                    }
                    
                });
        },
        linkDocuments() {
            let documentId = this.selectedDocuments.map(document => document.id).join(',');
            let paymentId  = this.selectedPayments.map(payment => payment.id).join(',');

            let linkStr = documentId + ':' + paymentId;

            axios
                .post('api/link-documents', 
                    {
                        'data'  :  linkStr,
                        'type'  :  'payment'
                    },
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }   
                    }
                )
                .then(res => {
                    if (res.status == 201) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            // title:'Good job!',
                            text: res.data.message,
                            icon:'success',
                        });                        
                       
                        this.documents = this.documents.filter(d => !this.selectedDocuments.map(doc => doc.id).includes(d.id));
                        this.payments  = this.payments.filter(p => !this.selectedPayments.map(pay => pay.id).includes(p.id));

                        this.selectedDocuments = [];
                        this.selectedPayments = [];
                    }
                });
        }
    },
    computed: {
        ...mapGetters('LinkPayment', ['branches', 'suppliers', 'cashes'])
    },
    watch: {
        // selectedDocuments(newVal, oldVal) {
        //     console.log('newVal ------');
        //     console.log(newVal);
        //     console.log('oldVal ------');
        //     console.log(oldVal);
        // }
    },
    created() {
        this.getCashesDictionary();
        this.getBranchesDictionary();
        this.getSuppliersDictionary();        
    },
    components: {
        SelectField,
    },
}
</script>

