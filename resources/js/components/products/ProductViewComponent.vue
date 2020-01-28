<template>
    <div v-if="!loadingProductDetails && productFound">
        <div id="productDetail" class="bg-primary w-screen py-4">
            <div id="breadCrumb" class="px-32 py-2">
                <ul class="flex">
                    <li v-for="(breadcrumb,index) in breadcrumbs" :key="breadcrumb.index">
                        <span v-if="breadcrumb.index === breadcrumbs.length">{{ breadcrumb.text }}</span>
                        <router-link
                            v-else
                            :to="{ name: breadcrumb.pathName, params:  breadcrumb.params }"
                            class="underline italic"
                        >{{ breadcrumb.text }}</router-link>
                        <span class="mx-2" v-if="index < breadcrumbs.length -1">></span>
                    </li>
                </ul>
            </div>

            <div id="details" class="flex px-32">
                <div class="w-2/3">
                    <picture v-if="productDetail.image_primary">
                        <div style="width:400px">
                            <zoom-on-hover :img-normal="productDetail.image_primary.url" :scale="3"></zoom-on-hover>
                        </div>
                    </picture>
                </div>
                <div class="w-1/3">
                    <h1>{{ productDetail.name }}</h1>
                    <h2>{{ productDetail.brand.name }}</h2>
                    <div class="flex">
                        <div
                            class="h-6 w-6 rounded-full bg-blue-900"
                            v-for="index in productDetail.range"
                            :key="index"
                        ></div>
                    </div>

                    <div class="my-2">
                        <span
                            class="uppercase font-semibold tracking-widest text-xs hover:cursor-pointer"
                            @click="changePaneActive(1)"
                            :class="{ 'underline': paneActive == 1}"
                        >Description</span>
                        <span class="font-semibold tracking-widest text-xs">|</span>
                        <span
                            class="uppercase font-semibold tracking-widest text-xs hover:cursor-pointer"
                            @click="changePaneActive(2)"
                            :class="{ 'underline': paneActive == 2}"
                        >Caractéristiques</span>
                        <span class="font-semibold tracking-widest text-xs">|</span>
                        <span
                            class="uppercase font-semibold tracking-widest text-xs hover:cursor-pointer"
                            @click="changePaneActive(3)"
                            :class="{ 'underline': paneActive == 3}"
                        >Conseils</span>
                    </div>

                    <div
                        v-if="paneActive == 1"
                        class="transition-all transition-ease transition-500"
                    >{{ productDetail.description}}</div>
                    <div
                        v-if="paneActive == 2"
                        class="transition-all transition-ease transition-500"
                    >{{ productDetail.caracteristics}}</div>
                    <div
                        v-if="paneActive == 3"
                        class="transition-all transition-ease transition-500"
                    >{{ productDetail.advices}}</div>

                    <div class="flex flex-col">
                        <button
                            class="rounded-full w-64 text-lg bg-third text-white py-1 tracking-widest mt-6 mb-4 active:outline-none"
                            @click="startProcessAddProductToCalendar()"
                        >Ajouter au calendrier</button>

                        <modal v-if="showModal" @close="showModal = false" :daysAlreadyTaken="daysAlreadyTaken" @addProductToDay="onAddProductToDay($event)"/>
                    </div>
                </div>
            </div>
        </div>

        <div id="brand-detail" class="my-12">
            <h1 class="uppercase font-primary text-center text-2xl">Notre fournisseur</h1>
            <picture class="flex justify-center mb-4">
                <img :src="productDetail.brand.picture_url" alt />
            </picture>
            <div class="flex justify-center">
                <p class="w-6/12">{{ productDetail.brand.description }}</p>
            </div>
        </div>

        <div id="complete-selection">
            <h1 class="text-center text-2xl font-primary">Pour compléter votre sélection</h1>
            <div class="flex px-80">
                <div
                    class="px-2"
                    v-for="relatedProduct in relatedProducts"
                    :key="relatedProduct.id"
                >
                    <router-link
                        :to="{ name : 'product-page', params :{ 'thematicSlug': relatedProduct.primary_thematic.slug, 'productId' : relatedProduct.id}}"
                    >
                        <img :src="relatedProduct.image_primary.url" alt />
                    </router-link>
                </div>
            </div>

            <div class="flex justify-center my-12" v-if="!loadingProductDetails">
                <router-link
                    :to="{ name : 'thematic-products', params :{ 'thematicSlug': productDetail.primary_thematic.slug}}"
                >
                    <button
                        class="rounded-full w-64 text-lg bg-third text-white py-1 tracking-wider"
                    >Sélection {{ productDetail.primary_thematic.slug}}</button>
                </router-link>
            </div>
        </div>

        <div id="our-brands" class="bg-primary py-6">
            <h1 class="text-2xl font-primary text-center">Nos fournisseurs</h1>
            <div class="flex justify-center mb-4">
                <p
                    class="text-sm w-6/12 text-center"
                >Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi laboriosam eum amet aspernatur error a praesentium enim ea dolore velit? Exercitationem, obcaecati ipsum neque totam doloribus dolorem numquam laborum aliquid.</p>
            </div>

            <div class="flex items-center justify-center bg-primary px-32 mb-4">
                <chevron-left-icon size="8x" class="hover:cursor-pointer" @click="prev()"></chevron-left-icon>
                <brands-slider :brands="brands" ref="brandSliderComponent"></brands-slider>
                <chevron-right-icon size="8x" class="hover:cursor-pointer" @click="next()"></chevron-right-icon>
            </div>
            <div class="flex justify-center">
                <button
                    class="rounded-full w-64 text-lg bg-third text-white py-1 tracking-widest"
                >Voir plus</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import { ChevronRightIcon, ChevronLeftIcon } from "vue-feather-icons";

