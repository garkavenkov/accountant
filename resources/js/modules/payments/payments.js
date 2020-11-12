import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import PaymentsMain  from './Main.vue';
import PaymentsShow  from './Show.vue';
// import IncomeDocumentsNew   from './New.vue';


const routes = [
    {path: '/',     name: 'PaymentsMain', component: PaymentsMain},
    {path: '/:id',  name: 'PaymentsShow', component: PaymentsShow, props: true},
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {Payment}    from '../../stores/Payment';
import {Dictionary} from '../../stores/Dictionary';

const store = new Vuex.Store({
    modules: {
        Payment,
        Dictionary
    }    
});


Vue.filter('formatNumber', function(number, precision = 0) {
    let formatedNumber = number.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

new Vue({
    el: '#app2',    
    components: {
        PaymentsMain,
        PaymentsShow,        
    },
    router,
    store
});

