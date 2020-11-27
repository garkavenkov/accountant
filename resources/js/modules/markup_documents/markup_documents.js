import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import MarkupDocumentsMain  from './Main.vue';
import MarkupDocumentsShow  from './Show.vue';

const routes = [
    {path: '/',     name: 'MarkupDocumentsMain', component: MarkupDocumentsMain},
    {path: '/:id',  name: 'MarkupDocumentsShow', component: MarkupDocumentsShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {MarkupDocuments} from '../../stores/MarkupDocument';

const store = new Vuex.Store(MarkupDocuments);

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
        MarkupDocumentsMain,
        MarkupDocumentsShow,        
    },
    router,
    store
});

