const numberOfRangeOne = 14;
const numberOfRangeTwo = 7;
const numberOfRangeThree = 3;

const localStorageKeyName = 'di-calendarProducts'

const calendarProduct = {
    state: {
        loadingCalendarProducts: false,
        calendarProducts: [] = []
    },
    mutations: {
        LOAD_CALENDAR_PRODUCTS(state) {
            state.loadingCalendarProducts = true;
        },
        LOAD_CALENDAR_PRODUCTS_SUCCESS(state, products) {
            state.loadingCalendarProducts = false;
            state.calendarProducts = products;
        },
        ADD_PRODUCT_TO_CALENDAR(state, data) {
            const product = data.product;
            const day = data.day;
            const alreadyTakenDays = data.alreadyTakenDays;
            const commit = data.commit;
            commit('SET_FLASH', { message: 'Le produit à bien été ajouté', 'type': 'success' })
            let calendarLocalStorage = JSON.parse(localStorage.getItem(localStorageKeyName));
            if (!alreadyTakenDays.includes(day)) {
                switch (product.range) {
                    case 1:
                        const numberOfRangeOneInCalendar = getNumberOfNRangeInProduct(1, state.calendarProducts);
                        if (numberOfRangeOneInCalendar < numberOfRangeOne) {

                            state.calendarProducts.find(calendarDayProduct => calendarDayProduct.day == day).product = product
                            if (calendarLocalStorage && calendarLocalStorage.length) {
                                calendarLocalStorage.find(calendarDayProduct => calendarDayProduct.day == day).product = product
                                localStorage.setItem(localStorageKeyName, JSON.stringify(calendarLocalStorage));
                            }
                            commit('SET_FLASH', { message: 'Le produit à bien été ajouté', 'type': 'success' })
                        } else {
                            commit('SET_FLASH', { message: 'Il y a déjà trop de produit de cette range.', type: 'error' })
                        }
                        break;
                    case 2:
                        const numberOfRangeTwoInCalendar = getNumberOfNRangeInProduct(2, state.calendarProducts);
                        if (numberOfRangeTwoInCalendar < numberOfRangeTwo) {

                            state.calendarProducts.find(calendarDayProduct => calendarDayProduct.day == day).product = product
                            if (calendarLocalStorage && calendarLocalStorage.length) {
                                calendarLocalStorage.find(calendarDayProduct => calendarDayProduct.day == day).product = product
                                localStorage.setItem(localStorageKeyName, JSON.stringify(calendarLocalStorage));
                            }
                            commit('SET_FLASH', { message: 'Le produit à bien été ajouté', 'type': 'success' })
                        } else {
                            commit('SET_FLASH', { message: 'Il y a déjà trop de produit de cette range.', type: 'error' })
                        }
                        break;
                    case 3:
                        const numberOfRangeThreeInCalendar = getNumberOfNRangeInProduct(3, state.calendarProducts);
                        if (numberOfRangeThreeInCalendar < numberOfRangeThree) {

                            state.calendarProducts.find(calendarDayProduct => calendarDayProduct.day == day).product = product
                            if (calendarLocalStorage && calendarLocalStorage.length) {
                                calendarLocalStorage.find(calendarDayProduct => calendarDayProduct.day == day).product = product
                                localStorage.setItem(localStorageKeyName, JSON.stringify(calendarLocalStorage));
                            }
                            commit('SET_FLASH', { message: 'Le produit à bien été ajouté', 'type': 'success' })
                        } else {
                            commit('SET_FLASH', { message: 'Il y a déjà trop de produit de cette range.', type: 'error' })
                        }
                        break;
                }
            } else {
                commit('SET_FLASH', { message: 'Ce jour est déjà pris.', type: 'error' })
            }
        },
        EXCHANGE_DAY_PRODUCT(state, data) {
            let sourceDayProduct = state.calendarProducts.find(productDay => productDay.day == data.sourceDay).product;
            let toDayProduct = state.calendarProducts.find(productDay => productDay.day == data.toDay).product;

            state.calendarProducts[data.toDay - 1].product = sourceDayProduct
            state.calendarProducts[data.sourceDay - 1].product = toDayProduct

            localStorage.setItem(localStorageKeyName, JSON.stringify(state.calendarProducts));

        },
        REMOVE_PRODUCT_FROM_CALENDAR(state, day) {
            state.calendarProducts[day - 1].product = undefined;
            localStorage.setItem(localStorageKeyName, JSON.stringify(state.calendarProducts));
        }
    },
    getters: {
        loadingCalendarProducts: state => state.loadingCalendarProducts,
        calendarProducts: state => state.calendarProducts,
        daysAlreadyTaken: state => state.calendarProducts.filter(calendarProduct => calendarProduct.product !== undefined)
    },
    actions: {
        async getCalendarProducts({ commit }) {
            return new Promise((resolve, reject) => {
                commit("GET_PRODUCTS", true);
                axios.get(`/api/products/${thematic}`, {
                    filter: {
                        thematic: true,
                        name: thematic
                    }
                })
                    .then(({ data }) => {
                        commit("GET_PRODUCTS_SUCCESS", data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        async addProductToCalendar({ commit, getters }, day) {
            return new Promise((resolve, reject) => {
                // Our user is authenticated we have to add the product into the calendar database
                if (getters.authenticated) {
                    console.log('i have to do something here')
                }
                commit("ADD_PRODUCT_TO_CALENDAR", { product: getters.productDetail, day: day, alreadyTakenDays: getters.daysAlreadyTaken, commit: commit });
                resolve()
            })
        },
        async loadCalendarProducts({ commit, dispatch }) {
            return new Promise((resolve, reject) => {
                commit('LOAD_CALENDAR_PRODUCTS')
                let calendarLocalStorage = JSON.parse(localStorage.getItem(localStorageKeyName));
                if (!calendarLocalStorage) {
                    localStorage.setItem(localStorageKeyName, JSON.stringify(initCalendarStorage()));
                }
                commit('LOAD_CALENDAR_PRODUCTS_SUCCESS', calendarLocalStorage);
            })
        },
        async exchangeTwoDayProduct({ commit }, data) {
            return new Promise((resolve, reject) => {
                const dataToExchange = { sourceDay: data.source, toDay: data.to }
                commit("EXCHANGE_DAY_PRODUCT", dataToExchange)
            })
        },
        async removeProductFromCalendar({ commit }, day) {
            return new Promise((resolve,reject) => {
                commit("REMOVE_PRODUCT_FROM_CALENDAR", day)
            })
        }
    }
};

function getNumberOfNRangeInProduct(range, array) {
    if (array.length > 0) {
        let number = 0;
        array.map((product) => {
            if (product.range == range) {
                return number++
            }
        })
        return number
    }
    return 0;
}

function initCalendarStorage() {
    let calendarStorage = []
    for (let i = 0; i < 24; i++) {
        calendarStorage.push({
            day: i + 1,
            product: undefined
        })
    }
    return calendarStorage;
}

function buildCalendar(calendarProducts) {
    let calendar = [];
    for (let i = 1; i <= 24; i++) {
        let productOfTheDay = { day: i };
        productOfTheDay.product = calendarProducts.find(
            product => product.day == i
        );
        calendar.push(productOfTheDay);
    }
    return calendar;
}

export default calendarProduct;
