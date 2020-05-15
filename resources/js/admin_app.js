require('./bootstrap');
import Vue from 'vue';
require('./a156ec16d2');
import App from '../components/admin/App.vue'

var app = new Vue({
    el: '#app',
    render: h => h(App),
});
