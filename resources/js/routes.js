import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import HomeComponent from './components/HomeComponent';
import MainContentComponent from './components/MainContentComponent';

// Calendar 
import CalendarProductsComponent from './components/calendar/CalendarProductsComponent';

// Thematic 
import ThematicProductsComponent from './components/thematic/ThematicProductsComponent';

// Products
import ProductViewComponent from './components/products/ProductViewComponent';

// Auth
import AuthComponent from './components/auth/AuthComponent';
import ConnexionComponent from './components/auth/ConnexionComponent';
import VerifyEmailComponent from './components/auth/VerifyEmailComponent';
import ResetPasswordComponent from './components/auth/ResetPasswordComponent';

// Account
import AccountComponent from './components/account/AccountComponent';

// Others 
import NotFoundComponent from './components/NotFoundComponent';

const routes = [
	{
		path: '/',
		component: HomeComponent,
		children: [
			{
				path: '',
				component: MainContentComponent,
				name: 'home',
			},
			{
				path: 'auth',
				component: AuthComponent,
				meta: {
					guest: true,
				},
				children: [
					{
						path: '',
						name: 'connexion',
						component: ConnexionComponent,
					},
					{
						path: 'reset/password',
						name: 'reset-password',
						component: ResetPasswordComponent
					}
				]
			},
			{
				path: 'account',
				name: 'account',
				component: AccountComponent,
				meta: {
					requiresAuth: true,
				}
			},		
			{
				path: 'thematic/:thematicSlug([a-z-]+)',
				name: 'thematic-products',
				component: ThematicProductsComponent,
				meta: {
					requiresAuth: false,
				}
			},
			{
				path: ':thematicSlug([a-z-]+)/:productId(\\d+)',
				name: 'product-page',
				component: ProductViewComponent,
				meta: {
					requiresAuth: false,
				}
			},
			{
				path: 'calendrier',
				name: 'calendarProducts',
				component: CalendarProductsComponent
			},
			{ path: 'email/verify/:id', component: VerifyEmailComponent },
			{ path: 'user/reset/password', component: ResetPasswordComponent },
		]
	},
	{ path: '/404', component: NotFoundComponent, name: 'not-found' },
	{ path: '*', redirect: '/404' },
];

export default new VueRouter({
	mode: 'history',
	routes
});