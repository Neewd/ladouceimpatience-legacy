<template>
    <div>
        <div id="productDetail" class="bg-primary w-screen py-4" v-if="!loadingProductDetails">
            <div id="breadCrumb" class="px-32 py-2">
                <ul class="flex">
                    <li v-for="(breadcrumb,index) in breadcrumbs" :key="breadcrumb.index">
                        <span v-if="breadcrumb.index === breadcrumbs.length">
                            {{ breadcrumb.text }}
                        </span>
                        <router-link v-else
                                    :to="{ name: breadcrumb.pathName, params:  breadcrumb.params }" 
                                    class="underline italic">{{ breadcrumb.text }}</router-link>
                        <span class="mx-2" v-if="index < breadcrumbs.length -1">
                            >
                        </span>
                    </li>
                </ul>
            </div>

            <div id="details" class="flex px-32">
                <div class="w-2/3">
                    <picture v-if="productDetail.image_primary">
                        <img :src="productDetail.image_primary.url" alt />
                    </picture>
                </div>
                <div class="w-1/3">
                    <h1>{{ productDetail.name }}</h1>
                    <h2>{{ productDetail.brand.name }}</h2>
                    <div class="flex ">
                        <div class="h-6 w-6 rounded-full bg-blue-900" v-for="index in productDetail.range" :key="index"></div>
                    </div>

                    <div class="my-2">
                        <span class="uppercase font-semibold tracking-widest text-xs">Description</span>
                        <span class="font-semibold tracking-widest text-xs">|</span>
                        <span class="uppercase font-semibold tracking-widest text-xs">Caractéristiques</span>
                        <span class="font-semibold tracking-widest text-xs">|</span>
                        <span class="uppercase font-semibold tracking-widest text-xs">Conseils</span>
                    </div>

                    <button class="rounded-full w-64 text-lg bg-third text-white py-1 tracking-widest my-6"> Ajouter au calendrier</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    data() {
        return {
            productId: this.$route.params.productId
        };
    },
    created() {
        this.getProductDetails(this.productId).then(({ data }) => {
            let breadcrumb = {
                index: 3,
                text: data[0].name,
                pathName: "home",
                params: {},
                meta: data
            };
            this.pushInBreadcrumb(breadcrumb);
        });
    },
    methods: {
        ...mapActions(["getProductDetails", "pushInBreadcrumb"])
    },
    computed: {
        ...mapGetters(["productDetail", "loadingProductDetails", "breadcrumbs"])
    }
};
</script>