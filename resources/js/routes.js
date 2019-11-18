import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import HomeComponent from './components/HomeComponent';
import MainContentComponent from './components/MainContentComponent';

// Auth
import ConnexionComponent from './components/auth/ConnexionComponent';
import VerifyEmailComponent from './components/auth/VerifyEmailComponent';

// Account
import AccountComponent from './components/account/AccountComponent';

const routes =  [
		{ 
			path : '/' , 
			component: HomeComponent,
			children: [
				{ path : '', component: MainContentComponent, name: 'home' },
				{ 
					path : 'auth', 
					name : 'auth',
					component: ConnexionComponent,
					meta: { 
		                guest: true
		            } 
		        },
		     	{
		       		path: 'account',
		       		name: 'account',
		       		component: AccountComponent,
		       		meta: { 
		                requiresAuth: true
		            }
		       	},
				{ path : 'email/verify/:id', component: VerifyEmailComponent }
			]
		},
];

export default new VueRouter({
	mode: 'history',
	routes
});