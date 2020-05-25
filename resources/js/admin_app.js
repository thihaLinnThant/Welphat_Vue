import Vue from 'vue';
import vuetify from './plugins/vuetify';
import router from './admin_router';
import store from './admin_store'
require('./a156ec16d2');
import App from '../components/admin/App.vue'
require('./bootstrap');


new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components: { App },
    template: "<App/>"
});
