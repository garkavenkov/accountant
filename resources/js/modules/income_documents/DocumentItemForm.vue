<template>
    
 <div class="modal fade" id="modal-document-item">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{title}}</h4>
                <button type="button" class="close" aria-label="Close" @click="closeForm">
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
                                    v-model="item.name">                                
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
                                    v-model="item.measureId">
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
                                        v-model="item.quantity">                                
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
                            <label>Стоимость закупки</label>
                            <input  type="text" 
                                    name="purchasePrice" 
                                    id="purchasePrice" 
                                    class="form-control" 
                                    v-bind:class="{'is-invalid' : hasError('price')}"
                                    v-model="item.purchasePrice">                                        
                            <span   id="purchasePrice-error" 
                                    class="error invalid-feedback">
                                        {{getError('price')}}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Стоимость продажи</label>                    
                            <input  type="text" 
                                    name="retailPrice" 
                                    id="retailPrice" 
                                    class="form-control"
                                    v-bind:class="{'is-invalid' : hasError('price2')}"
                                    v-model="item.retailPrice">
                            <span   id="retailPrice-error" 
                                    class="error invalid-feedback">
                                        {{getError('price2')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" @click="closeForm">Отмена</button>
                <button type="button" class="btn btn-primary" @click="submitForm">{{submitText}}</button>
                <!-- <slot name="footer"></slot> -->
            </div>

        </div>
        
    </div>
    
</div>

</template>

<script>
import FormValidator from '../../mixins/FormValidator';

export default {
    name: 'DocumentItemForm',
    props: ['title', 'item', 'measures', 'submitText', 'errors'],
    mixins: [FormValidator],
    data() {
        return {

        }
    },
    methods: {
        closeForm() {
            this.$emit('closeForm');
        },
        submitForm() {
            this.$emit('submitForm');
        }

    }
}
</script>

<style scoped>
    button.close {
        outline: none;
    }
</style>