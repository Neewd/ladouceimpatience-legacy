<template>
    <div
        id="popover"
        class="absolute bg-white rounded-lg shadow-nice p-4 border-gray-300 border"
        v-click-outside="onClickOutside"
        :style="styleObject"
    >
        <div class="flex flex-wrap">
            <div>
                <ul>
                    <li class="flex items-center hover:cursor-pointer" @click="openProduct()">
                        <info-icon size="1x" class="mr-2"></info-icon>Ouvrir la page produit
                    </li>

                    <li class="flex items-center hover:cursor-pointer" @click="changeDayOfProduct()">
                        <repeat-icon size="1x" class="mr-2"></repeat-icon>Changer de jour
                    </li>
                    <li class="flex items-center hover:cursor-pointer" @click="removeProduct()">
                        <trash-2-icon size="1x" class="mr-2"></trash-2-icon>Supprimer
                    </li>
                </ul>
            </div>
        </div>
        <modal v-if="showModal" @close="showModal = false" :daysAlreadyTaken="daysToExchangeWith" @addProductToDay="onExchangeProductDay($event)"/>
    </div>
</template>

<script>
import { Trash2Icon, RepeatIcon, InfoIcon } from "vue-feather-icons";
import { mapActions, mapGetters } from 'vuex' 

export default {
    components: {
        Trash2Icon,
        RepeatIcon,
        InfoIcon
    },
    data() {
        return {
            offsetTop: 0,
            offsetLeft: 0,
            parent: null,
            elementWidth: 0,
            elementHeight: 0,
            offset: 8,
            position: "",
            styleObject: {
                top: "0px",
                left: "0px",
                width: "",
                height: "",
                maxWidth: "",
                maxHeight: ""
            },
            index: -1,
            product: null,
            day: -1,
            router: null,
            showModal: false
        };
    },
    mounted() {
        this.$nextTick(() => {
            this.positionPopover();
        });
    },
    computed: {
        ...mapGetters(['daysAlreadyTaken']),
        daysToExchangeWith() {
            return this.daysAlreadyTaken.filter(day => day.day == this.day)
        }
    },
    methods: {
        ...mapActions(['removeProductFromCalendar', 'exchangeTwoDayProduct']),
        onClickOutside() {
            this.destroy();
        },
        destroy() {
            this.$destroy();
            this.$el.parentNode.removeChild(this.$el);
        },
        openProduct() {
            this.destroy();
            this.router.push({
                name: "product-page",
                params: {
                    thematicSlug: this.product.primary_thematic.slug,
                    productId: this.product.id
                }
            });
        },
        removeProduct() {
            this.removeProductFromCalendar(this.day)
            this.destroy();
        },
        changeDayOfProduct() {
            this.showModal = true
        },
        onExchangeProductDay(toDay) {
            let dataExchange = { source : this.day, to : toDay}
            this.exchangeTwoDayProduct(dataExchange);
            this.destroy();
        },
        positionPopover() {
            this.position =
                this.index == 0 ? "right" : this.index == 1 ? "top" : "left";
            let componentHeight = this.$el.offsetHeight;
            let componentWidth = this.$el.clientWidth;
            let positionTop, positionLeft;

            switch (this.position) {
                case "top":
                    positionTop =
                        this.offsetTop - componentHeight - this.offset;
                    positionLeft =
                        this.offsetLeft +
                        this.elementWidth / 2 -
                        componentWidth / 2;
                    break;
                case "left":
                    positionTop =
                        this.offsetTop +
                        this.elementHeight / 2 -
                        componentHeight / 2;
                    positionLeft =
                        this.offsetLeft - componentWidth - this.offset;
                    break;
                case "right":
                    positionTop =
                        this.offsetTop +
                        this.elementHeight / 2 -
                        componentHeight / 2;
                    positionLeft =
                        this.offsetLeft + this.elementWidth + this.offset;
                    break;
                case "bottom":
                    positionTop =
                        this.offsetTop + this.elementHeight + this.offset;
                    positionLeft =
                        this.offsetLeft +
                        this.elementWidth / 2 -
                        componentWidth / 2;
                    break;
            }
            this.styleObject.top = `${positionTop}px`;
            this.styleObject.left = `${positionLeft}px`;
        }
    }
};
</script>