<template>
    <div class="mobile_header">
        <div class="header">
            <button class="header__burger" @click="expandMenu" />

            <a class="sidebar__logo" :href="this.url">
                <img class="sidebar__pic sidebar__pic_black" :src="getImage('images/peak_logo.svg')" alt="">
            </a>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "MobileHeader",

        computed: {
            ...mapGetters(['url', 'expand'])
        },

        methods: {
            expandMenu() {
                this.$root.expandMenu();
            },
            getImage(path) {
                return this.url + path;
            },
        }
    }
</script>
