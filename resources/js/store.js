import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import bootstrap from './store/bootstrap';
import user from './store/user';

export default new Vuex.Store({
  modules: {
    bootstrap: bootstrap,
    user: user
  }
})