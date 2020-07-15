import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import ShiftsMain  from './Main.vue';
import ShiftsShow  from './Show.vue';



const routes = [
    {path: '/', name: 'ShiftsMain', component: ShiftsMain},
    {path: '/:id', name: 'ShiftsShow', component: ShiftsShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

new Vue({
    el: '#app2',    
    components: {
        ShiftsMain,
        ShiftsShow,        
    },
    router
});

