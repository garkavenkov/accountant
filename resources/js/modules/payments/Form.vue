<template>
    <div class="modal fade" id="modal-new-document">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Новый документ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Дата</label>                                
                                <input  type="date" 
                                        name="date" 
                                        id="date" 
                                        class="form-control datetimepicker-input" 
                                        v-bind:class="{'is-invalid' : hasError('date')}"
                                        v-model="newDocument.date">                                
                                <span   id="date-error" 
                                        class="error invalid-feedback">
                                            {{getError('date')}}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Касса</label>
                                <select class="form-control select2" 
                                        style="width: 100%;"
                                        name="cash"
                                        v-bind:class="{'is-invalid' : hasError('debet_id')}"
                                        v-model="newDocument.cashId">
                                    <option selected="selected" 
                                            disabled 
                                            value="0">
                                        Выберите кассу
                                    </option>
                                    <option v-for="cash in cashes" 
                                            :value="cash.id" 
                                            :key="cash.id">
                                                {{cash.name}}
                                    </option>                          
                                </select>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('debet_id')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Поставщик</label>
                                <select class="form-control select2" 
                                        name="supplier"
                                        id="supplier"
                                        style="width: 100%;" 
                                        v-bind:class="{'is-invalid' : hasError('credit_id')}"
                                        @change="supplierHasBeenChanged(newDocument.supplierId)"
                                        v-model="newDocument.supplierId">
                                    <option selected="selected" disabled value="0">
                                        Выбирите поставщика
                                    </option>
                                    <option v-for="supplier in suppliers" 
                                            :value="supplier.id" 
                                            :key="supplier.id">
                                                {{supplier.name}}
                                    </option>                          
                                </select>
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('credit_id')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Сумма</label>                    
                                <input  type="text" 
                                        name="amount" 
                                        id="amount" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('debet')}"
                                        v-model="newDocument.amount">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('debet')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                      <input :disabled="newDocument.supplierId == 0" class="custom-control-input" type="radio" id="customRadio1" name="customRadio" value="reciept" v-model="newDocument.basis">
                                      <label for="customRadio1" class="custom-control-label">Факт</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                      <input :disabled="newDocument.supplierId == 0" class="custom-control-input" type="radio" id="customRadio2" name="customRadio" value="debt" v-model="newDocument.basis">
                                      <label for="customRadio2" class="custom-control-label">Долг</label>
                                    </div>
                                </div>      
                            </div>
                    </div> 
                    <div class="row" v-if="newDocument.basis == 'debt'">
                        <div class="col-md-12">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Дата</th>
                                        <th>Отдел</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="document in unpaidDocuments" :key="document.id">
                                        <td><input type="checkbox" v-model="document.selected"></td>
                                        <td>{{document.date}}</td>
                                        <td>{{document.department}}</td>
                                        <td>{{document.purchaseSum}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>              
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Назначение</label>
                                <textarea   class="form-control" 
                                            name="purpose"
                                            id="purpose"
                                            v-bind:class="{'is-invalid' : hasError('purpose')}"
                                            v-model="newDocument.purpose"    
                                            rows="3" 
                                            placeholder="Назначение платежа">
                                </textarea>                               
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('purpose')}}
                                </span>
                            </div>
                        </div>       
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <!-- data-dismiss="modal" -->
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal">Close</button>
                    <div class="custom-control custom-switch" v-if="filter.isFiltered">
                        <input type="checkbox" id="useFilter" class="custom-control-input" v-model="useFilter">
                        <label for="useFilter" class="custom-control-label">Use filter</label>
                    </div>
                    <button type="button" class="btn btn-primary" @click="checkUnpaidDocuments()">Задолженность</button>
                    <button type="button" class="btn btn-primary" @click="saveDoc">Сохранить</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import Grid from '../../components/Grid';
import FormValidator from '../../mixins/FormValidator';

