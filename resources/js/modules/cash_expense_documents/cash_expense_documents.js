import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

// import Breadcrumbs      from    '../../components/Breadcrumbs.vue';

import CashExpenseDocumentMain  from './Main.vue';
import CashExpenseDocumentShow  from './Show.vue';


const routes = [
    {path: '/',     name: 'CashExpenseDocumentMain',  component: CashExpenseDocumentMain},
    {path: '/:id',  name: 'CashExpenseDocumentShow',  component: CashExpenseDocumentShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);

import {CashExpenseDocument}   from '../../stores/CashExpenseDocument';

const store = new Vuex.Store(CashExpenseDocument);


Vue.filter('formatNumber', function(number, precision = 0) {
    let formatedNumber = number.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

new Vue({
    el: '#app2',    
    components: {
        CashExpenseDocumentMain,
        CashExpenseDocumentShow,
    },
    router,
    store
});

