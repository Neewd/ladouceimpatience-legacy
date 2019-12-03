import Vue from 'vue';
import router from './routes';
import VueTailwind from 'vue-tailwind'

Vue.use(VueTailwind)

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('vp-token') == null) {
            next({
                path: '/auth',
                params: { nextUrl: to.fullPath }
            })
        } else {
        	next()
        }
    } else if(to.matched.some(record => record.meta.guest)) {
        if(localStorage.getItem('vp-token') == null){
            next()
        }
        else{
            next({ name: 'account'})
        }
    }else {
        next() 
    }
})

import store from './store';

import axios from 'axios';
window.axios = axios;
const token = localStorage.getItem('vp-token')
if (token) {
  window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const app = new Vue({
    el: '#app',
    router,
    store
});
