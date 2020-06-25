<template>
<div class=card>    
    <div class="card-header">
        <div class="cart-title">
            Employees
        </div> 
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Фамилия</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Отчество</th>
                    <th scope="col">Подразделение</th>
                    <th scope="col">Отдел</th>
                    <th scope="col">Должность</th>                    
                    <th scope="col">Работает с</th>
                    <th scope="col">Уволен</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="employee in employees" :key="employee.id">
                    <td><router-link :to="{name: 'EmployeesShow', params: {id: employee.id}}">{{employee.id}}</router-link></td>                          
                    <td>{{employee.surname}}</td> 
                    <td>{{employee.name}}</td>
                    <td>{{employee.patronymic}}</td>
                    <td>{{employee.branch}}</td>
                    <td>{{employee.department}}</td>
                    <td>{{employee.position}}</td>
                    <td>{{employee.hired}}</td>
                    <td>{{employee.fired}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
</template>

<script>
export default {
    name: 'EmployeesGrid',
    props: ['employees'],
    data() {
        return {

        }
    }
}        
</script>
