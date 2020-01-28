import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import bootstrap from './store/bootstrap';
import user from './store/user';
import newsletter from './store/newsletter';
import products from './store/products';
import breadcrumb from './store/breadcrumb';
import brands from './store/brands';
import calendarProduct from './store/calendarProduct';

export default new Vuex.Store({
  modules: {
    bootstrap: bootstrap,
    user: user,
    newsletter: newsletter,
    products: products,
    breadcrumb : breadcrumb,
    brands : brands,
    calendarProduct : calendarProduct
  }
})