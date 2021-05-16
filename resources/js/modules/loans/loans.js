import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import LoansMain  from './Main.vue';
import LoansShow  from './Show.vue';

const routes = [
    {path: '/',     name: 'LoansMain', component: LoansMain},
    {path: '/:id',  name: 'LoansShow', component: LoansShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {Loan} from '../../stores/Loan';

const store = new Vuex.Store(Loan);

Vue.filter('formatNumber', function(value, precision = 0) {
    let formatedNumber = value.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

import moment from 'moment'

Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('DD.MM.YYYY')
  }
})
 

new Vue({
    el: '#app2',    
    components: {
        LoansMain,
        LoansShow,        
    },
    router,
    store
});

