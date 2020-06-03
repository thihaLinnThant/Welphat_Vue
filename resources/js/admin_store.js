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
        admins : [],
        books: [],
        authors: [],
        categories: [],
        tags: [],
        publishers: [],
        comments : [],
        users : []
    },
    getters: {
        getCategories(state) {
            return state.categories;
        }
    },
    mutations: {
        addOneRecord(state, { route, data }) {
            state[route].push(data);
        },
        addData(state, { route, data }) {
            state[route] = data[route];
            console.log(state)
        }
    }
});
