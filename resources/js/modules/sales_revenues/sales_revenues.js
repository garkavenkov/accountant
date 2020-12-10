import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import SalesRevenueMain  from './Main.vue';
import SalesRevenueShow  from './Show.vue';
// import IncomeDocumentsNew   from './New.vue';


const routes = [
    {path: '/',     name: 'SalesRevenueMain',  component: SalesRevenueMain},
    {path: '/:id',  name: 'SalesRevenueShow',  component: SalesRevenueShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);

import {SalesRevenue}   from '../../stores/SalesRevenue';
// import {Dictionary}     from '../../stores/Dictionary';

const store = new Vuex.Store(
    SalesRevenue
    // {
    //     modules: {
    //         SalesRevenue,
    //         Dictionary
    //     }    
    // }
);


Vue.filter('formatNumber', function(number, precision = 0) {
    let formatedNumber = number.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

new Vue({
    el: '#app2',    
    components: {
        SalesRevenueMain,
        SalesRevenueShow
    },
    router,
    store
});

