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
        users : [],
        orders: []
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
        deleteOneRecord(state, { route, id }) {
            var index = state[route].findIndex(route => route.id == id)
            state[route].splice(index, 1)
        },
        replaceOneRecord(state, { route, data, id}) {
            var index = state[route].findIndex(route => route.id == id)
            state[route][index] = data;            
        },
        addData(state, { route, data }) {
            state[route] = data[route];            
        }
    }
});
