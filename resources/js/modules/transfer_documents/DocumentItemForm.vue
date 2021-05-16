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
                        <input-field    label="Наименование"
                                        id="name"
                                        v-model="data.name"
                                        placeholder="Наименование спецификации"
                                        :error="errors['name']">
                        </input-field>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <select-field   caption="Ед. изм."
                                        hint="Выберите ед. измерения"
                                        :options="measures"
                                        id="measureId"
                                        v-model="data.measureId"
                                        :error="errors['measure_id']">
                        </select-field>
                    </div>
                    <div class="col-sm-6">
                        <input-field    label="Количество"
                                        id="quantity"
                                        v-model="data.quantity"
                                        :error="errors['quantity']">
                        </input-field>
                    </div>
                </div>                    
                <div class="row">
                    <div class="col-md-6">
                        <input-field    label="Стоимость закупки"
                                        id="purchasePrice"
                                        v-model="data.purchasePrice"
                                        :error="errors['price']">
                        </input-field>
                    </div>
                    <div class="col-md-6">
                        <input-field    label="Стоимость продажи"
                                        id="retailPrice"
                                        v-model="data.retailPrice"
                                        :error="errors['price2']">
                        </input-field>
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
        closeForm() {
            this.clearForm();
        },
        clearForm() {
            this.data.name          = '';
            this.data.measureId     = 0;
            this.data.quantity      = 0;
            this.data.purchasePrice = 0;            
            this.data.retailPrice   = 0;            
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
    },
    created() {
        this.getMeasuresDictionary()
    },  
}
</script>

<style scoped>
    button.close {
        outline: none;
    }
</style>