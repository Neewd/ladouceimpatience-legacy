<template>
    <div>
        <p class="uppercase text-center text-2xl my-6">Mon calendrier</p>
        <div id="calendar" class="flex px-64 flex-col">
            <!-- ROW -->
            <div class="flex justify-around" v-for="(chunk, index) in builtCalendarProducts"  :key="index">
                <!-- DAY -->
                <div v-for="(day, index) in chunk" :key="index" class="w-3/12 h-80 m-2 flex justify-center hover:cursor-pointer" :class="{ 'items-end' : (index % 2) !== 0, 'items-start' : (index % 2) === 0 }">
                    <div class="flex flex-col" :class="{ 'items-end' : (index !== 1), 'flex-row-reverse' : (index == 2), 'items-center' : (index == 1)}" v-popover="{index : index, product: day.product, day: day.day }">
                        <div class="flex" :class="{ 'justify-center' : (index === 1), 'self-start': (index === 0), 'self-end': (index == 2)}" v-if="day.product">
                            <img class="h-40 w-40" :src="day.product.image_primary.url" alt />
                        </div>
                        <div class="flex justify-center" v-else>
                            <div class="h-40 w-40"></div>
                        </div>
                        <div class="flex w-2/3" :class="{ 'flex-row-reverse' : (index == 2), 'self-start' : (index ==2)}">
                            <p class="font-primary leading-xs self-end text-8xl" :class="{ 'text-gray-400' : !day.product}">{{ day.day }}</p>
                            <div class="flex flex-col justify-end border-b border-black text-right pr-2 flex-grow" :class="{ 'flex-row-reverse' : (index == 2), 'border-gray-400' : !day.product}">
                                <p class="text-xxs text-gray-800" v-if="day.product">{{ day.product.name }}</p>
                                <p class="text-xxs font-bold uppercase" v-if="day.product">{{ day.product.brand.name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    data() {
        return {
            builtCalendarProducts: [],
            showModal: false,
            chosenProduct: -1
        };
    },
    created() {
        this.builtCalendarProducts = this.calendarProducts.chunk(3);
        for (let i = 0; i < this.builtCalendarProducts.length; i++) {
            const chunk = this.builtCalendarProducts[i];
            const savedDayInChunk = chunk[2];
            chunk[2] = chunk[1];
            chunk[1] = savedDayInChunk;
        }
    },
    methods: {
        ...mapActions(["exchangeTwoDayProduct"])
    },
    computed: {
        ...mapGetters(["calendarProducts"]),
        daysToExchangeWith() {

        }
    },
    watch: {
        calendarProducts(newCalendarProducts) {
            this.builtCalendarProducts = this.calendarProducts.chunk(3);
            for (let i = 0; i < this.builtCalendarProducts.length; i++) {
                const chunk = this.builtCalendarProducts[i];
                const savedDayInChunk = chunk[2];
                chunk[2] = chunk[1];
                chunk[1] = savedDayInChunk;
            }
        }
    }
};
</script>

