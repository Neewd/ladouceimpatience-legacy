const brands = {
	state: {
		loadingBrands : false,
		brands : []
	},
	mutations: {
		GET_BRANDS(state) {
			state.loadingBrands = true;
        },
        GET_BRANDS_SUCCESS(state, data) {
			state.loadingBrands = false;
            state.brands = data
		},
	},
	getters: {
        loadingBrands : state => state.loadingBrands,
        brands : state => state.brands
    },
	actions: {
		async getBrands({ commit }) {
			return new Promise((resolve, reject) => {
				commit("GET_BRANDS", true);
                axios.get('/api/brands')
                    .then(({ data }) => {
                        commit("GET_BRANDS_SUCCESS", data.brands);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error)
                    })
			})
		}
	}
};

export default brands;
