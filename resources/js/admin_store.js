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
        admins: [],
        books: [],
        authors: [],
        categories: [],
        tags: [],
        publishers: [],
        suppliers: [],
        comments: [],
        users: [],
        orders: [],
        authorview : [],
        pagination_length : 0,
        pagination_current: 0
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
        replaceOneRecord(state, { route, data, id }) {
            console.log(data);
            var index = state[route].findIndex(route => route.id == id)

            state[route][index].name = data.name;
            if (route == 'users') {
                state[route][index].email = data.email;
                state[route][index].ph_no = data.ph_no;
                state[route][index].address = data.address;
            }
            if (route == 'admins') {
                if (data.super_admin) {
                    state[route][index].super_admin = data.super_admin;
                }
                state[route][index].email = data.email;
                if (data.password) {
                    state[route][index].password = data.password;
                }
            }
            if (route === 'authors') {
                state[route][index].bio = data.bio;
                state[route][index].thumb = data.thumb;
            }
            if(route == 'suppliers'){
                state[route][index].phno = data.phno;
                state[route][index].address = data.address;
                state[route][index].email = data.email;
            }

        },
        addData(state, { route, data }) {
            if(route === 'authorview'){
                state[route] = data;
            }else{
                state[route] = data[route];
                state['pagination_length'] = data['total_pages'];
                state['pagination_current'] = data['current_page'];
            }

        }
    }
});
