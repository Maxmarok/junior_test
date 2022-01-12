<template>

    <div class="page" :class="{toggle: this.expand}">
        <div class="sidebar left" :class="{active: this.expand}">
            <div class="sidebar__container">
                <div class="sidebar__top">
                    <button class="sidebar__close" />

                    <a class="sidebar__logo" :href="this.url">
                        <img class="sidebar__pic sidebar__pic_black" :src="getImage('images/peak_logo.svg')" alt="">
                    </a>

                    <button class="sidebar__burger" @click="expandMenu" />
                </div>
                <div class="sidebar__wrapper">
                    <div class="sidebar__inner">
                        <a class="sidebar__logo" href="//peak.promo">
                            <img class="sidebar__pic sidebar__pic_black" :src="getImage('images/peak_logo_mobile_dark.svg')" alt="">
                        </a>
                        <div class="sidebar__list">
                            <div class="sidebar__group">
                                <div class="sidebar__menu">
                                    <router-link :to="url + 'music'" v-on:click.native="closeMenu" active-class="active" class="sidebar__item">
                                        <div class="sidebar__icon">
                                            <img :src="getImage('images/tracks.svg')" class="icon" />
                                        </div>
                                        <div class="sidebar__text">Мои треки</div>
                                    </router-link>
                                </div>
                            </div>

                            <div class="sidebar__group">
                                <div class="sidebar__menu">
                                    <div class="sidebar__item" role="button" @click="openSettingsModal">
                                        <div class="sidebar__icon">
                                            <img :src="getImage('images/settings.svg')" class="icon" />
                                        </div>
                                        <div class="sidebar__text">Настройки</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page__wrapper">
            <mobile-header ref="mobileHeader" v-if="mobile" />

            <div @click="closeMenu">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>

    import {mapGetters} from "vuex";
    import MobileHeader from './MobileHeader.vue';

    export default {
        components: { MobileHeader },
        name: "App",

        mounted() {
            //this.$router.push({ name: 'music'})
        },

        methods: {
            closeMenu() {
                this.$root.closeMenu();
            },

            expandMenu() {
                this.$root.expandMenu();
            },

            getImage(path) {
                return this.url + path;
            },

            openSettingsModal() {
                this.$root.showSettingsModal();
            },
        },

        computed: {
            ...mapGetters(['user', 'tablet', 'mobile', 'url', 'expand']),
        }
    }
</script>
