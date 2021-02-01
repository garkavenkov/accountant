import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

// import Breadcrumbs      from    '../../components/Breadcrumbs.vue';

import CashProfitDocumentMain  from './Main.vue';
import CashProfitDocumentShow  from './Show.vue';


const routes = [
    {path: '/',     name: 'CashProfitDocumentMain',  component: CashProfitDocumentMain},
    {path: '/:id',  name: 'CashProfitDocumentShow',  component: CashProfitDocumentShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);

import {CashProfitDocument}   from '../../stores/CashProfitDocument';

const store = new Vuex.Store(CashProfitDocument);


Vue.filter('formatNumber', function(number, precision = 0) {
    let formatedNumber = number.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

new Vue({
    el: '#app2',    
    components: {
        CashProfitDocumentMain,
        CashProfitDocumentShow,
    },
    router,
    store
});

