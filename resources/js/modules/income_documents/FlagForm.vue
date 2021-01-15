<template>
    <div class="modal fade" id="modal-tag-form">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Установить признак для {{count}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="firstForm" value="firstForm" v-model="flags">
                                <label class="form-check-label" for="firstForm">Форма 1</label>                                
                            </div>
                            <div class="form-check">                                
                                <input class="form-check-input" type="checkbox" id="bonus" value="bonus" v-model="flags">
                                <label class="form-check-label" for="bonus">Бонус</label>
                            </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal" tabindex="8">Close</button>
                    <button type="button" class="btn btn-primary" @click="setTag" tabindex="7" :disabled="flags.length == 0">Сохранить</button>
                </div>
            </div>        
        </div>        
    </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'IncomeDocumentFlagForm',
    props: {
        documents: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            flags: []
        }
    },
    methods: {
        ...mapActions(['saveDocument']),        
        closeModal() {
            this.clearForm();
        },         
        clearForm() {            
            this.flags = [];
        },
        setTag() {
            let ids = '';
            let flags = this.flags.join(',');            
            ids = this.documents.map(document => document.id).join(',');
            axios.get(`/api/income-document-set-flag?ids=${ids}&flags=${flags}`, {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    })
                    .then(res => {
                        if (res.status === 200) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,                                
                                text: res.data.message,
                                icon:'success',
                            });
                        }
                    })

        }
    },
    computed: {
        count() {
            let str = ''
            if (this.documents.length == 1) {
                str = 'документа'
            } else if (this.documents.length > 1) {
                str = 'документов'
            }

            return str;
        }
    }
}
</script>