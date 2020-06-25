<template>
<div class=card>    
    <div class="card-header">
        <div class="cart-title">
            Positions
        </div> 
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Наименование</th>                    
                    <th scope="col">Описание</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="position in positions" :key="position.id">                    
                    <td>{{position.id}}</td>                    
                    <td><router-link :to="{name: 'PositionsShow', params: {id: position.id}}">{{position.name}}</router-link></td>                    
                    <td>{{position.description}}</td>                    
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
</template>

<script>
export default {
    name: 'PositionsGrid',
    props: ['positions'],
    data() {
        return {

        }
    }
}        
</script>