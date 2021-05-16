<template>
    <modal-dialog
        title="Погашение кредита"
        modalId="modal-repayment-loan"
        @close="closeModal">

        <template v-slot:default>
            <div class="row">
                <div class="col-md-6">
                    <date-field
                        caption="Дата"
                        id="date"
                        v-model="document.date"
                        :error="errors['date']"
                    >
                    </date-field>
                </div>
                <div class="col-md-6">
                    <select-field
                        caption="Касса"
                        hint="Виберите кассу"
                        id="cash"
                        :options="cashes"
                        v-model="document.cashId"
                        :error="errors['cash_id']"
                    >
                    </select-field>
                </div>
            </div>          

            <div class="row">
                <div class="col-md-6">
                     <select-field
                        caption="Валюта"
                        hint="Виберите валюту"
                        id="currency"
                        :options="currencies"
                        v-model="document.currencyId"
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
                        v-model="document.amount2"
                        :error="errors['amount2']"
                    >
                    </input-field>
                </div>
                <div class="col-md-6">
                    <input-field
                        label="Сумма"
                        id="amount"
                        v-model="document.amount"
                        :error="errors['amount']"
                    >
                    </input-field>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Назначение</label>
                        <textarea   class="form-control" 
                                    name="purpose"
                                    id="purpose"
                                    v-bind:class="{'is-invalid' : hasError('purpose')}"
                                    v-model="document.purpose"    
                                    rows="3" 
                                    placeholder="Назначение платежа">
                        </textarea>                               
                        <span   id="supplier-error" 
                                class="error invalid-feedback">
                                    {{getError('purpose')}}
                        </span>
                    </div>
                </div>       
            </div>
        </template>

        <template v-slot:buttons>
            <button type="button" class="btn btn-primary" @click="repaymentLoan">
                Погасить
            </button>
        </template>

    </modal-dialog>        
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import ModalDialog from "../../components/ModalDialog";
import FormValidator from "../../mixins/FormValidator";
import SelectField from "../../components/SelectField";
import DateField from "../../components/DateField";
import InputField from "../../components/InputField";

export default {
    name: 'RepaymentLoanForm',
    mixins: [FormValidator],
    data() {
        return {
            document: {
                date: moment().format('YYYY-MM-DD'),
                cashId: 0,
                currencyId: 0,                
                purpose: '',
                amount: 0,
                amount2: 0
            },
            foreignCurrency: false,
            currencyAmount: '',
            currency: [],
            template: 'Погашение !part! кредита !creditorName! от !creditDate! !currencyAmount!'
        }
    },
    methods: {        
        ...mapActions([
            "getCurrenciesDictionary",
            "getCashesDictionary"
        ]),
        repaymentLoan() {
            let doc = {
                loan_id :   this.$parent.id,
                amount  :   this.document.amount,
                amount2 :   this.document.amount2,
                purpose :   this.document.purpose,
                date    :   this.document.date,
                cash_id :   this.document.cashId
            }
            axios.post('api/repayment-loan', doc, {
                    'headers': {
                        'Authorization': 'Bearer ' + window.api_token,
                        'Accept': 'application/json',
                    }       
                })
                .then(res => {console.log(res)});
        },
        closeModal() {
            this.document.date          = moment().format('YYYY-MM-DD');
            this.document.cashId        = 0;
            this.document.currencyId    = 0;
            this.document.purpose       = '';
            this.document.amount        = 0;
            this.document.amount2       = 0;
        }
    },
    computed: {
        ...mapGetters(['cashes', 'currencies'])
    },
    created() {
        this.getCashesDictionary();
        this.getCurrenciesDictionary();
    },
    watch: {
        'document.currencyId'() {
            this.document.amount = 0;
            this.document.amount2 = 0;
            this.currency = this.currencies.filter(cur => cur.id == this.document.currencyId);
            if (this.currency[0].code !== 'RUB') {
                this.foreignCurrency  = true;
                this.currencyAmount = `Сумма в ${this.currency[0].code}`
            } else {
                this.foreignCurrency = false;
                this.currencyAmount = 'Сумма'
            }
            
        },
        'document.amount'() {
            let str = '';
            str = this.template
                    .replace(/!part!/, 'части')
                    .replace(/!creditorName!/, this.$parent.loan.creditorName )
                    .replace(/!creditDate!/, this.$parent.loan.dateBegin );
            
            if (this.document.amount2 > 0) {                
                str = str.replace(/!currencyAmount!/, `(${this.document.amount2} ${this.currency[0].code})`);
            } else {
                str = str.replace(/!currencyAmount!/, '');
            }
                    
            this.document.purpose = str;
        },
        'document.amount2'() {
            let str = '';
            // str = `Погашение части кредита ${this.$parent.loan.creditorName} от ${this.$parent.loan.dateBegin} (${this.document.amount2} ${this.currency[0].code})`;
            str = this.template
                    .replace(/!part!/, 'части')
                    .replace(/!creditorName!/, this.$parent.loan.creditorName )
                    .replace(/!creditDate!/, this.$parent.loan.dateBegin )
                    .replace(/!currencyAmount!/, `(${this.document.amount2} ${this.currency[0].code})`);
                    
            this.document.purpose = str;            
        }
    },
    components: {
        ModalDialog,
        SelectField,
        DateField,
        InputField
    }
}
</script>
        ModalDialog