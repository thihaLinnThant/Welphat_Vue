import Vue from 'vue';
import Vuex from 'vuex';
// import router from './admin_router';
Vue.use(Vuex);

import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

export default new Vuex.Store({
    state: {
        categories: []
    },
    mutations: {
        addData(state, { route, data }) {
            if (route === 'categories') {
                state.categories = data.categories;
            }
        }
    }
});