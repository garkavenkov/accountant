import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import CloseCashMain from './Main.vue';

const routes = [
    {path: '/',     name: 'CloseCashMain', component: CloseCashMain},
];

const router = new VueRouter({
    routes
});

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
        CloseCashMain,        
    },
    router
});

