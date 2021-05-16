<template>
    <modal-dialog
            modalId="modal-expense-form"
            title="Расходный документ"
            @close="closeModal">

        <template v-slot:default>
            <div class="row">
                <div class="col-md-12">
                    <select-field
                        caption="Группа расходов"
                        hint="Выберите группу расходов"
                        id="group"
                        :options="groups"
                        v-model="groupId">
                    </select-field>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <select-field
                        caption="Категория расходов"
                        hint="Выберите категорию расходов"
                        id="category"
                        :options="categories"
                        v-model="categoryId">
                    </select-field>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <select-field
                        caption="Статья расходов"
                        hint="Выберите статью расходов"
                        id="item"
                        :options="items"
                        v-model="itemId">
                    </select-field>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Основание</label>                    
                        <textarea   name="purpose" 
                                    id="purpose" 
                                    class="form-control" 
                                    rows="2"
                                    v-bind:class="{'is-invalid' : hasError('purpose')}"
                                    v-model="purpose">
                        </textarea>
                        <span   id="supplier-error" 
                                class="error invalid-feedback">
                                {{getError('purpose')}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <input-field
                        label="Сумма"
                        id="amount"
                        v-model="amount"
                        :error="errors['amount']">
                    </input-field>
                </div>                 
            </div>
        </template>

        <template v-slot:buttons>
            <button type="button" class="btn btn-primary" @click="addExpense($event)">
                Сохранить
            </button>
        </template>

    </modal-dialog>    
</template>

<script>
import { mapActions } from 'vuex';

import ModalDialog from '../../components/ModalDialog';
import SelectField from '../../components/SelectField';
import InputField  from '../../components/InputField';
import FormValidator from "../../mixins/FormValidator";

export default {
    name: 'ExpenseForm',
    mixins: [FormValidator],
    data() {
        return {
            groups: [],
            groupId: 0,
            
            categories: [],
            categoryId: 0,

            items: [],
            itemId: 0,

            purpose: '',
            amount: 0
            
        }
    },
    methods: {
        ...mapActions(['getDictionary', 'fetchDocument']),
        getExpenseCategories() {
            this.getDictionary(`ExpenseItem?owner_id=${this.groupId}`)
                .then(res => {
                    this.categories = res
                });
        },
        clearForm(ctrlIsPressed) {          
            this.groupId = ctrlIsPressed ? this.groupId : 0;
            
            this.categoryId = ctrlIsPressed ? this.categoryId : 0;
            this.categories = ctrlIsPressed ? this.categories : [];
            
            this.itemId = ctrlIsPressed ? this.itemId : 0;
            this.items  = ctrlIsPressed ? this.items : [];

            this.purpose = '';
            this.amount = 0;

        },
        closeModal() {
            this.clearForm()
        },
        addExpense(e) {
            let item = {
                cash_document_id : this.$parent.document.id,
                type             : 'expense',
                owner_id         : this.itemId,
                purpose          : this.purpose,
                amount           : this.amount
            }
            axios.post(`api/accountability-items/`, item, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        }
                })
                .then(res => {
                    this.fetchDocument(this.$parent.document.id)
                    this.clearForm(e.ctrlKey);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        text:'Запись успешно добалена',
                        icon:'success',
                    });
                })

        }
    },
    watch: {
        groupId(newVal, oldVal) {
            if (newVal !== 0) {
                this.getDictionary(`ExpenseItem?owner_id=${newVal}`)
                    .then(res => {
                        this.categories = res;
                        this.categoryId = 0;
                        this.items = [];
                        this.itemId = 0;
                    });
            }
        },
        categoryId(newVal, oldVal) {
            if (newVal !== 0) {
                this.getDictionary(`ExpenseItem?owner_id=${newVal}`)
                    .then(res => {
                        this.items = res
                    });
            }
        }
    },
    created() {
        this.getDictionary('ExpenseItem?owner_id=0')
            .then(res => {
                this.groups = res
            });
    },
    components: {        
        ModalDialog,
        SelectField,
        InputField
    }
}
</script>