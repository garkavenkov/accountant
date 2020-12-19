import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';




Vue.use(VueRouter);

import ShiftsMain  from './Main.vue';
import ShiftsShow  from './Show.vue';

const routes = [
    {path: '/',     name: 'ShiftsMain', component: ShiftsMain},
    {path: '/:id',  name: 'ShiftsShow', component: ShiftsShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);

import {Shift}   from '../../stores/Shift';

const store = new Vuex.Store(
    Shift
    // {
    //     modules: {
    //         SalesRevenue,
    //         Dictionary
    //     }    
    // }
);


new Vue({
    el: '#app2',    
    components: {
        ShiftsMain,
        ShiftsShow,        
    },
    router,
    store
});

