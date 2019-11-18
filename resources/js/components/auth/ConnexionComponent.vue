<template>
	<div class="container mx-auto flex my-6 flex-col justify-center">
		<div id="connexion-inscription" class="flex justify-center flex-col">
			<p
				class="text-4xl uppercase mx-auto font-primary font-extrabold"
				id="bienvenue-text"
			>
				Bienvenue
			</p>
			<div class="w-40 h-px bg-red-200 mx-auto my-6 hidden"></div>
			<p class="text-center">
				Nous non plus on ne se souvient jamais lorsque l'on à déjà un
				compte ou non, renseignez votre email, et on vous dira si on
				vous connais ou pas.
			</p>
			<div class="w-3/12 mx-auto my-6">
				<div class="flex flex-wrap -mx-3 mb-6">
					<div class="w-full px-3">
						<div
							class="flex flex-row text-sm focus:outline-none bg-white border-gray-300 border rounded py-3 px-4"
							v-bind:class="{
								'border-red-500': errors.email.error,
								'mb-1': errors.email.error,
								'mb-3': !errors.email.error
							}"
						>
							<input
								class="appearance-none block w-full bg-transparent text-gray-700 outline-none leading-tight text-gray-600 "
								id="email"
								type="text"
								placeholder="votre-adresse@mail.com"
								v-model="email"
								@blur="verifIfUserExist()"
							/>
							<i
								class="la la-user text-xl text-gray-600 hover:cursor-pointer hover:text-gray-900"
								v-bind:class="{
									'text-red-500': errors.email.error
								}"
							></i>
						</div>
						<p
							class="text-xs text-red-500  mb-3"
							v-if="errors.email.error"
						>
							{{ this.errors.email.message }}
						</p>

						<div v-if="accountExist && firstVerificationDone">
							<div
								class="flex flex-row text-sm focus:outline-none bg-white border-gray-300 border rounded py-3 px-4 mb-3"
							>
								<input
									class="appearance-none block w-full bg-transparent text-gray-700 outline-none leading-tight text-gray-600 "
									id="password"
									v-bind:type="passwordTypeInput"
									placeholder="Mot de passe"
									v-model="userLogin.password"
								/>
								<span v-bind:class="{ hidden: !passwordVisible }" class="max-h-20">
									<i 	class="la la-eye text-xl text-gray-600 hover:cursor-pointer hover:text-gray-900"
										@click="togglePasswordVisible()"/>
								</span>
								<span v-bind:class="{ hidden: passwordVisible }" class="max-h-20">
									<i 	class="la la-eye-slash text-xl text-gray-600 hover:cursor-pointer hover:text-gray-900"
										@click="togglePasswordVisible()"/>
								</span>
								
							</div>
							<div
								class="flex w-full justify-end text-xs mb-3 hover:underline"
							>
								<a href="">Mot de passe oublié ?</a>
							</div>
							<button
								class="w-full bg-third text-white rounded-xl py-2 tracking-widest font-primary px-2 mb-2 font-bold uppercase focus:outline-none"
								@click="logInUser()"
							>
								Se connecter
							</button>
						</div>
						<div v-if="!accountExist && firstVerificationDone">
							<div
								class="flex flex-row text-sm focus:outline-none bg-white border-gray-300 border rounded py-3 px-4 mb-3"
							>
								<input
									class="appearance-none block w-full bg-transparent text-gray-700 outline-none leading-tight text-gray-600 "
									id="firstname"
									type="text"
									placeholder="Prénom"
									v-model="userCreation.firstname"
								/>
							</div>
							<div
								class="flex flex-row text-sm focus:outline-none bg-white border-gray-300 border rounded py-3 px-4 mb-3"
							>
								<input
									class="appearance-none block w-full bg-transparent text-gray-700 outline-none leading-tight text-gray-600 "
									id="lastname"
									type="text"
									placeholder="Nom de famille"
									v-model="userCreation.lastname"
								/>
							</div>
							<div
								class="flex flex-row text-sm focus:outline-none bg-white border-gray-300 border rounded py-3 px-4 "
								v-bind:class="{
									'border-red-500': errors.phone.error,
									'mb-3': !errors.phone.error,
									'mb-1': errors.phone.error
								}"
							>
								<input
									class="appearance-none block w-full bg-transparent text-gray-700 outline-none leading-tight text-gray-600"
									id="phone"
									type="text"
									placeholder="Numéro de téléphone"
									v-model="userCreation.phone"
									@blur="formatPhoneNumber()"
								/>
							</div>
							<p
								class="text-xs text-red-500 mb-2"
								v-if="errors.phone.error"
							>
								{{ this.errors.phone.message }}
							</p>
							<div class="flex flex-row mb-3">
								<label class="inline-flex items-center mr-3">
									<input
										type="radio"
										class="form-radio h-3 w-3 text-third"
										name="radio-colors"
										value="female"
										v-model="userCreation.gender"
									/>
									<span class="ml-2 text-sm">Femme</span>
								</label>
								<label class="inline-flex items-center">
									<input
										type="radio"
										class="form-radio h-3 w-3 text-third"
										name="radio-colors"
										value="male"
										v-model="userCreation.gender"
									/>
									<span class="ml-2 text-sm">Homme</span>
								</label>
							</div>

							<div
								id="divier"
								class="w-48 bg-secondary mx-auto h-px my-3"
							></div>

							<div
								class="flex flex-row text-sm focus:outline-none bg-white border-gray-300 border rounded py-3 px-4 mb-3"
							>
								<input
									class="appearance-none block w-full bg-transparent text-gray-700 outline-none leading-tight text-gray-600 "
									id="password"
									v-bind:type="passwordCreationTypeInput"
									placeholder="Mot de passe"
									v-model="userCreation.password"
								/>
								<i
									class="la la-eye text-xl text-gray-600 hover:cursor-pointer hover:text-gray-900"
									v-bind:class="{
										hidden: !passwordCreationVisible
									}"
									@click="togglePasswordCreationVisible()"
								></i>
								<i
									class="la la-eye-slash text-xl text-gray-600 hover:cursor-pointer hover:text-gray-900"
									v-bind:class="{
										hidden: passwordCreationVisible
									}"
									@click="togglePasswordCreationVisible()"
								></i>
							</div>

							<div
								class="flex flex-row text-sm focus:outline-none bg-white border-gray-300 border rounded py-3 px-4 mb-3"
							>
								<input
									class="appearance-none block w-full bg-transparent text-gray-700 outline-none leading-tight text-gray-600 "
									id="password"
									v-bind:type="
										passwordConfirmCreationTypeInput
									"
									placeholder="Confirmer votre mot de passe"
									v-model="userCreation.password_confirmation"
								/>
								<i
									class="la la-eye text-xl text-gray-600 hover:cursor-pointer hover:text-gray-900"
									v-bind:class="{
										hidden: !passwordConfirmCreationVisible
									}"
									@click="
										togglePasswordConfirmCreationVisible()
									"
								></i>
								<i
									class="la la-eye-slash text-xl text-gray-600 hover:cursor-pointer hover:text-gray-900"
									v-bind:class="{
										hidden: passwordConfirmCreationVisible
									}"
									@click="
										togglePasswordConfirmCreationVisible()
									"
								></i>
							</div>

							<button
								class="w-full bg-third text-white rounded-xl py-2 tracking-widest font-primary px-2 mb-2 font-bold uppercase"
								@click="register(userCreation)"
							>
								Créer mon compte
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { parsePhoneNumberFromString } from "libphonenumber-js";
import { mapActions } from "vuex";

