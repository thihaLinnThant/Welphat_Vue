import Vue from 'vue';
import vuetify from './plugins/vuetify';
import router from './admin_router';
import store from './admin_store'
require('./a156ec16d2');
import App from '../components/admin/App.vue'
import Echo from 'laravel-echo';

window.axios = require('axios');

window.axios.defaults.headers.common= {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token,
    'Authorization' : 'Bearer ' + window.current_admin.api_token
};

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
});

new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components: { App },
    template: "<App/>"
});
