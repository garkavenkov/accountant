import Vue          from 'vue'
import VueRouter    from 'vue-router'
import Vuex         from 'vuex'

Vue.use(VueRouter)

import MarkdownDocumentsMain  from './Main.vue';
import MarkdownDocumentsShow  from './Show.vue';

const routes = [
    {path: '/',     name: 'MarkdownDocumentsMain', component: MarkdownDocumentsMain},
    {path: '/:id',  name: 'MarkdownDocumentsShow', component: MarkdownDocumentsShow, props: true},    
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.use(Vuex);
import {MarkdownDocuments} from '../../stores/MarkdownDocument';

const store = new Vuex.Store(MarkdownDocuments);

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
        MarkdownDocumentsMain,
        MarkdownDocumentsShow,        
    },
    router,
    store
});