export default {
    name: 'PaymentForm',
    mixins: [FormValidator],
    data() {
        return {
            newDocument: {
                date                : new Date().toISOString().slice(0,10),
                cashId              : 0,
                supplierId          : 0,           
                purpose             : '',
                amount              : 0,
                basis               : 'reciept',
                ids                 : ''  
            },   
            useFilter: false,
            unpaidDocuments: [],
            selectedDocuments: [],
        }        
    },
    methods: {
        ...mapActions('Payment', ['saveDocument', 'getUnpaidDocuments']),
        ...mapActions('Dictionary', ['getCashesDictionary',  'getSuppliersDictionary']),
        saveDoc() {
            let doc = {
                    date                : this.newDocument.date,
                    debet_id            : this.newDocument.cashId,
                    credit_id           : this.newDocument.supplierId,
                    purpose             : this.newDocument.purpose,
                    // debet               : parseFloat(this.newDocument.amount.replace(",", "."))
                    debet               : this.newDocument.amount,
                    ids                 : this.newDocument.ids
                }
            this.saveDocument(doc)
                .then(res => {
                    this.clearForm();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        title:'Good job!',
                        text:'Документ успешно создан',
                        icon:'success',
                    });
                })
                .catch(err => this.errors = err.response.data.errors);     
        },
        closeModal() {            
            this.clearForm();
            this.useFilter = false;
        },
        clearForm() {
            this.errors = [];            
            this.newDocument.amount         = 0;
            this.newDocument.cashId         = this.filter.debetId   ? this.filter.debetId   : 0;
            this.newDocument.date           = this.filter.dateBegin ? this.filter.dateBegin : new Date().toISOString().slice(0,10);            
            this.newDocument.supplierId     = this.filter.creditId  ? this.filter.creditId  : 0;
            this.newDocument.purpose        = '';
            this.newDocument.ids            = '';
            this.newDocument.basis          = 'reciept';
            this.selectedDocuments          = [];
        },
        supplierHasBeenChanged(e) {
            if (this.newDocument.supplierId > 0) {                
                
                let el = document.querySelector('#supplier');
                let supplier = el.options[el.selectedIndex].text;
                
                if (this.newDocument.basis == 'debt') {
                    this.getUnpaidDocuments({supplierId: this.newDocument.supplierId})
                        .then(res => this.unpaidDocuments = res.data.data);

                    this.newDocument.purpose = `Погашение задолженности перед "${supplier}"`;    
                } else {
                    this.newDocument.purpose = `Оплата за товар от поставщика "${supplier}".`;
                }                
            }
            
        },
        checkUnpaidDocuments() {
            this.getUnpaidDocuments({supplierId: this.newDocument.supplierId});
            this.newDocument.basis = 'debt';
        }
    },
    computed: {
        ...mapGetters('Payment', ['filter']),
        ...mapGetters('Dictionary', ['cashes', 'suppliers'])
    },
    watch: {
        useFilter() {
            // console.log(`newValue: ${newValue} | oldValue: ${oldValue}`);
             if (this.useFilter) {
                 // Use filter date if set
                if (this.filter.dateBegin) {
                    document.getElementById('date').value = this.filter.dateBegin;
                    document.getElementById('date').setAttribute("min", this.filter.dateBegin)
                }
                if (this.filter.dateEnd) {
                    document.getElementById('date').setAttribute("max", this.filter.dateEnd)
                }

                // Use supplier if set
                if (this.filter.debetId) {
                    this.newDocument.cashId = this.filter.debetId
                }
                // Use department if set
                if (this.filter.creditId) {
                    this.newDocument.supplierId = this.filter.creditId
                }
            } else {
                document.getElementById('date').value = new Date().toISOString().slice(0,10);
                this.newDocument.date = new Date().toISOString().slice(0,10);
                this.newDocument.cashId = 0;
                this.newDocument.supplierId = 0;
                this.newDocument.amount = 0;                
            }    
        },
        'newDocument.basis'(newVal) {
            if (newVal == 'debt') {
                this.getUnpaidDocuments({supplierId: this.newDocument.supplierId})
                    .then(res => this.unpaidDocuments = res.data.data);
            } else {
                this.selectedDocuments = [];
                this.unpaidDocuments = [];
            }
        },
        unpaidDocuments: {
            handler: function (val, oldVal) {
                let totalDebt = 0;
                let ids = '';
                let purpose = '';

                this.selectedDocuments = this.unpaidDocuments.filter((document) => {
                    return document.selected == true;
                })
                
                if(this.selectedDocuments.length > 0 ) {
                    ids     = this.selectedDocuments.map((document) => document.id).join(",");
                    purpose = 'Погашение задолженности за товар от ' + this.selectedDocuments.map((document) => {
                        return ` ${document.date} ( ${document.department}  на сумма  ${document.purchaseSum}) `;
                    }).join(" и ");
                    totalDebt = this.selectedDocuments.reduce((a, b) => a + b.purchaseSum * 1.00, 0.00);                    
                }

                // console.log(`totalDebt = ${totalDebt} ,  newDocument.amount  = ${this.newDocument.amount}` );
                this.newDocument.amount = totalDebt;
                this.newDocument.ids = ids;
                this.newDocument.purpose = purpose;
            },
            deep: true
        },
    },
    created() {
        this.getCashesDictionary();
        this.getSuppliersDictionary();
    },
    components: {
        Grid
    }
}
</script>