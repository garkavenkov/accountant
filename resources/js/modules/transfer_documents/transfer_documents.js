import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import TransferDocumentsMain  from './Main.vue';
import TransferDocumentsShow  from './Show.vue';

const routes = [
    {path: '/',     name: 'TransferDocumentsMain', component: TransferDocumentsMain},
    {path: '/:id',  name: 'TransferDocumentsShow', component: TransferDocumentsShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {TransferDocuments} from '../../stores/TransferDocument';

const store = new Vuex.Store(TransferDocuments);

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
        TransferDocumentsMain,
        TransferDocumentsShow,        
    },
    router,
    store
});

