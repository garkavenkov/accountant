// const  Vue = require('vue');


import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import DepartmentsMain from './Main.vue';
import DepartmentsShow from './Show.vue';


const routes = [
    {path: '/', name: 'DepartmentsMain', component: DepartmentsMain},
    {path: '/:id', name: 'DepartmentsShow', component: DepartmentsShow, props: true} 
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

new Vue({
    el: '#app2',    
    components: {
        DepartmentsMain,
        DepartmentsShow
    },
    router
});

