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
        bookview : []
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
            var index = state[route].findIndex(route => route.id == id);
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
            if (route == 'orders'){
                state[route][index].user_name = data.user_name;
                state[route][index].address = data.address;
                state[route][index].phone_no = data.phone_no;
                var book_count = 0;
                var total_book_price = 0;
                for(var i=0;i< state[route][index].book_orders.length;i++){
                    state[route][index].book_orders[i].qty = data.book_orders[i].qty;
                    book_count += data.book_orders[i].qty;
                    total_book_price += (data.book_orders[i].qty * data.book_orders[i].book_price);
                }
                state[route][index].count = book_count;
                state[route][index].total_price = total_book_price;
            }
        },
        addData(state, { route, data }) {
            if(route === 'authorview' || route === 'bookview'){
                state[route] = data;
            }else{
                state[route] = data[route];

            }
        }
    }
});
