require('./bootstrap');

import _ from 'lodash';
import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './components/App.vue'
import { router } from './router'
import store from './store/store'
import BootstrapVue from 'bootstrap-vue'
import VueResize from 'vue-resize';
import vClickOutside from 'v-click-outside'
import {SET_WIDTH, SET_EXPAND} from "./store/mutation-names";

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(VueResize);
Vue.use(vClickOutside);

new Vue({
    store,
    router: router,
    render: h => h(App),

    mounted() {
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
        })
    },

    methods: {
        onResize() {
            this.$store.commit(SET_WIDTH, window.innerWidth);
        },

        closeMenu() {
            this.$store.commit(SET_EXPAND, false);
        },
        expandMenu() {
            this.$store.commit(SET_EXPAND, !this.$store.getters.expand);
        },

        showSettingsModal() {
            this.$bvModal.show('settings-modal');
        },

        hideSettingsModal() {
            this.$bvModal.hide('settings-modal');
        },
    }
}).$mount('#app');
