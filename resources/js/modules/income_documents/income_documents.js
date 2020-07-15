import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import IncomeDocumentsMain  from './Main.vue';
import IncomeDocumentsShow  from './Show.vue';
import IncomeDocumentsNew   from './New.vue';


const routes = [
    {path: '/', name: 'IncomeDocumentsMain', component: IncomeDocumentsMain},
    {path: '/:id', name: 'IncomeDocumentsShow', component: IncomeDocumentsShow, props: true},
    {path: '/new', name: 'IncomeDocumentsNew', component: IncomeDocumentsNew, props: true} 
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {IncomeDocuments} from '../../stores/IncomeDocument';

const store = new Vuex.Store(IncomeDocuments);


Vue.filter('formatNumber', function(number, precision = 0) {
    let formatedNumber = number.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

new Vue({
    el: '#app2',    
    components: {
        IncomeDocumentsMain,
        IncomeDocumentsShow,
        IncomeDocumentsNew
    },
    router,
    store
});

