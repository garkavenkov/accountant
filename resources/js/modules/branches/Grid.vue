<template>
<div class=card>    
    <div class="card-header">
        <div class="cart-title">
            Branches
        </div> 
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Адресс</th>
                    <th scope="col">Открыт</th>
                    <th scope="col">Закрыт</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="branch in branches" :key="branch.id">
                    <td>{{branch.id}}</td>
                    <td><router-link :to="{name: 'BranchesShow', params: {id: branch.id}}">{{branch.name}}</router-link></td>
                    <!-- <td>{{branch.name}}</td> -->
                    <td>{{branch.address}}</td>
                    <td>{{branch.opened}}</td>
                    <td>{{branch.closed}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
</template>

<script>
export default {
    name: 'BranchesGrid',
    props: ['branches'],
    data() {
        return {

        }
    }
    // methods: {
    //     fetchData() {               
    //         axios.get('/api/branches', 
    //                 {
    //                     'headers': {
    //                         'Authorization': 'Bearer ' + window.api_token,
    //                         'Accept': 'application/json',
    //                     } 
    //                 }
    //             )
    //             .then(res => this.branches = res.data)
    //             .catch(err => console.log(err));
                
    //     }
    // },
    // created() {
    //     this.fetchData();
    // },
}
</script>