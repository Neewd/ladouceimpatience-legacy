const products = {
	state: {
		loadingProducts: null,
		loadingProductDetails: null,
		loadingRelatedProducts: null,
		products: {},
		thematic: {},
		productDetail: {},
		productFound: false,
		relatedProducts: []
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
			state.productDetail = data.data;
			state.productFound = true;
		},
		GET_PRODUCT_DETAILS_FAILURE(state) {
			state.loadingProductDetails = false;
		},
		GET_RELATED_PRODUCT(state) {
			state.loadingRelatedProducts = true;
		},
		GET_RELATED_PRODUCT_SUCCESS(state, data) {
			state.loadingRelatedProducts = false;
			state.relatedProducts = data.data;
		},
	},
	getters: {
		loadingProducts: state => state.loadingProducts,
		loadingProductDetails: state => state.loadingProductDetails,
		loadingRelatedProducts: state => state.loadingRelatedProducts,
		products: state => state.products,
		thematic: state => state.thematic,
		productDetail: state => state.productDetail,
		productFound: state => state.productFound,
		relatedProducts: state => state.relatedProducts
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
					.catch( (error)=> {
						commit('GET_PRODUCT_DETAILS_FAILURE')
						reject(error.response)
					})

			})
		},
		async getRelatedProducts({ commit }, request) {
			return new Promise((resolve, reject) => {
				commit("GET_RELATED_PRODUCT", true)
				axios.get(`/api/products/related/${request.thematicSlug}/${request.productId}`)
					.then(({ data }) => {
						commit('GET_RELATED_PRODUCT_SUCCESS', data)
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
