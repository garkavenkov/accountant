import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'

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

Vue.use(Vuex);
import {Supplier} from '../../stores/Supplier.js';

const store = new Vuex.Store(Supplier);

new Vue({
    el: '#app2',    
    components: {
        SuppliersMain,
        SuppliersShow
    },
    router,
    store
});

