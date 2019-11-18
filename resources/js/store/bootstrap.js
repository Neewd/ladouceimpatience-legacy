const bootstrap = {
	state: {
		thematics: [],
		loading: false,
		error : {}
	},
	mutations: {
		FETCH_THEMATICS(state, thematics) {
			state.loading = false;
			state.thematics = thematics;
		},
		TOGGLE_LOADING(state,loading) {
			state.loading = loading;
		},
		SET_ERROR(state,error) {
			state.error = error;
		}
	},
	getters: {
		thematics: state => state.thematics,
		loading: state => state.loading
	},
	actions: {
		async fetchThematics({ commit }) {
			
			commit("TOGGLE_LOADING", true);
			axios.get('/api/thematics')
				.then(response => {
					commit("FETCH_THEMATICS", response.data);
				})
				.catch(error => {
					console.error(error)
				})
		},
	}
};

export default bootstrap;
