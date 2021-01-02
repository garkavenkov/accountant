import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'

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

Vue.use(Vuex);
import {Department} from '../../stores/Department';

const store = new Vuex.Store(Department);

new Vue({
    el: '#app2',    
    components: {
        DepartmentsMain,
        DepartmentsShow
    },
    router,
    store
});

