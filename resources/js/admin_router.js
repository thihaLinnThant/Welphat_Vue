import Vue from 'vue';
import VueRouter from 'vue-router';
import Axios from 'axios';
import Store from './admin_store';
Vue.use(VueRouter);

import Books from '../components/admin/Books.vue';
import Categories from '../components/admin/Categories.vue';
import Tags from '../components/admin/Tags.vue';
import Publishers from '../components/admin/publishers.vue';
import Comment from '../components/admin/Comments.vue'

let router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/admin/books', component: Books, name: 'books' },
        { path: '/admin/categories', component: Categories, name: 'categories' },
        { path: '/admin/tags', component: Tags, name: 'tags' },
        { path: '/admin/publishers', component: Publishers, name: 'publishers' },
        { path: '/admin/categories/addcategory', name: 'addcategory' },
        { path: '/admin/comments', component: Comment, name: 'comments' },
    ],
    // methods: {
    //     getApiData() {
    //         Axios.get(`/api${to.path}`).then(({ data }) => {
    //             Store.commit('addData', { route: to.name, data })
    //             next();
    //         });
    //     }
    // }
});

router.beforeEach((to, from, next) => {
    let serverData = JSON.parse(window.welphat_server_data);

    function getApiData() {
        Axios.get(`/api${to.path}`).then(({ data }) => {
            Store.commit('addData', { route: to.name, data })
            next();
        });
    }

    if (to.path === '/admin/books') { if (Store.state.books.length > 0) { next() } else { getApiData() } }

    else if (to.path === '/admin/categories') { if (Store.state.categories.length > 0) { next() } else { getApiData() } }

    else if (to.path === '/admin/tags') { if (Store.state.tags.length > 0) { next() } else { getApiData() } }

    else if (to.path === '/admin/publishers') { if (Store.state.publishers.length > 0) { next() } else { getApiData() } }

    else if (to.path === '/admin/comments') { if (Store.state.comments.length > 0) { next() } else { getApiData() } }

    else if (to.path === '/admin') { next(); }

    else if (to.path == '/dummy') { next(); }

    // else if(!serverData.path || to.path !== serverData.path) {
    //     Axios.get(`/api${to.path}`).then(({data}) => {
    //         Store.commit('addData', {route: to.name, data})
    //         next();
    //     });
    // }

});

export default router;
