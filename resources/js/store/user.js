const user = {
	state: {
		user: null,
		token: localStorage.getItem('vp-token') || null,
		authenticated: false,
		emailVerification : {
			loading: false,
			finished: false,
			message: '',
			error: false
		},
		error : {}
	},
	mutations: {
		LOGIN(state, thematics) {
			state.loading = true;
		},
		LOGIN_SUCCESS(state, data) {
			localStorage.setItem('vp-token', data.access_token);
			localStorage.setItem('vp-refresh-token', data.refresh_token);
			window.axios.defaults.headers.common['Authorization'] = `Bearer ${data.access_token}`
			state.authenticated = true;
			state.token = data.access_token;
			state.loading = false;
		},
		LOGOUT_SUCCESS(state) {
			state.authenticated = false;
			state.token = null;
		},
		VERIFY_USER_MAIL(state) {
			state.emailVerification.loading = true;
		},
		VERIFY_USER_MAIL_SUCCESS(state, data) {
			state.emailVerification.loading = false;
			state.emailVerification.finished = true;
			state.emailVerification.message = data.message;
			state.emailVerification.error = false;
		},
		VERIFY_USER_MAIL_FAILURE(state, data) {
			state.emailVerification.loading = false;
			state.emailVerification.finished = true;
			state.emailVerification.message = data.message;
			state.emailVerification.error = true;
		},
		FETCH_USER_SUCCESS(state, user) {
			state.user = user
			state.authenticated = true
		} 
	},
	getters: {
		authenticated: state => state.authenticated,
		user: state => state.user,
		emailVerification: state => state.emailVerification
	},
	actions: {
		async login({ commit }, data) {
			return new Promise((resolve, reject) => {
				commit("LOGIN", true);
			axios.post('api/login', { email : data.email , password: data.password})
				.then(({ data }) => {
					commit("LOGIN_SUCCESS", data);
					resolve(data);
				})
				.catch(error => {
					reject(error)
				})
			})
		},
		logout({commit}) {
	        return new Promise((resolve, reject) => {
	            commit("LOGOUT_SUCCESS")
	            localStorage.removeItem('vp-token')
	            localStorage.removeItem('vp-refresh-token')
	            // remove the axios default header
	            delete axios.defaults.headers.common['Authorization']
	            resolve()
	        })
   		},
		async checkUserExistence({ commit }, email) {
			return axios.get(`api/user/${email}`)
		},
		async register({ commit }, user) {
			commit("REGISTER");
			const response = axios.post(`api/register`, user)
			if (response.status === 200) {
				commit("REGISTER_SUCCESS", response.data);
			}
			if (response.status === 401) {
				commit("REGISTER_FAILURE", response.data)
			}
		},
		async verifyUserMail({ commit }, data) {
			commit("VERIFY_USER_MAIL");
			axios.post(`/api/email/verify/${data.userId}?expires=${data.expires}&hash=${data.hash}&signature=${data.signature}`, { })
				.then(response => {
					commit("VERIFY_USER_MAIL_SUCCESS", response.data);
				})
				.catch(error => {
					commit("VERIFY_USER_MAIL_FAILURE", error.response.data);
				});
		},
		async fetchUser({ commit }, data) {
			axios.get(`/api/user/`)
				.then(response => {
					commit("FETCH_USER_SUCCESS", response.data);
				})
				.catch(error => {
					commit("FETCH_USER_FAILURE", error.response.data);
				});
		},
	}
};

export default user;
