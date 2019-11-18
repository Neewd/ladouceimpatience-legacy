<template>
	<div class="my-6 text-lg font-secondary font-extrabold text-center">
		<span class="" v-if="emailVerification.loading"> La vérification de votre email est en cours, veuillez patientez.</span>
		<span class="text-green-700" v-if="!emailVerification.loading && emailVerification.finished && !emailVerification.error">{{ emailVerification.message }}</span>
		<span class="" v-if="! emailVerification.loading && emailVerification.finished && emailVerification.error">{{ emailVerification.message }}</span>
	</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
	data: function() {
		return {
			signature : '',
			expires : '',
			hash: '',
			userId: ''
		};
	},
	created() {
		this.signature = this.$route.query.signature
		this.userId = this.$route.params.id
		this.hash = this.$route.query.hash
		this.expires = this.$route.query.expires
		this.verifyUserMail({ hash : this.hash, userId : this.userId, signature : this.signature, expires: this.expires })
	},
	computed: {
		...mapGetters(['emailVerification'])
	},
	methods: {
		...mapActions(["verifyUserMail"]),
	}	
};

</script>