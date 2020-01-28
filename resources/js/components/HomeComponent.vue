<template>
    <div>
        <v-snackbar
            v-model="snackbar.display"
            :timeout="snackbar.timeout"
            :color="snackbar.color"
        >{{ snackbar.text }}</v-snackbar>
        <navbar-component></navbar-component>
        <router-view></router-view>
        <newsletter-component></newsletter-component>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import NavbarComponent from "./NavbarComponent.vue";
import NewsletterComponent from "./NewsletterComponent.vue";

export default {
    components: {
        NavbarComponent,
        NewsletterComponent
    },
    data() {
        return {
            snackbar: {
                display: false,
                text: "",
                timeout: 3000,
                color: "error"
            }
        };
    },
    created() {
        // We verify if we have a token for the user
        if (localStorage.getItem("vp-token") && !this.authenticated) {
            this.fetchUser(localStorage.getItem("vp-token"));
        }

        // In order to load the thematics from the database
        this.fetchThematics();

        // In order to load the calendar products we already have in the local storage
        this.loadCalendarProducts();

        // In order to reset the breadcrumb before putting the breadcrumb 1
        this.resetBreadcrumb();
        let breadcrumb = {
            index: 1,
            text: "Accueil",
            pathName: "home",
            params: {}
        };
        this.pushInBreadcrumb(breadcrumb);
    },
    mounted() {},
    computed: {
        ...mapGetters(["authenticated", "flash"])
    },
    methods: {
        ...mapActions([
            "fetchThematics",
            "fetchUser",
            "pushInBreadcrumb",
            "resetBreadcrumb",
            "loadCalendarProducts",
            "resetFlash"
        ])
    },
    watch: {
        flash(flashMessage) {
            if (flashMessage.message) {
                this.snackbar.display = true;
                this.snackbar.color = flashMessage.type;
                this.snackbar.text = flashMessage.message;
                setTimeout(() => {
                    this.resetFlash();
                }, this.snackbar.timeout);
            }
        }
    }
};
</script>

<style lang="css">
.v-snack .error {
    background-color: #ff5252 !important;
    border-color: #ff5252 !important;
}

.v-snack .success {
    background-color: #4caf50 !important;
    border-color: #4caf50 !important;
}
</style>