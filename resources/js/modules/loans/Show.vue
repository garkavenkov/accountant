<template>
<div class="row">
    <div class="col-md-10 offset-md-1">

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-info"></i>            
                    Информация о кредите
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            {{loan.creditorName}}
                        </div>
                        <div>
                            {{loan.dateBegin}}
                        </div>
                        <div>
                            {{loan.amount}} {{loan.currencyCode}}
                        </div>
                        
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                             <button class="btn btn-primary"
                                data-toggle="modal" 
                                data-target="#modal-repayment-loan"
                                data-backdrop="static" 
                                data-keyboard="true">
                                    <i class="fas fa-plus"></i>
                                    Погасить
                            </button>
                        </div>
                        <div class="repayment" v-for="(repayment,index) in loan.repayments" :key="index">
                            {{repayment.date}} {{repayment.amount}} {{repayment.purpose}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>    

    <repayment-loan-form></repayment-loan-form>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

import RepaymentLoanForm from './RepaymentForm';

export default {
    props: ['id'],
    name: 'LoansShow',
    data() {
        return {
            
        }
    },
    methods: {
        ...mapActions(['fetchDocument'])
    },    
    computed: {
        ...mapGetters(['loan'])
    },
    created() {
        this.fetchDocument(this.id)
    },
    components: {
        RepaymentLoanForm
    }
}
</script>