<template>
<div class="card v-cloak">
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
                    <th scope="col">Тип</th>
                    <th scope="col">Дата открытия</th>
                    <th scope="col">Дата закрытия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="department in departments" :key="department.id">                    
                    <td>
                        <router-link :to="{name: 'DepartmentsShow', params: {id: department.id}}">
                            <i class="far fa-eye"></i>
                        </router-link>
                    </td>
                    <td>{{department.branch}}</td>    
                    <td>{{department.name}}</td>                    
                    <td>{{department.description}}</td>
                    <td>{{department.type}}</td>
                    <td class="text-center">{{department.opened}}</td>
                    <td class="text-center">{{department.closed}}</td>
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

<style scoped>
    [v-cloak] {
        /* display: none; */
        display: block;
        padding: 50px 0;

        @keyframes spinner {
            to {
                    transform: rotate(360deg);
            }
        }

        &:before {
            content: '';
            box-sizing: border-box;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin-top: -10px;
            margin-left: -10px;
            border-radius: 50%;
            border: 2px solid #ccc;
            border-top-color: #333;
            animation: spinner .6s linear infinite;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
        }

        & > div {
            display: none;
        }
    }
</style>