<template>
    <div>
        <div id="hero" class="bg-primary h-20 flex items-center justify-center w-screen">
            <p class>{{ thematic.name }}</p>
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
                        :to="{ name: 'product-page', params: { id: product.id }}"
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
                    class="w-1/3 px-2 mb-6 hover:cursor-pointer flex flex-col items-center justify-center"
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
            thematicSlug: this.$route.params.thematic || "tous",
            filters: {}
        };
    },
    mounted() {
        switch (this.thematicSlug) {
            case "tous":
                this.getAllProducts();
                break;
            case "les-nouveautes":
                this.getNewProducts();
                break;
            default:
                this.getProductsByThematic(this.thematicSlug);
                break;
        }
    },
    computed: {
        ...mapGetters(["products", "loadingProducts", "thematic"])
    },
    methods: {
        ...mapActions([
            "getAllProducts",
            "getProductsByThematic",
            "getNewProducts"
        ])
    },
    watch: {
        $route(to, from) {
            if (to.params.thematic) {
                if (this.thematicSlug !== to.params.thematic) {
                    this.getProducts(to.params.thematic);
                }
                this.thematicSlug = to.params.thematic;
            }
        }
    }
};
</script>
