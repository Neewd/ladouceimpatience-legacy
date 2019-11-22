<template>
    <div class="my-6 text-lg font-secondary font-extrabold text-center">
        <div v-if="!token">
            <input
                class="appearance-none block w-full bg-transparent text-gray-700 outline-none leading-tight text-gray-600"
                id="email"
                type="text"
                placeholder="votre-adresse@mail.com"
                v-model="email"
            />
            <i class="la la-mail text-xl text-gray-600 hover:cursor-pointer hover:text-gray-900" />
            <button
                class="w-full bg-third text-white rounded-xl py-2 tracking-widest font-primary px-2 mb-2 font-bold uppercase focus:outline-none"
                @click="sendResetPasswordLink({ email : email})"
            >Ré-éditer mon mot de passe</button>
        </div>
        <div v-else class="mx-88 flex justify-center">
            <div class="w-5/12">
                <input
                    class="mx-auto appearance-none block rounded text-gray-700 outline-none leading-tight text-gray-600"
                    id="password"
                    type="password"
                    placeholder="***********"
                    v-model="password"
                />
                <input
                    class="mx-auto appearance-none rounded text-gray-700 outline-none leading-tight text-gray-600"
                    id="passwordConfirmation"
                    type="password"
                    placeholder="***********"
                    v-model="passwordConfirmation"
                />
                <button
                    class="bg-third text-white rounded-xl py-2 tracking-widest font-primary px-2 mb-2 text-base font-bold uppercase focus:outline-none"
                    @click="modifyPasswordUser()"
                >Modifier mon mot de passe</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
    data: function() {
        return {
            email: "",
            token: this.$route.query.token,
            password: "",
            passwordConfirmation: "",
            errors: {
                password: {
                    error: false,
                    message: ""
                },
                password_confirmation: {
                    error: false,
                    message: ""
                }
            }
        };
    },
    created() {},
    computed: {},
    methods: {
        ...mapActions(["sendResetPasswordLink", "modifyPassword"]),
        modifyPasswordUser() {
            let data = {
                password: this.password,
                password_confirmation: this.passwordConfirmation,
                token: this.token
            };
            this.modifyPassword(data)
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        }
    }
};
</script>