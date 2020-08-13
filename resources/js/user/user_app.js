import Vue from 'vue';
import vuetify from '../plugins/vuetify';
import Login from '../../components/LoginForm.vue';

window.axios = require('axios');

window.axios.defaults.headers.common= {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token,
};

new Vue({
    el: '#app',
    vuetify,
    components: { Login },
    template: "<Login/>"
});
