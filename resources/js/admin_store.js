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
        books: [],
        categories: [],
        tags: [],
        publishers: []
    },
    getters: {
        getCategories(state) {            
            return state.categories;
        }
    },
    mutations: {
        addData(state, { route, data }) {
            if(route === 'books') {
                state.books = data.books;
            }
            else if (route === 'categories') {
                state.categories = data.categories;
            }
            else if (route === 'tags') {
                state.tags = data.tags;
            }
            else if (route === 'publishers') {
                state.publishers = data.publishers;
            }
        }
    }
});