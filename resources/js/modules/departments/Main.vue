<template>

<div>
   <grid :departments="departments"></grid>
</div>

</template>

<script>
import Grid from './Grid';

export default {
    name: 'DepartmentsMain',
    data() {
        return {
            departments: []
        }
    },
    methods: {
        fetchData() {               
            axios.get('/api/departments', 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => this.departments = res.data.data)
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

