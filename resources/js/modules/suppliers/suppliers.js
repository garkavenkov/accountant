import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import SuppliersMain from './Main.vue';
import SuppliersShow from './Show.vue';


const routes = [
    {path: '/', name: 'SuppliersMain', component: SuppliersMain},
    {path: '/:id', name: 'SuppliersShow', component: SuppliersShow, props: true} 
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

new Vue({
    el: '#app2',    
    components: {
        SuppliersMain,
        SuppliersShow
    },
    router
});

