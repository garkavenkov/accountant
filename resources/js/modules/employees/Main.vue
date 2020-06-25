<template>

<div>
   <grid :employees="employees"></grid>
</div>

</template>

<script>
import Grid from './Grid';

export default {
    name: 'EmployeesMain',
    data() {
        return {
            employees: []
        }
    },
    methods: {
        fetchData() {               
            axios.get('/api/employees', 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => this.employees = res.data.data)
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

