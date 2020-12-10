import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import WritedownDocumentsMain  from './Main.vue';
import WritedownDocumentsShow  from './Show.vue';

const routes = [
    {path: '/',     name: 'WritedownDocumentsMain', component: WritedownDocumentsMain},
    {path: '/:id',  name: 'WritedownDocumentsShow', component: WritedownDocumentsShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {WritedownDocuments} from '../../stores/WritedownDocument';

const store = new Vuex.Store(WritedownDocuments);

Vue.filter('formatNumber', function(value, precision = 0) {
    let formatedNumber = value.toLocaleString('ru-RU', { minimumFractionDigits: precision });
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
        WritedownDocumentsMain,
        WritedownDocumentsShow,        
    },
    router,
    store
});

