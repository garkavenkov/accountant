<template>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Построение отчета</h3>
        <button class="btn btn-primary" @click="makeReport">Отчет</button>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <tbody>
                <!-- <tr v-for="(supplier, index) in data" :key="index">
                    <td colspan="3">{{supplier}}</td>
                </tr> -->
                <!-- <template v-for="[key1, value] of Object.entries(data)">
                    <tr :key="key1">
                        <td colspan="4">{{key1}}</td>                        
                    </tr>
                    <template v-for="[key2, value] of Object.entries(value)">
                        <tr :key="key2">
                            <td>{{key2}}</td>
                            <td>{{value}}</td>
                        </tr>
                    </template>                    
                </template>                 -->
            </tbody>
        </table>
    </div>
</div>

</template>

<script>
export default {
    name: 'ReportsMain',
    data() {
        return {
            data: {},
            keys: []
        }
    },
    methods: {
        makeReport() {
            axios.get('api/report', {
                     'headers': {
                        'Authorization': 'Bearer ' + window.api_token,
                        'Accept': 'application/json',
                    } 
                })
                .then(res => {
                    // this.keys = Object.keys(res.data);
                    this.data = res.data;
                })
        }
    }
}
</script>
