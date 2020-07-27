import Vue from 'vue';
import VueRouter from 'vue-router';
import Store from './admin_store';
Vue.use(VueRouter);

import Books from '../components/admin/Books.vue';
import BookRegister from '../components/admin/BookRegister.vue';
import Authors from '../components/admin/Authors.vue';
import Categories from '../components/admin/Categories.vue';
import Tags from '../components/admin/Tags.vue';
import Suppliers from '../components/admin/Suppliers.vue';
import Publishers from '../components/admin/publishers.vue';
import Comment from '../components/admin/Comments.vue';
import Order from '../components/admin/Orders.vue';
import Admin from '../components/admin/Admins';
import User from '../components/admin/Users';
import AuthorView from '../components/admin/adminSingleView/AuthorView';
import BookView from '../components/admin/adminSingleView/BookView';
import TagView from '../components/admin/adminSingleView/TagView';
import CategoryView from '../components/admin/adminSingleView/CategoryView';
import PublisherView from '../components/admin/adminSingleView/PublisherView';
import SupplierView from '../components/admin/adminSingleView/SupplierView';
import UserView from '../components/admin/adminSingleView/UserView';
import Overview from '../components/admin/Overview';
import NotFound from '../components/admin/NotFound';
import AdminNotification from  '../components/admin/AdminNotifications';

let router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/admin/books', component: Books, name: 'books' },
        { path: '/admin/books/register', component: BookRegister, name: 'book_register' },
        { path: '/admin/authors', component: Authors, name: 'authors' },
        { path: '/admin/categories', component: Categories, name: 'categories' },
        { path: '/admin/tags', component: Tags, name: 'tags' },
        { path: '/admin/publishers', component: Publishers, name: 'publishers' },
        { path: '/admin/suppliers', component: Suppliers, name: 'suppliers' },
        { path: '/admin/comments', component: Comment, name: 'comments' },
        { path: '/admin/orders', component: Order, name: 'orders' },
        { path: '/admin/admins', component: Admin, name: 'admins' },
        { path: '/admin/users', component: User, name: 'users' },
        { path: '/admin/authors/:id', component: AuthorView, name: 'authorview' },
        { path: '/admin/books/:id', component: BookView, name: 'bookview' },
        { path: '/admin/tags/:id', component: TagView, name: 'tagview' },
        { path: '/admin/categories/:id', component: CategoryView, name: 'categoryview' },
        { path: '/admin/publishers/:id', component: PublisherView, name: 'publisherview' },
        { path: '/admin/suppliers/:id', component: SupplierView, name: 'supplierview' },
        { path: '/admin/users/:id', component: UserView, name: 'userview' },
        { path: '/admin/overview', component: Overview, name: 'overview'},
        { path: '/admin/404', component: NotFound, name: 'notfound'},
        { path: '/admin/notifications', component: AdminNotification, name: 'notifications'}
    ]
});

router.beforeEach((to, from, next) => {
    let serverData = JSON.parse(window.welphat_server_data);

    function getApiData(path, name) {
        axios.get(`/api${path}`).then(({ data }) => {

            Store.commit('addData', { route: name, data })
            next();
        }).catch((error)=>{
            error.response.status == '404' ? router.push({ name: 'notfound' }) : ''
        })
        
    }

    if (to.path === '/admin/books') { getApiData(to.path, to.name) }

    if (to.path === '/admin/authors') { if (Store.state.authors.length > 0) { next() } else { getApiData(to.path, to.name) } }

    else if (to.path === '/admin/categories') { if (Store.state.categories.length > 0) { next() } else { getApiData(to.path, to.name) } }

    else if (to.path === '/admin/tags') { if (Store.state.tags.length > 0) { next() } else { getApiData(to.path, to.name) } }

    else if (to.path === '/admin/publishers') { if (Store.state.publishers.length > 0) { next() } else { getApiData(to.path, to.name) } }

    else if (to.path === '/admin/suppliers') { if (Store.state.suppliers.length > 0) { next() } else { getApiData(to.path, to.name) } }

    else if (to.path === '/admin/comments') { if (Store.state.comments.length > 0) { next() } else { getApiData(to.path, to.name) } }

    else if (to.path === '/admin/orders') { if (Store.state.orders.length > 0) { next() } else { getApiData(to.path, to.name) } }

    else if (to.path === '/admin/admins') { if (Store.state.admins.length > 0) { next() } else { getApiData(to.path, to.name) } }

    else if (to.path === '/admin/notifications') { if (Store.state.notifications.length > 10) { next() } else { getApiData(to.path, to.name) } }

    else if (to.path === '/admin/users') {
        if (Store.state.users.length > 0) { next() } else {
            getApiData(to.path, to.name)
        }
    }
    else if ( to.path === '/admin/overview'){
        if(Store.state.overview.length > 0) { next() } else {
            getApiData(to.path, to.name);
        }
    }
    else if (to.path === `/admin/authors/${to.params.id}`) {
        if (Store.state.authorview.length > 0) { next() } else { getApiData(to.path, to.name) }
    }
    else if (to.path === `/admin/books/${to.params.id}`) {
        if (Store.state.bookview.length > 0) { next() } else { getApiData(to.path, to.name) }
    }
    else if (to.path === `/admin/tags/${to.params.id}`) {
        if (Store.state.tagview.length > 0) { next() } else { getApiData(to.path, to.name) }
    }
    else if (to.path === `/admin/categories/${to.params.id}`) {
        if (Store.state.categoryview.length > 0) { next() } else { getApiData(to.path, to.name) }
    }
    else if (to.path === `/admin/publishers/${to.params.id}`) {
        if (Store.state.publisherview.length > 0) { next() } else { getApiData(to.path, to.name) }
    }
    else if (to.path === `/admin/suppliers/${to.params.id}`) {
        if (Store.state.supplierview.length > 0) { next() } else { getApiData(to.path, to.name) }
    }
    else if (to.path === `/admin/users/${to.params.id}`) {
        if (Store.state.userview.length > 0) { next() } else { getApiData(to.path, to.name) }
    }

    else if (to.path === '/admin' ) { next(); }


    else if (to.path === '/admin/books') {
        if (Store.state.categories.length <= 0) {
            getApiData('/admin/categories', 'categories');
        }
        if (Store.state.tags.length <= 0) {
            getApiData('/admin/tags', 'tags');
        }
        if (Store.state.publishers.length <= 0) {
            getApiData('/admin/publishers', 'publishers');
        }

        if (Store.state.suppliers.length <= 0) {
            getApiData('/admin/suppliers', 'suppliers');
        }

        if (Store.state.authors.length <= 0) {
            getApiData('/admin/authors', 'authors');
        }
        if (Store.state.comments.length <= 0) {
            getApiData('/admin/comments', 'comments')
        }

        next();
    }
    else {
        next();
    }

    // else if(!serverData.path || to.path !== serverData.path) {
    //     Axios.get(`/api${to.path}`).then(({data}) => {
    //         Store.commit('addData', {route: to.name, data})
    //         next();
    //     });
    // }

});

export default router;
