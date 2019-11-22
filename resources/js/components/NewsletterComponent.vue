<template>
    <div class>
        <div class="pt-4 min-w-full flex justify-center text-3xl border-t-2 border-third">
            <ul class="flex flex-row justify-around w-8/12">
                <li class="flex justify-center w-3/12">
                    <span class="flex justify-center">
                        <i class="la la-comments"></i>
                    </span>
                </li>
                <li class="flex justify-center w-3/12">
                    <span class="flex justify-center">
                        <i class="la la-truck"></i>
                    </span>
                </li>
                <li class="flex justify-center w-3/12">
                    <span class="flex justify-center">
                        <i class="la la-money-bill"></i>
                    </span>
                </li>
            </ul>
        </div>
        <div class="flex justify-center">
            <ul class="flex flex-row justify-around w-8/12">
                <li class="flex justify-center w-3/12">
                    <p class="text-xl text-center">Service client</p>
                </li>
                <li class="flex justify-center w-3/12">
                    <p class="text-xl text-center">Expédition</p>
                </li>
                <li class="flex justify-center w-3/12">
                    <p class="text-xl text-center">Paiement</p>
                </li>
            </ul>
        </div>
        <div class="flex justify-center pb-4">
            <ul class="flex flex-row justify-around w-8/12">
                <li class="flex justify-center w-3/12">
                    <p
                        class="text-xxs text-justify w-10/12"
                    >Notre souhait est de vous aider au mieux, n'hésitez pas à nous contacter.</p>
                </li>
                <li class="flex justify-center w-3/12">
                    <p
                        class="text-xxs text-justify w-10/12"
                    >Nous préparons votre calendrier avec le plus grand soin.</p>
                </li>
                <li class="flex justify-center w-3/12">
                    <p class="text-xxs text-justify w-10/12">100% sécurisé, on prend soin de vous.</p>
                </li>
            </ul>
        </div>

        <div class="bg-primary w-full py-6 px-88 flex items-center align- flex-col">
            <h2
                class="mb-4"
            >Ne perdez pas de temps et inscrivez vous à la newsletter dès maintenant !</h2>
            <div class="min-w-full justify-center flex items-center">
                <input
                    class="w-7/12 rounded focus:outline-none py-2 px-6"
                    type="text"
                    placeholder="Votre adresse mail"
                    v-model="emailNewsletter"
                />
                <button
                    class="py-2 px-6 bg-secondary rounded text-white"
                    @click="registerEmailInNewsletter()"
                >S'inscrire</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            emailNewsletter: ""
        };
    },
    methods: {
        ...mapActions(["registerNewsletter"]),
        registerEmailInNewsletter() {
            this.registerNewsletter(this.emailNewsletter);
        }
    }
};
</script>