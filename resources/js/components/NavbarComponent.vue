<template>
    <div>
        <div
            class="h-8 w-screen bg-secondary text-white flex justify-center items-center font-secondary text-sm"
        >Livraison offerte dès 79€ d'achats. Retours et échanges gratuits.</div>
        <div class="flex flex-row justify-between pt-2 pb-6 mx-32">
            <div id="nav2" class="flex justify-center">
                <ul
                    class="list-none flex flex-row justify-around w-64 font-secondary text-gray-800 text-sm"
                >
                    <li class="hover:cursor-pointer flex items-center">Le concept</li>
                    <li class="hover:cursor-pointer flex items-center">E-shop</li>
                    <li class="hover:cursor-pointer flex items-center">Blog</li>
                </ul>
            </div>
            <div id="social-icons" class="flex justify-end items-center">
                <i class="la la-facebook-f px-3 hover:cursor-pointer flex items-center"></i>
                <i class="la la-instagram px-3 hover:cursor-pointer flex items-center"></i>
                <span id="separator" class="h-4 w-px bg-gray-600"></span>
                <router-link
                    to="/auth"
                    class="mx-5 hover:cursor-pointer text-xs font-secondary"
                    v-if="!authenticated"
                >S'identifier</router-link>
                <router-link
                    to="/auth"
                    class="mx-5 hover:cursor-pointer text-xs font-secondary"
                    v-if="authenticated"
                >Mon compte</router-link>
                <calendar-icon size="1x" class="custom-class hover:cursor-pointer"></calendar-icon>
                <shopping-cart-icon size="1x" class="ml-4 hover:cursor-pointer"></shopping-cart-icon>
            </div>
        </div>

        <div id="logo" class="flex items-center w-full justify-center pt-1 pb-8">
            <img src="/img/logo.jpg" class="h-12" />
        </div>
        <div id="navbar" class="pt-1 pb-2">
            <ul
                class="flex flex-row list-none px-32 uppercase justify-between h-8 w-full font-primary"
            >
                <div
                    v-bind:key="thematic.id"
                    v-for="thematic in thematics"
                    class="flex justify-center items-center"
                >
                    <router-link
                        :to="`/thematic/${thematic.slug}`"
                        class="hover:cursor-pointer h-full flex items-center"
                    >{{ thematic.name }}</router-link>
                </div>
            </ul>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import { CalendarIcon, ShoppingCartIcon } from "vue-feather-icons";

export default {
    components: {
        CalendarIcon,
        ShoppingCartIcon
    },
    data: function() {
        return {};
    },
    computed: {
        ...mapGetters(["thematics", "authenticated"])
    }
};
</script>