import VueSweetalert2 from 'vue-sweetalert2';
const moment = require('moment')
require('moment/locale/fr')

Nova.booting((Vue, router, store) => {
  Vue.use(VueSweetalert2);
  Vue.use(require('vue-moment'), { moment });
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
          path: 'recipient',
          name: 'recipient',
          component: require('./components/Recipient'),
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
