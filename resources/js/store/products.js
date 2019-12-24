const products = {
	state: {
		loadingProducts: null,
		products: {},
		thematic: {},
		productDetail: {},
		loadingProductDetails: null,
	},
	mutations: {
		GET_PRODUCTS(state) {
			state.loadingProducts = true;
		},
		GET_PRODUCTS_SUCCESS(state, data) {
			state.loadingProducts = false;
			state.thematic = data.thematic
			state.products = data.products
		},
		GET_PRODUCT_DETAILS(state) {
			state.loadingProductDetails = true;
		},
		GET_PRODUCT_DETAILS_SUCCESS(state, data) {
			state.loadingProductDetails = false;
			state.productDetail = data.data[0];
		}
	},
	getters: {
		loadingProducts: state => state.loadingProducts,
		loadingProductDetails: state => state.loadingProductDetails,
		products: state => state.products,
		thematic: state => state.thematic,
		productDetail: state => state.productDetail
	},
	actions: {
		async getProducts({ commit }, thematic) {
			return new Promise((resolve, reject) => {
				commit("GET_PRODUCTS", true);
				axios.get(`/api/products/${thematic}`, {
					filter: {
						thematic : true,
						name : thematic
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
		async getProductDetails({ commit }, productId) {
			return new Promise((resolve, reject) => {
				commit("GET_PRODUCT_DETAILS", true)
				axios.get(`/api/products/${productId}`)
					.then(({ data }) => {
						commit('GET_PRODUCT_DETAILS_SUCCESS', data)
						resolve(data);
					})
					.catch(error => {
						reject(error)
					})

			})
		}
	}
};

export default products;
