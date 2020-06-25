<template>
<div class=card>    
    <div class="card-header">
        <div class="cart-title">
            Suppliers
        </div> 
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Полное наименование</th>
                    <th scope="col">Описание</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="supplier in suppliers" :key="supplier.id">                    
                    <td>{{supplier.id}}</td>                    
                    <td><router-link :to="{name: 'SuppliersShow', params: {id: supplier.id}}">{{supplier.name}}</router-link></td>                    
                    <td>{{supplier.full_name}}</td>
                    <td>{{supplier.description}}</td>                    
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
</template>

<script>
export default {
    name: 'SuppliersGrid',
    props: ['suppliers'],
    data() {
        return {

        }
    }
}        
</script>