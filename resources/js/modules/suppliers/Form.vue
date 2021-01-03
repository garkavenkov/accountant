<template>
    <div class="modal fade" id="modal-new-supplier">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Новый поставщик</h4>
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
                                        v-model="newSupplier.name">
                                <span   id="name-error" 
                                        class="error invalid-feedback">
                                            {{getError('name')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Полное наименование</label>                    
                                <input  type="text" 
                                        name="full_name" 
                                        id="full_name" 
                                        class="form-control" 
                                        v-bind:class="{'is-invalid' : hasError('full_name')}"
                                        v-model="newSupplier.full_name">
                                <span   id="name-error" 
                                        class="error invalid-feedback">
                                            {{getError('full_name')}}
                                </span>
                            </div>
                        </div>
                    </div>                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Описание</label>                    
                                <textarea   name="description" 
                                            id="description" 
                                            class="form-control" 
                                            rows="2"
                                            v-bind:class="{'is-invalid' : hasError('description')}"
                                            v-model="newSupplier.description">
                                </textarea>
                                <span   id="description-error"
                                        class="error invalid-feedback">
                                        {{getError('description')}}
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
    name: 'DepartmentForm',
    mixins: [FormValidator],
    data() {
        return {
            newSupplier: {
                name                : '',
                full_name           : '',
                description         : '',
            },
        }        
    },
    methods: {
        ...mapActions(['saveDocument']),
        saveDoc() {
            let doc = {
                    name                : this.newSupplier.name,
                    full_name           : this.newSupplier.full_name,
                    description         : this.newSupplier.description,
                }
            this.saveDocument(doc)
                .then(res => {
                    this.clearForm();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        text:'Отдел успешно добавлен',
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
            this.newSupplier.name         = '';
            this.newSupplier.full_name    = '';
            this.newSupplier.description  = '';            
        },        
    }
}
</script>