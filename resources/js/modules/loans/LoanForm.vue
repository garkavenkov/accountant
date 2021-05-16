<template>
    <modal-dialog
        title="Новый кредит"
        :modalId="modalId"
        @close="closeModal"
    >
        <template v-slot:default>
            <div class="row">
                <div class="col-md-6">
                    <date-field
                        caption="Дата"
                        id="date"
                        v-model="loan.dateBegin"
                        :error="errors['date_begin']"
                    >
                    </date-field>
                </div>
                <div class="col-md-6">
                    <select-field
                        caption="Касса"
                        hint="Виберите кассу"
                        id="cash"
                        :options="cashes"
                        v-model="loan.cashId"
                        :error="errors['cash_id']"
                    >
                    </select-field>
                </div>
            </div>
            
            <slot name="creditor"></slot>
            
            <div class="row">
                <div class="col-md-6">
                     <select-field
                        caption="Валюта"
                        hint="Виберите валюту"
                        id="currency"
                        :options="currencies"
                        v-model="loan.currencyId"
                        :error="errors['currency_id']"
                    >
                    </select-field>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" v-if="foreignCurrency">
                    <input-field
                        :label="currencyAmount"
                        id="currencyAmount"
                        v-model="loan.amount2"
                        :error="errors['amount2']"
                    >
                    </input-field>
                </div>
                <div class="col-md-6">
                    <input-field
                        label="Сумма"
                        id="amount"
                        v-model="loan.amount"
                        :error="errors['amount']"
                    >
                    </input-field>
                </div>
            </div>
        </template>

        <template v-slot:buttons>
            <button type="button" class="btn btn-primary" @click="saveLoan">
                Сохранить
            </button>
        </template>
    </modal-dialog>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

import ModalDialog from "../../components/ModalDialog";
import SelectField from "../../components/SelectField";
import InputField from "../../components/InputField";
import DateField from "../../components/DateField";
import FormValidator from "../../mixins/FormValidator";

export default {
    name: "LoanForm",
    props: ['modalId'],
    mixins: [FormValidator],
    data() {
        return {
            loan: {
                dateBegin: new Date().toISOString().slice(0, 10),
                cashId: 0,
                currencyId: 0,                
                creditorId: 0,
                amount: 0,
                amount2: 0
            },
            foreignCurrency: false,
            currencyAmount: '',
            currency: ''
        };
    },
    methods: {
        ...mapActions([
            "saveDocument",
            "getCreditorsDictionary",
            "getCurrenciesDictionary",
            "getCashesDictionary"
        ]),
        saveLoan() {
            let doc = {
                date_begin          : this.loan.dateBegin,
                currency_id         : this.loan.currencyId,
                counterparty_id     : this.loan.creditorId,
                cash_id             : this.loan.cashId,
                amount              : this.loan.amount,
                amount2             : this.loan.amount2,
            };
            this.saveDocument(doc)
                .then(res => {
                    this.clearForm();
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000,
                        text: res.data.message,
                        icon: "success"
                    });
                })
                .catch(err => (this.errors = err.response.data.errors));
        },
        closeModal() {
            this.clearForm();
        },
        clearForm() {
            this.loan.dateBegin = moment().format("YYYY-MM-DD");
            this.loan.currencyId = 0;
            this.loan.creditorId = 0;
            this.loan.cashId = 0;
            this.loan.amount = 0;
            this.loan.amount2 = 0;
            this.foreignCurrency = false;
            this.errors = [];
        }
    },
    computed: {
        ...mapGetters(["creditors", "currencies", "cashes"])
    },
    watch: {
        'loan.currencyId'() {
            this.loan.amount = 0;
            this.loan.amount2 = 0;
            let currency = this.currencies.filter(cur => cur.id == this.loan.currencyId);
            if (currency[0].code !== 'RUB') {
                this.foreignCurrency  = true;
                this.currencyAmount = `Сумма в ${currency[0].code}`
            } else {
                this.foreignCurrency = false;
                this.currencyAmount = 'Сумма'
            }
            
        }
    },
    created() {
        this.getCreditorsDictionary();
        this.getCurrenciesDictionary();
        this.getCashesDictionary();
    },
    components: {
        SelectField,
        InputField,
        DateField,
        ModalDialog
    }
};
</script>
