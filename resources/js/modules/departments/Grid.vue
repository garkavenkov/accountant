<template>
<div class=card>    
    <div class="card-header">
        <div class="cart-title">
            Departments
        </div> 
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Подразделение</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Дата открытия</th>
                    <th scope="col">Дата закрытия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="department in departments" :key="department.id">                    
                    <td>{{department.id}}</td>
                    <td>{{department.branch}}</td>    
                    <td><router-link :to="{name: 'DepartmentsShow', params: {id: department.id}}">{{department.name}}</router-link></td>
                    <!-- <td>{{department.name}}</td> -->
                    <td>{{department.description}}</td>
                    <td>{{department.opened}}</td>
                    <td>{{department.closed}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
</template>

<script>
export default {
    name: 'DepartmentsGrid',
    props: ['departments'],
    data() {
        return {

        }
    }
}        
</script>