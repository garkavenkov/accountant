// const  Vue = require('vue');


import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import EmployeesMain from './Main.vue';
import EmployeesShow from './Show.vue';


const routes = [
    {path: '/', name: 'EmployeesMain', component: EmployeesMain},
    {path: '/:id', name: 'EmployeesShow', component: EmployeesShow, props: true} 
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

new Vue({
    el: '#app2',    
    components: {
        EmployeesMain,
        EmployeesShow
    },
    router
});

