<template>

<div>
   <grid :positions="positions"></grid>
</div>

</template>

<script>
import Grid from './Grid';

export default {
    name: 'PositionsMain',
    data() {
        return {
            positions: []
        }
    },
    methods: {
        fetchData() {               
            axios.get('/api/positions', 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => this.positions = res.data.data)
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

