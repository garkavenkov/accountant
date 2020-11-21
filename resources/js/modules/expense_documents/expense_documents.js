import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import ExpenseDocumentsMain  from './Main.vue';
import ExpenseDocumentsShow  from './Show.vue';

const routes = [
    {path: '/',     name: 'ExpenseDocumentsMain', component: ExpenseDocumentsMain},
    {path: '/:id',  name: 'ExpenseDocumentsShow', component: ExpenseDocumentsShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {ExpenseDocuments} from '../../stores/ExpenseDocument';

const store = new Vuex.Store(ExpenseDocuments);

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
        ExpenseDocumentsMain,
        ExpenseDocumentsShow,        
    },
    router,
    store
});

