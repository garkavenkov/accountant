<template>
    <div class="modal fade" id="modal-new-document">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Новое подразделение</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Наименование</label>                    
                                <input  type="text" 
                                        name="name" 
                                        id="name" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('name')}"
                                        v-model="newBranch.name">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('name')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Адресс</label>                    
                                <input  type="text" 
                                        name="address" 
                                        id="address" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('address')}"
                                        v-model="newBranch.address">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('address')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Дата открытия</label>                                
                                <input  type="date" 
                                        name="opened" 
                                        id="opened" 
                                        class="form-control datetimepicker-input" 
                                        v-bind:class="{'is-invalid' : hasError('opened')}"
                                        v-model="newBranch.opened">                                
                                <span   id="date-error" 
                                        class="error invalid-feedback">
                                            {{getError('opened')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Дата закрытия</label>                                
                                <input  type="date" 
                                        name="closed" 
                                        id="closed" 
                                        class="form-control datetimepicker-input" 
                                        v-bind:class="{'is-invalid' : hasError('closed')}"
                                        v-model="newBranch.closed">                                
                                <span   id="date-error" 
                                        class="error invalid-feedback">
                                            {{getError('closed')}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal">Close</button>                    
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

import FormValidator from '../../mixins/FormValidator';

export default {
    name: 'BranchForm',
    mixins: [FormValidator],
    data() {
        return {
            newBranch: {
                name                : '',
                address             : '',
                opened              : new Date().toISOString().slice(0,10),
                closed              : null
            },
        }        
    },
    methods: {
        ...mapActions(['saveDocument']),        
        saveDoc() {
            let doc = {
                    name                : this.newBranch.name,
                    address             : this.newBranch.address,
                    opened              : this.newBranch.opened,
                    closed              : this.newBranch.closed                    
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
                        text:'Подразделение успешно добалено',
                        icon:'success',
                    });
                })
                .catch(err => this.errors = err.response.data.errors);     
        },
        closeModal() {        
            this.clearForm();
        },
        clearForm() {
            this.errors = [];
            this.newBranch.name         = '';
            this.newBranch.address      = '';
            this.newBranch.opened       = null;
            this.newBranch.closed       = null;
        },        
    },
    computed: {        
    },
    watch: {
    },
    created() {
        // this.getCashesDictionary();
        // this.getSuppliersDictionary();
    },
    components: {        
    }
}
</script>