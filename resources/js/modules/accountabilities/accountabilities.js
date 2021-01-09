import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import AccountabilitiesMain  from './Main.vue';
import AccountabilitiesShow  from './Show.vue';



const routes = [
    {path: '/',     name: 'AccountabilitiesMain', component: AccountabilitiesMain},
    {path: '/:id',  name: 'AccountabilitiesShow', component: AccountabilitiesShow, props: true},
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {Accountability}    from '../../stores/Accountability';


const store = new Vuex.Store(Accountability);


Vue.filter('formatNumber', function(number, precision = 0) {
    let formatedNumber = number.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

new Vue({
    el: '#app2',    
    components: {
        AccountabilitiesMain,
        AccountabilitiesShow,        
    },
    router,
    store
});

