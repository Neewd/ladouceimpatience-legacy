import VueSweetalert2 from 'vue-sweetalert2';

Nova.booting((Vue, router, store) => {
  Vue.use(VueSweetalert2);
  router.addRoutes([
    {
      path: '/newsletter',
      component: require('./components/NewsletterTools'),
      children: [
        {
          path: '',
          name: 'newsletter',
          component: require('./components/Newsletter'),
        },
        {
          path: 'campaign',
          name: 'campaign',
          component: require('./components/Campaign'),
        },
        {
          path: 'templates',
          name: 'templates',
          component: require('./components/Templates'),
        },
        {
          name: 'layouts',
          path: 'layouts',
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
