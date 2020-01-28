<template>
    <div>
        <div id="hero" class="bg-primary py-6 flex items-center justify-center w-screen flex-col">
            <p class>{{ thematic.name }}</p>
            <p class="w-6/12 text-xs text-center">
                {{ thematic.description }}
            </p>
        </div>
        <div class="flex px-32 flex-col">
            <div id="filters"></div>
            <div class="w-full flex flex-wrap" v-if="!loadingProducts">
                <div
                    class="w-1/3 hover:cursor-pointer flex p-6 flex-col"
                    v-for="product in products"
                    :key="product.id"
                >
                    <router-link
                        :to="{  name: 'product-page', 
                                params: {  
                                    thematicSlug: product.primary_thematic.slug, 
                                    productId: product.id
                                }
                        }"
                        class="mx-5 hover:cursor-pointer text-xs font-secondary block relative"
                    >
                        <img :src="product.image_primary.url" class="w-full" />
                        <picture
                            class="group absolute w-full opacity-0 top-0 left-0 hover:opacity-100 transition-all transition-ease transition-500"
                        >
                            <img :src="product.image_secondary.url" class="w-full h-full" />
                            <div class="absolute bg-white w-full h-full top-0 left-0 opacity-75"></div>
                            <div
                                class="flex flex-col absolute w-full h-full top-0 left-0 flex items-center justify-center translate-x-30"
                            >
                                <span
                                    class="block font-bold relative top-minus-40 group-hover:top-0 transition-opacity-top transition-duration-2-3 transition-timing-ease-ease transition-delay-product"
                                >{{ product.name}}</span>
                                <span
                                    class="block font-bold relative top-40 group-hover:top-0 transition-opacity-top transition-duration-2-3 transition-timing-ease-ease transition-delay-product"
                                >{{ product.range}}</span>
                            </div>
                        </picture>
                    </router-link>
                </div>
            </div>

            <div v-else class="w-full flex flex-wrap">
                <div
                    class="w-1/3 px-2 my-6 hover:cursor-pointer flex flex-col items-center justify-center"
                    v-for="index in 12"
                    :key="index"
                >
                    <div class="bg-gray-200 rounded w-72 h-72 mb-4"></div>
                    <div class="bg-gray-200 rounded w-64 h-6"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import { ArrowLeftIcon, ArrowRightIcon } from "vue-feather-icons";

export default {
    components: {
        ArrowLeftIcon,
        ArrowRightIcon
    },
    data() {
        return {
            thematicSlug: this.$route.params.thematicSlug,
            filters: {}
        };
    },
    mounted() {
        this.getProducts(this.thematicSlug).then(({ products, thematic }) => {
            let breadcrumb = {
                index: 2,
                text: thematic.name,
                pathName: "thematic-products",
                params: { thematicSlug : thematic.slug }
            };
            this.pushInBreadcrumb(breadcrumb);
        });
    },
    computed: {
        ...mapGetters(["products", "loadingProducts", "thematic"])
    },
    methods: {
        ...mapActions(["getProducts", "pushInBreadcrumb"])
    },
    watch: {
        $route(to, from) {
            if (to.params.thematicSlug) {
                if (this.thematicSlug !== to.params.thematicSlug) {
                    this.getProducts(to.params.thematicSlug);
                }
                this.thematicSlug = to.params.thematicSlug;
            }
        }
    }
};
</script>