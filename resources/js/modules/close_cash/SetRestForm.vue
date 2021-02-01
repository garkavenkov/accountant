<template>
    <div class="modal fade" id="modal-set-rest">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Установить остаток</h4>
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
                                        v-model="newRest.date">                                
                                <span   id="date-error" 
                                        class="error invalid-feedback">
                                            {{getError('date')}}
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
                                        v-bind:class="{'is-invalid' : hasError('rest')}"
                                        v-model="newRest.rest"
                                        autocomplete="off">
                                <span   id="supplier-error" 
                                        class="error invalid-feedback">
                                            {{getError('rest')}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">                    
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal">Close</button>                    
                    <button type="button" class="btn btn-primary" @click="setRest">Установить</button>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>

import FormValidator from '../../mixins/FormValidator';

export default {
    name: 'SetRestForm',
    mixins: [FormValidator],
    props: {
        'cashId': {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            newRest: {
                date                : null,
                rest                : 0,
            },   
        }        
    },
    methods: {
        setRest() {
            let doc = {
                    date        : this.newRest.date,
                    rest        : this.newRest.rest,
                    owner_id    : this.cashId,
                }
            axios.patch('/api/set-cash-rest', doc, {
                    'headers': {
                        'Authorization': 'Bearer ' + window.api_token,
                        'Accept': 'application/json',
                    }
                })
                .then(res => {
                    this.clearForm();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        // title:'Good job!',
                        text:res.data.message,
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
            this.newRest.rest         = 0;
        },
    },  
    created() {
        // this.getCashesDictionary();
    }
}
</script>