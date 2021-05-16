<template>
    <loan-form modalId="modal-new-loan">
        <template slot="creditor">
            <div class="row">
                <div class="col-md-12">
                    <select-field
                        caption="Кредитор"
                        hint="Виберите кредитора"
                        id="creditor"
                        :options="creditors"
                        v-model="loan.creditorId"
                        :error="errors['counterparty_id']"
                    >
                    </select-field>
                </div>
            </div>
        </template>
    </loan-form>
</template>

<script>
import LoanForm from './LoanForm';
export default {
    name: 'Loan',
    data() {
        return {}
    },
    components: {
        LoanForm
    }
}
</script>