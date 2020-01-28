const bootstrap = {
	state: {
		thematics: [],
		loading: false,
		flash: {}
	},
	mutations: {
		FETCH_THEMATICS(state, thematics) {
			state.loading = false;
			state.thematics = thematics;
		},
		TOGGLE_LOADING(state, loading) {
			state.loading = loading;
		},
		SET_FLASH(state, flash) {
			state.flash = flash
		},
		RESET_FLASH(state) {
			state.flash = {}
		}
	},
	getters: {
		thematics: state => state.thematics,
		loading: state => state.loading,
		flash: state => state.flash
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
		async resetFlash({ commit }) {
			commit('RESET_FLASH');
		}
	}
};

export default bootstrap;
