<template>
    <abbr :title="title">
        <slot>
            <i class="fas fa-donate"></i>
        </slot>
    </abbr>    
</template>

<script>
export default {
    props: ['payments'],    
    computed: {
        title: function() {
            let msg = '';
            if (this.payments.length == 1) {
                msg = `Оплата произведена ${this.payments[0].date} \n${this.payments[0].cash}`;
            } else {
                this.payments.forEach(payment => {
                   msg = msg + `\t${payment.cash}: ${payment.date} - ${payment.amount.toLocaleString('ru-RU', { minimumFractionDigits: 2 }) }\n`;
                });
                msg = 'Оплата произведена частями:\n' + msg;
            }

            return msg;
        }
    }
}
</script>

<style>
    .fa-donate {
        color: red;
    }
</style>