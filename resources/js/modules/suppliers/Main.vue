<template>

<div>
   <grid :suppliers="suppliers"></grid>
</div>

</template>

<script>
import Grid from './Grid';

export default {
    name: 'SuppliersMain',
    data() {
        return {
            suppliers: []
        }
    },
    methods: {
        fetchData() {               
            axios.get('/api/suppliers', 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => this.suppliers = res.data.data)
                .catch(err => console.log(err));
                
        }
    },
    created() {
        this.fetchData();
    },
    components: {
        Grid
    }
}    
</script>

