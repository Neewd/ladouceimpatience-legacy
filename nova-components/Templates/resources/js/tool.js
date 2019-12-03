import VueSweetalert2 from 'vue-sweetalert2';

Nova.booting((Vue, router, store) => {
  Vue.use(VueSweetalert2);
  router.addRoutes([
    {
      path: '/templates',
      component: require('./components/TemplatesTools'),
      children: [
        {
          path: '',
          name: 'templates',
          component: require('./components/Templates'),
        },
        {
          name: 'layout',
          path: 'layout',
          props: true,
          component: require('./components/Layouts'),
          children: [
            {
              path: ':name',
              name: 'layout-detail',
              component: require('./components/Layouts'),
            },
          ]
        }
      ]
    },
  ])
})
