import Vue          from 'vue'
import VueRouter    from 'vue-router'
// import Vuex         from 'vuex'

Vue.use(VueRouter)

import ReportsMain  from './Main.vue';
// import ReturnDocumentsShow  from './Show.vue';


const routes = [
    {path: '/',     name: 'ReportsMain', component: ReportsMain},
    // {path: '/:id',  name: 'ReturnDocumentsShow', component: ReturnDocumentsShow, props: true},
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

// Vue.use(Vuex);
// import {ReturnDocument} from '../../stores/ReturnDocument';

// const store = new Vuex.Store(ReturnDocument);


Vue.filter('formatNumber', function(number, precision = 0) {
    let formatedNumber = number.toLocaleString('ru-RU', { minimumFractionDigits: precision });
    return formatedNumber;
})

new Vue({
    el: '#app2',    
    components: {
        ReportsMain,
        // ReturnDocumentsShow,
    },
    router,
    // store
});

