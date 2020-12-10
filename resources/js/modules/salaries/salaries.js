import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import SalariesMain  from './Main.vue';
import SalariesShow  from './Show.vue';
// import IncomeDocumentsNew   from './New.vue';


const routes = [
    {path: '/',     name: 'SalariesMain',  component: SalariesMain},
    {path: '/:id',  name: 'SalariesShow',  component: SalariesShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);

import {Salary}   from '../../stores/Salary';
// import {Dictionary}     from '../../stores/Dictionary';

const store = new Vuex.Store(Salary);

Vue.filter('formatNumber', function(number, precision = 0) {
    let formatedNumber = number.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

Vue.filter('formatDate', function(value) {
    if (value) {
      return moment(String(value)).format('DD.MM.YYYY')
    }
  })
   

new Vue({
    el: '#app2',    
    components: {
        SalariesMain,
        SalariesShow
    },
    router,
    store
});

