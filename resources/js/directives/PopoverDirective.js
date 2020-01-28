import Vue from 'vue';
import store from "../store";

import PopoverCalendar from '../components/utils/PopoverCalendarComponent'

Vue.directive('popover', {
  bind: (el, binding, vnode) => {
    el.index = binding.value.index;
    if (binding.value.product) {
      el.router = vnode.context.$router
      el.product = binding.value.product
      el.day = binding.value.day
    }
  },
  inserted: (el) => {

    if (el.product) {
      const offsetTop = el.offsetTop;
      const offsetLeft = el.offsetLeft;
      const objetParent = el.offsetParent
      const elementWidth = el.offsetWidth
      const elementHeight = el.offsetHeight

      el.addEventListener('click', () => {
        console.log(el)
        let ComponentClass = Vue.extend(PopoverCalendar)
        let instance = new ComponentClass({
          data() {
            return {
              offsetTop: offsetTop,
              offsetLeft: offsetLeft,
              parent: objetParent,
              elementWidth: elementWidth,
              elementHeight: elementHeight,
              index: el.index,
              product: el.product,
              router: el.router,
              day: el.day
            };
          },
          store
        })
        instance.$mount();

        objetParent.append(instance.$el)
      })
    }
  }
})