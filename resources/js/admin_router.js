import Vue from 'vue';
import VueRouter from 'vue-router';
import Axios from 'axios';
import Store from './admin_store';
Vue.use(VueRouter);

import Categories from '../components/admin/Categories.vue';
import Dummy from '../components/admin/dummy.vue';

let router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/admin/categories', component: Categories, name: 'categories'},
        { path: '/admin/dummy', component: Dummy, name: 'dummy'},
    ]
});

router.beforeEach((to, from, next)=> {
    let serverData = JSON.parse(window.welphat_server_data);
    if(serverData.path === '/admin/dummy') {
        next();
    }
    else if(serverData.path === '/admin/categories') {
        Axios.get(`/api${to.path}`).then(({data}) => {
            Store.commit('addData', {route: to.name, data})
            next();
        });
    }
});

export default router;
