import Vue from 'vue';
import vuetify from '../plugins/vuetify';
import Login from '../../components/LoginForm.vue';
// import PassportClients from '../../components/passport/Clients.vue';
// import PassportAuthorizedClients from '../../components/passport/AuthorizedClients.vue';
// import passportPersonalAccessTokens from '../../components/passport/PersonalAccessTokens.vue'


require('../bootstrap');
window.axios = require('axios');

window.axios.defaults.headers.common= {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token,
};

new Vue({
    el: '#app',
    vuetify,
    components: { 
        Login,
        // 'passport-clients': PassportClients,
        // 'passport-authorized-clients' : PassportAuthorizedClients,
        // 'passport-personal-access-tokens' : passportPersonalAccessTokens
    },
    template: `<Login/>`
});
