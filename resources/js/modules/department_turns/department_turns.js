import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import DepartmentTurnsMain from './Main.vue';
import DepartmentTurnsShow from './Show.vue';


const routes = [
    {path: '/',     name: 'DepartmentTurnsMain', component: DepartmentTurnsMain},
    {path: '/:id',  name: 'DepartmentTurnsShow', component: DepartmentTurnsShow, props: true} 
];

const router = new VueRouter({
    // mode: 'history',
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
        DepartmentTurnsMain,
        DepartmentTurnsShow
    },
    router
});

