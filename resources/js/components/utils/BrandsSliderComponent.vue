<template>
    <div class="brands-slider-container" ref="brandsSlider">
        <div id="brands-slider">
            <img v-for="brand in brands" :key="brand.name" :src="brand.picture_url" alt />
        </div>
    </div>
</template>

<script>
const $ = require("jquery");
import "slick-carousel";

export default {
    props: ["brands"],
    data() {
        return {
            slickOptions: {
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 3,
                variableWidth: false,
                arrows: false
            }
        };
    },
    mounted() {
        $("#brands-slider").slick(this.slickOptions);
    },
    methods: {
        handleNext() {
            $("#brands-slider").slick("slickNext");
        },
        handlePrev() {
            $("#brands-slider").slick("slickNext");
        }
    },
    watch: {
        brands(newValue) {
            const currentSlide = $("#brands-slider").slick("slickCurrentSlide");

            $("#brands-slider").slick("unslick");
            this.$nextTick(() => {
                $("#brands-slider").slick(this.slickOptions);
                $("#brands-slider").slick('slickGoTo',currentSlide, true);
            });
        }
    }
};
</script>

<style scoped>
@import "//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css";
.brands-slider-container {
    margin: 0 auto;
    width: 95%;
}

.slick-slide {
    text-align: center;
}
</style>
