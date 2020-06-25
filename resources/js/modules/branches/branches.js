// const  Vue = require('vue');


import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import BranchesMain from './Main.vue';
import BranchesShow from './Show.vue';


const routes = [
    {path: '/', name: 'BranchesMain', component: BranchesMain},
    {path: '/:id', name: 'BranchesShow', component: BranchesShow, props: true} 
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

new Vue({
    el: '#app2',    
    components: {
        BranchesMain,
        BranchesShow
    },
    router
});

