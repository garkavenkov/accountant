<template>
    <abbr :title="title">
        <slot>
            <i class="fas fa-receipt accountability"></i>
        </slot>
    </abbr>    
</template>

<script>
export default {
    props: ['accountability'],    
    computed: {
        title: function() {
            let msg = '';
            // if (this.accountability.length == 1) {
                msg = `Авансовый документ от ${this.accountability.date} на сумму ${this.accountability.amount} \n${this.accountability.employee_full_name} (${this.accountability.cash})`;
            // }

            return msg;
        }
    }
}
</script>

<style>
    .accountability {
        color: steelblue;
    }
</style>