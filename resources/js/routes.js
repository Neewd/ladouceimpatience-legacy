import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import HomeComponent from './components/HomeComponent';
import MainContentComponent from './components/MainContentComponent';

// Auth
import AuthComponent from './components/auth/AuthComponent';
import ConnexionComponent from './components/auth/ConnexionComponent';
import VerifyEmailComponent from './components/auth/VerifyEmailComponent';
import ResetPasswordComponent from './components/auth/ResetPasswordComponent';

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
					component: AuthComponent,
					meta: { 
		                guest: true
					},
					children :[
						{
							path : '', 
							name : 'connexion',
							component: ConnexionComponent
						},
						{
							path : 'reset/password', 
							name : 'reset-password',
							component: ResetPasswordComponent
						}		
					]
		        },
		     	{
		       		path: 'account',
		       		name: 'account',
		       		component: AccountComponent,
		       		meta: { 
		                requiresAuth: true
		            }
		       	},
				{ path : 'email/verify/:id', component: VerifyEmailComponent },
				{ path : 'user/reset/password', component: ResetPasswordComponent }
			]
		},
];

export default new VueRouter({
	mode: 'history',
	routes
});