<template>
    <div>
        <navbar-component></navbar-component>
        <router-view></router-view>
        <newsletter-component></newsletter-component>
    </div>
</template>

<script>
    
    import { mapActions, mapGetters } from 'vuex'
    import NavbarComponent from './NavbarComponent.vue';
    import NewsletterComponent from './NewsletterComponent.vue';

    export default {
        components: {
            NavbarComponent,
            NewsletterComponent
        },
        created () {
            // We verify if we have a token for the user
            if (localStorage.getItem('vp-token') && !this.authenticated) {
                this.fetchUser(localStorage.getItem('vp-token'));
            } 
            this.fetchThematics();
        },
        computed: {
            ...mapGetters(['authenticated'])
        },
        methods : { 
            ...mapActions(['fetchThematics', 'fetchUser'])
        }
    }
</script>
