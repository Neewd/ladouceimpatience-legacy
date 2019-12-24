<template id="breadcrumb">
    <span>
        <span v-if="!route.meta.breadcrumb.dynamic">
            <router-link v-if="route.meta.breadcrumb.linkPath" :to="route.meta.breadcrumb.linkPath" >{{route.meta.breadcrumb.linkText}}</router-link>
            <router-link v-else :to="{name: route.name}">{{route.meta.breadcrumb.linkText}}</router-link>
        </span>
        <span v-else>
            <router-link v-if="route.meta.breadcrumb.linkPath" :to="route.meta.breadcrumb.linkPath">
                <template v-if="value">{{formattedValue}}</template>
                <template v-if="!value">{{loadingText}}</template>
            </router-link>
            <router-link v-else :to="{name: route.name, params: {id: $route.params.id}}">
                <template v-if="value">{{formattedValue}}</template>
                <template v-if="!value">{{loadingText}}</template>
            </router-link>
        </span>
    </span>
</template>

<script>
export default {
    props: ["route"],
    beforeCreate() {
        this.$options.computed.value = function() {
            if (this.route.meta.breadcrumb.getter) {
                return this.$store.getters[this.route.meta.breadcrumb.getter];
            } else {
                return null;
            }
        };
    },
    computed: {
        formattedValue() {
            return this.route.meta.breadcrumb.linkText(this.value);
        },
        loadingText() {
            return "Loading...";
        }
    }
};
</script>