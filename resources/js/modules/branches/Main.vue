<template>

<div>
   <grid :branches="branches"></grid>
</div>

</template>

<script>
import Grid from './Grid';

export default {
    name: 'BranchesMain',
    data() {
        return {
            branches: []
        }
    },
    methods: {
        fetchData() {               
            axios.get('/api/branches', 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => this.branches = res.data.data)
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

