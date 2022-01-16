import Vue from "vue";
import Vuex from 'vuex';
import state from './state';
import mutations from './mutations';

Vue.use(Vuex);

export default new Vuex.Store({
    state,
    mutations,
    getters: {
        user: (state, getters) => {
            return state.user;
        },
        tablet() {
            return state.windowWidth < 1300;
        },
        mobile() {
            return state.windowWidth < 767;
        },
        url() {
            return process.env.MIX_APP_PATH;
        },
        expand(state, getters) {
            return state.expand;
        },
    }
});
