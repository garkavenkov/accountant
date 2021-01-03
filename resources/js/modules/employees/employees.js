import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'

Vue.use(VueRouter)

import EmployeesMain from './Main.vue';
import EmployeesShow from './Show.vue';


const routes = [
    {path: '/',     name: 'EmployeesMain', component: EmployeesMain},
    {path: '/:id',  name: 'EmployeesShow', component: EmployeesShow, props: true} 
];

const router = new VueRouter({
    // mode: 'history',
    routes
});


Vue.use(Vuex);
import {Employee} from '../../stores/Employee';
const store = new Vuex.Store(Employee);

// Vue.filter('formatNumber', function(value, precision = 0) {
//     let formatedNumber = value.toLocaleString('ru-RU', { minimumFractionDigits: precision });
//     return formatedNumber;
// })

import moment from 'moment'

Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('DD.MM.YYYY')
  }
})

new Vue({
    el: '#app2',    
    components: {
        EmployeesMain,
        EmployeesShow
    },
    router,
    store
});