export default {
	data: function() {
		return {
			email: "",
			userCreation: {
				email: "",
				password: "",
				password_confirmation: "",
				firstname: "",
				lastname: "",
				phone: "",
				gender: "female"
			},
			userLogin: {
				email: "",
				password: ""
			},
			errors: {
				email: {
					error: false,
					message: ""
				},
				phone: {
					error: false,
					message: ""
				}
			},

			accountExist: false,
			firstVerificationDone: false,
			password: "",
			passwordVisible: false,
			passwordCreationVisible: false,
			passwordConfirmCreationVisible: false,
			passwordTypeInput: "password",
			passwordConfirmCreationTypeInput: "password",
			passwordCreationTypeInput: "password"
		};
	},
	computed: {},
	methods: {
		...mapActions(["login", "checkUserExistence", "register"]),
		togglePasswordVisible() {
			this.passwordVisible = !this.passwordVisible;
			this.passwordTypeInput = this.passwordVisible ? "text" : "password";
		},
		togglePasswordCreationVisible() {
			this.passwordCreationVisible = !this.passwordCreationVisible;
			this.passwordCreationTypeInput = this.passwordCreationVisible
				? "text"
				: "password";
		},
		togglePasswordConfirmCreationVisible() {
			this.passwordConfirmCreationVisible = !this
				.passwordConfirmCreationVisible;
			this.passwordConfirmCreationTypeInput = this
				.passwordConfirmCreationVisible
				? "text"
				: "password";
		},
		async verifIfUserExist() {
			if (this.email !== "") {
				if (this.validateEmail(this.email)) {
					this.errors.email.error = false;

					const { data } = await this.checkUserExistence(this.email);
					if (data.id) {
						this.accountExist = true;
					} else {
						this.accountExist = false;
					}
					this.firstVerificationDone = true;
				} else {
					this.errors.email.error = true;
					this.errors.email.message =
						"L'adresse mail n'est pas valide";
				}
			}
		},
		validateEmail(email) {
			let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(email).toLowerCase());
		},
		formatPhoneNumber() {
			const phoneNumber = parsePhoneNumberFromString(
				this.userCreation.phone,
				"FR"
			);
			if (phoneNumber) {
				this.errors.phone.error = false;
				this.userCreation.phone = phoneNumber.number;
			} else {
				this.errors.phone = true;
				this.errors.phone.message =
					"Le numéro de téléphone n'est pas valide";
			}
		},
		logInUser() {
			this.login({ email: this.userLogin.email, password: this.userLogin.password })
				.then(response => {
					this.$router.push({ name : 'account' })
				})
				.catch(error => {
					console.error(error)
				})
		}
	},
	watch: {
		email: function(value) {
			this.userLogin.email = value;
			this.userCreation.email = value;
		}
	}
};
</script>
