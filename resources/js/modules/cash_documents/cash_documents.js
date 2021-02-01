import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import Breadcrumbs      from    '../../components/Breadcrumbs.vue';

import CashDocumentMain  from './Main.vue';
import CashDocumentShow  from './Show.vue';
import CashDocumentNew   from './New.vue';


const routes = [
    {path: '/',     name: 'CashDocumentMain',  component: CashDocumentMain},
    {path: '/:id',  name: 'CashDocumentShow',  component: CashDocumentShow, props: true},    
    {path: '/new',  name: 'CashDocumentNew',   component: CashDocumentNew},

];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);

import {CashDocument}   from '../../stores/CashDocument';
// import {Dictionary}     from '../../stores/Dictionary';

const store = new Vuex.Store({
    modules: {
        CashDocument,
        // Dictionary
    }    
});


Vue.filter('formatNumber', function(number, precision = 0) {
    let formatedNumber = number.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

new Vue({
    el: '#app2',    
    components: {
        CashDocumentMain,
        CashDocumentShow,
        CashDocumentNew,
        Breadcrumbs
    },
    router,
    store
});

