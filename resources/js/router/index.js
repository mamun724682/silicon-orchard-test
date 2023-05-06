import {createRouter, createWebHistory} from 'vue-router'
import routes from './routes.js'
import store from '../store'
import {mapGetters} from "vuex";

const router = createRouter({
    history: createWebHistory(),
    routes
})
router.beforeEach((to, from, next) => {
    if (store.getters['authStore/user']) {
        if (to.matched.some(route => route.meta.guard === 'guest')) next({name: 'dashboard'})
        else next();

    } else {
        if (to.matched.some(route => route.meta.guard === 'auth')) next({name: 'login'})
        else next();
    }
})

export default router;

