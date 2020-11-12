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
                msg = `Оплата произведена ${this.payments[0].date} \n ${this.payments[0].cash}`;
            }

            return msg;
        }
    }
}
</script>