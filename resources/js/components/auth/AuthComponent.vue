<template>
    <div class="container mx-auto flex my-6 flex-col justify-center">
        <p
            class="text-4xl uppercase mx-auto font-primary font-extrabold"
            id="bienvenue-text"
        >Bienvenue</p>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            userId: ""
        };
    },
    created() {},
    computed: {},
    methods: {}
};
</script>