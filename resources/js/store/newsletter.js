const newsletter = {
	state: {
		loadingNewsletter : false,
		error : {}
	},
	mutations: {
		SUBSCRIBE_NEWSLETTER(state) {
			state.loadingNewsletter = true;
        },
        SUBSCRIBE_NEWSLETTER_SUCCESS(state) {
			state.loadingNewsletter = false;
		},
	},
	getters: {
        loadingNewsletter : state => state.loadingNewsletter
    },
	actions: {
		async registerNewsletter({ commit }, email) {
			return new Promise((resolve, reject) => {
				commit("SUBSCRIBE_NEWSLETTER", true);
                axios.post('/api/newsletter', { email : email })
                    .then(({ data }) => {
                        commit("SUBSCRIBE_NEWSLETTER_SUCCESS", data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error)
                    })
			})
		}
	}
};

export default newsletter;
