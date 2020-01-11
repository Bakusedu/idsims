import Vue from 'vue';
import Home from './pages';
import Dashboard from './pages/dashboard';
import User from './pages/User';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

let router = new VueRouter({
    mode: "history",
    routes: [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard
    }
]
})

export default router;

