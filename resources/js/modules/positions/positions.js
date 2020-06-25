import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import PositionsMain from './Main.vue';
import PositionsShow from './Show.vue';


const routes = [
    {path: '/', name: 'PositionsMain', component: PositionsMain},
    {path: '/:id', name: 'PositionsShow', component: PositionsShow, props: true} 
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

new Vue({
    el: '#app2',    
    components: {
        PositionsMain,
        PositionsShow
    },
    router
});

