import Vue from 'vue';
import Home from './pages/index';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

let router = new VueRouter({
    mode: "history",
    routes: [{
        path: '/',
        name: 'home',
        component: Home,
    },
]
})

export default router;

