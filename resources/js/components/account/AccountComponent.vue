<template>
	<div class="container mx-64">
		<div id="sidebar" class="w-2/6 h-full">
			<h1 class="text-2xl font-primary">Mon compte</h1>
			<h3 class="text-sm mb-12 font-secondary font-grey-300" v-if="user">Bienvenue {{user.firstname}} </h3>

			<ul class="">
				<li>Mes commandes</li>
				<li>Mes adresses</li>
				<li @click="logoutUser()"
					class="hover:cursor-pointer mt-4">
					<i class="la la-sign-out-alt"></i>
					Déconnexion
				</li>
			</ul>
		</div>
		<div id="main" class="w-2/6">
			
		</div>
	</div>
</template>

<script>
	
	import { mapGetters, mapActions } from 'vuex';
	export default {
		data () {
			return {

			}
		},
		computed: {
			...mapGetters(['user'])
		},
		methods : {
			...mapActions(['logout']),
			logoutUser() {
				this.logout()
				.then(response => {
					this.$router.push({ name : 'home' })
				})
				.catch(error => {
					console.error(error)
				})
			}
		}
 	}

</script>