export default {
    components: {
        ChevronRightIcon,
        ChevronLeftIcon
    },
    data() {
        return {
            productId: this.$route.params.productId,
            paneActive: -1,
            showModal: false
        };
    },
    created() {
        this.initProductPage(this.productId);
        this.paneActive = 1;
    },
    methods: {
        ...mapActions([
            "getProductDetails",
            "getRelatedProducts",
            "pushInBreadcrumb",
            "getBrands",
            "addProductToCalendar"
        ]),
        changePaneActive(index) {
            this.paneActive = index;
        },
        initProductPage(productId) {
            this.getProductDetails(this.productId)
                .then(({ data }) => {
                    this.getRelatedProducts({
                        thematicSlug: this.productDetail.primary_thematic.slug,
                        productId: this.productId
                    });
                    if (this.brands.length == 0) {
                        this.getBrands();
                    }
                    let breadcrumb = {
                        index: 3,
                        text: data.name,
                        pathName: "home",
                        params: {},
                        meta: data
                    };
                    this.pushInBreadcrumb(breadcrumb);
                })
                .catch(error => {
                    if (error.status === 404) {
                        this.$router.push({ name: "not-found" });
                    }
                });
        },
        startProcessAddProductToCalendar() {
            this.showModal = true;
        },
        onAddProductToDay(day) {
            this.addProductToCalendar(day);
        },
        scrollToTop() {
            window.scrollTo(0, 0);
        },
        prev() {
            this.$refs.brandSliderComponent.handlePrev();
        },
        next() {
            this.$refs.brandSliderComponent.handleNext();
        }
    },
    computed: {
        ...mapGetters([
            "productDetail",
            "loadingProductDetails",
            "breadcrumbs",
            "relatedProducts",
            "brands",
            "productFound",
            "daysAlreadyTaken"
        ])
    },
    watch: {
        "$route.params.productId": function(productId) {
            this.initProductPage(productId);
            this.scrollToTop();
        }
    }
};
</script>