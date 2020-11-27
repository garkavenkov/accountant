<template>
    
 <div class="modal fade" id="modal-document-item">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{title}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeForm">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Наименование</label>                                
                            <input  type="text" 
                                    name="name" 
                                    id="name" 
                                    class="form-control"
                                    v-bind:class="{'is-invalid' : hasError('name')}"
                                    v-model="data.name">                                
                            <span   id="name-error" 
                                    class="error invalid-feedback">
                                        {{getError('name')}}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ед. изм.</label>
                            <select class="form-control select2" 
                                    style="width: 100%;"
                                    v-bind:class="{'is-invalid' : hasError('measure_id')}"
                                    v-model="data.measureId">
                                <option selected="selected" 
                                        disabled 
                                        value="0">
                                    Выберите ед. измерения
                                </option>
                                <option v-for="measure in measures" 
                                        :value="measure.id" 
                                        :key="measure.id">
                                            {{measure.name}}
                                </option>                          
                            </select>
                            <span   id="measure_id-error" 
                                    class="error invalid-feedback">
                                        {{getError('measure_id')}}
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                                <label>Количество</label>                                
                                <input  type="text" 
                                        name="quantity" 
                                        id="quantity" 
                                        class="form-control"    
                                        v-bind:class="{'is-invalid' : hasError('quantity')}"
                                        v-model="data.quantity">                                
                                <span   id="quantity-error" 
                                        class="error invalid-feedback">
                                            {{getError('quantity')}}
                                </span>
                        </div>
                    </div>
                </div>                    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Старая цена</label>
                            <input  type="text" 
                                    name="oldPrice" 
                                    id="oldPrice" 
                                    class="form-control" 
                                    v-bind:class="{'is-invalid' : hasError('price')}"
                                    v-model="data.purchasePrice">                                        
                            <span   id="purchasePrice-error" 
                                    class="error invalid-feedback">
                                        {{getError('price')}}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Нщвая цена</label>                    
                            <input  type="text" 
                                    name="newPrice" 
                                    id="newPrice" 
                                    class="form-control"
                                    v-bind:class="{'is-invalid' : hasError('price2')}"
                                    v-model="data.retailPrice">
                            <span   id="retailPrice-error" 
                                    class="error invalid-feedback">
                                        {{getError('price2')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeForm">Close</button>
                <button type="button" class="btn btn-primary" @click="submitForm">{{submitText}}</button>
            </div>

        </div>
        
    </div>
    
</div>

</template>

<script>
import InputField       from '../../components/InputField';
import SelectField       from '../../components/SelectField';

import { mapActions }   from 'vuex';
import FormValidator    from '../../mixins/FormValidator';


export default {
    name: 'DocumentItemForm',
     name: 'DocumentItemForm',
    props: {
        data: {
            type: Object,
            required: true
        },
        action: {
            type: String,
            required: true
        },
        submitText: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        }
    }, 
    components: {
        InputField,
        SelectField
    },
    mixins: [FormValidator],
    data() {
        return {
            measures: [],
        }
    },
    methods: {
        ...mapActions(['saveDocumentItem', 'updateDocumentItem']),
        getMeasuresDictionary() {
            this.getDictionaryForSelect('measure')
                .then(res => this.measures = res);
        },      
        getDictionaryForSelect(dictionary) {
            return axios.get(`/api/select-dictionary/${dictionary}`, 
                        {
                            'headers': {
                                'Authorization': 'Bearer ' + window.api_token,
                                'Accept': 'application/json',
                            } 
                        }
                    )
                    .then(res => res.data)
                    .catch(err => console.log(err));
        },
        closeForm() {
            this.clearForm();
        },
        clearForm() {
            this.data.name          = '';
            this.data.measureId     = 0;
            this.data.quantity      = 0;
            this.data.retailPrice   = 0;            
            this.data.purchasePrice = 0;            
            this.errors             = [];
            this.itemId             = 0;            
        },
        submitForm() {          
            if (this.action == 'create') {
                this.saveItem()
            } else if (this.action == 'update') {
                this.updateItem()
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    title:'Ошибка',
                    text:'Недопустимое действие',
                    icon:'error',
                });    
            }          
        },
        
        saveItem() {
            let doc = {
                    document_id         : this.data.documentId,
                    name                : this.data.name,
                    quantity            : this.data.quantity,    
                    measure_id          : this.data.measureId,                    
                    price               : this.data.purchasePrice,
                    price2              : this.data.retailPrice
                }

            this.saveDocumentItem(doc)
                .then(res => {
                    if (res.status == 201) {                    
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
                    }
                })
                .catch(err => this.errors = err.response.data.errors);
        },
        
        updateItem() {

            let doc = {
                    document_id         : this.data.documentId,
                    id                  : this.data.id,
                    name                : this.data.name,
                    quantity            : this.data.quantity,    
                    measure_id          : this.data.measureId,
                    price               : this.data.purchasePrice,
                    price2              : this.data.retailPrice
                }

            this.updateDocumentItem(doc)
                .then(res => {
                    if (res.status == 201) {                    
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
                    }
                    $('#modal-document-item').modal('toggle');
                })
                .catch(err => this.errors = err.response.data.errors);
        },


    },created() {
        this.getMeasuresDictionary();
    }
}
</script>

<style scoped>
    button.close {
        outline: none;
    }
</style>