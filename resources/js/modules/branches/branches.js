import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import BranchesMain from './Main.vue';
import BranchesShow from './Show.vue';


const routes = [
    {path: '/',    name: 'BranchesMain', component: BranchesMain},
    {path: '/:id', name: 'BranchesShow', component: BranchesShow, props: true} 
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {Branch} from '../../stores/Branch';

const store = new Vuex.Store(Branch);


new Vue({
    el: '#app2',    
    components: {
        BranchesMain,
        BranchesShow
    },
    router,
    store
});

