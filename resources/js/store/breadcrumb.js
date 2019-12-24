const breadcrumb = {
    state: {
        /*
            {
                index : 1,
                text : "Accueil",
                pathName : 'home',
                params : {}
            }
        */
        breadcrumbs: []
    },
    mutations: {
        PUSH_BREADCRUMB(state, data) {
            if (!(state.breadcrumbs.find(breadcrumb => breadcrumb.index == 2)) && data.index === 3) {
                let level2Breadcrumb = {
                    index: 2,
                    text: data.meta[0].primary_thematic.name,
                    pathName: 'thematic-products',
                    params: {
                        thematicSlug: data.meta[0].primary_thematic.slug
                    }
                }
                state.breadcrumbs.push(level2Breadcrumb)
                state.breadcrumbs.push(data)
            } else {
                if ((state.breadcrumbs.find(breadcrumb => breadcrumb.index == data.index))) {
                    state.breadcrumbs = state.breadcrumbs.map(breadcrumb => (breadcrumb.index == data.index) ? data : breadcrumb);
                } else {
                    state.breadcrumbs.push(data)
                }
            }
        },
        RESET_BREADCRUMB(state) {
            state.breadcrumb = []
        }
    },
    getters: {
        breadcrumbs: state => state.breadcrumbs
    },
    actions: {
        pushInBreadcrumb({ commit }, breadcrumb) {
            commit("PUSH_BREADCRUMB", breadcrumb);
        },
        resetBreadcrumb({ commit }) {
            commit("RESET_BREADCRUMB");
        }
    }
};

export default breadcrumb;
