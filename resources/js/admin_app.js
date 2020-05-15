import Vue from 'vue';
import vuetify from './plugins/vuetify';

require('./a156ec16d2');
import App from '../components/admin/App.vue'


new Vue({
    el: '#app',
    vuetify,
    components: { App },
    template: "<App/>"
});
