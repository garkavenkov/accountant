<template>
    <div class="modal fade" id="modal-accountability-form">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Добавить {{count}} в авансовый отчет </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label  for="dateBegin">Start date:</label>
                        <input  type="date" id="dateBegin" name="dateBegin" v-model="filter.dateBegin">
                        <label  for="dateEnd">End date:</label>
                        <input  type="date" id="dateEnd" name="dateEnd" :min="filter.dateBegin" v-model="filter.dateEnd">
                        <button class="btn btn-success" @click="getAccountabilities">Отобрать</button>
                    </div>
                    <div class="row" v-if="accountabilities.length > 0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Дата</th>
                                    <th>Касса</th>
                                    <th>Фамилия И.О.</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="accountability in accountabilities" :key="accountability.id">
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <!-- <input type="radio" id="radioPrimary3" name="r1" disabled=""> -->
                                            <input type="radio" v-model="selected" :value="accountability.id">
                                        </div>                                        
                                    </td>
                                    <td>{{accountability.date}}</td>
                                    <td>{{accountability.cash}}</td>
                                    <td>{{accountability.employee_full_name}}</td>
                                    <td>{{accountability.amount | formatNumber(2)}}</td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModal" tabindex="8">Отмена</button>
                    <button type="button" class="btn btn-primary" @click="addIntoAccountability" :disabled="!selected">Добавить</button>
                </div>
            </div>        
        </div>        
    </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'AccountabilityForm',
    props: {
        documents: {
            type: Array,
            required: true
        },
    },
    data() {
        return {
            // flags: []
            filter: {
                dateBegin: moment().format('YYYY-MM-DD'),
                dateEnd: null
            },
            accountabilities: [],
            selected: null
        }
    },
    methods: {
        // ...mapActions(['saveDocument']),        
        closeModal() {
            this.clearForm();
        },         
        clearForm() {            
            this.flags = [];
        },
        getAccountabilities() {
            let url = `api/accountabilities?date=${this.filter.dateBegin}&status=0`
            if (!this.filter.dateEnd) {
                url = url + `,${this.filter.dateBegin}`
            } else {
                url = url + `,${this.filter.dateEnd}`
            }
            axios.get(url, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }
                    }
                )
                .then(res => {
                    this.accountabilities = res.data.data;
                });
        },
        addIntoAccountability() {
            let item = {
                cash_document_id: this.selected,
                owner_id        : this.documents.map(doc => doc.id).join(','),
            }
            axios.post('api/add-document-into-accountability', item, {
                    'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }
                })
                .then(res => {
                     Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        // title:'Good job!',
                        text: res.data.message,
                        icon:'success',
                    });                
                })
        }
       
    },
    computed: {
        count() {
            let str = ''
            if (this.documents.length == 1) {
                str = 'документ'
            } else if (this.documents.length > 1 &&  this.documents.length <=4 ) {
                str = `${this.documents.length} документа`
            } else {
                str = `${this.documents.length} документов`
            }

            return str;
        }
    }
}
</script>