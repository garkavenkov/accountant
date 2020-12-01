<template>
    <div>{{date_begin}}
    </div>
</template>

<script>
export default {
    name: 'DepartmentTurnsShow',
    props: ['id', 'date_begin'],
    data() {
        return {

        }
    },
    created() {
        console.log(this.$route.query);
    }
}
</script>