import Vue from 'vue';
import router from './routes';
import VueTailwind from 'vue-tailwind'
import ZoomOnHover from "vue-zoom-on-hover";
import Vuetify, {
    VSnackbar
  } from 'vuetify/lib'
import vClickOutside from 'v-click-outside'
 

  // 3rd Party Libs
Vue.use(VueTailwind)
Vue.use(ZoomOnHover);
Vue.use(Vuetify, {
    components: {
      VSnackbar
    },
})
Vue.use(vClickOutside)

// Customized components
Vue.component('breadcrumb', require('./components/BreadcrumbComponent').default)
Vue.component('brands-slider', require('./components/utils/BrandsSliderComponent').default)
Vue.component('modal', require('./components/utils/ModalComponent').default)

require('./directives/PopoverDirective')

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

Array.range = function(n) {
    // Array.range(5) --> [0,1,2,3,4]
    return Array.apply(null,Array(n)).map((x,i) => i)
  };

Object.defineProperty(Array.prototype, 'chunk', {
    value: function(n) {
      // ACTUAL CODE FOR CHUNKING ARRAY:
      return Array.range(Math.ceil(this.length/n)).map((x,i) => this.slice(i*n,i*n+n));
  
    }
  });

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
