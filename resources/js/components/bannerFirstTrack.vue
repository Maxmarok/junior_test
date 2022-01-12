<template>
    <!-- <div class="banner"> -->
        <div class="banner">
            <div class="banner__textWrap">
                <h2 class="banner__title banner__item">Загрузи свой <br/> первый трек</h2>
                <p class="banner__text banner__item">Твои будущие фанаты ждут! Жми <br/> на кнопку «добавить трек» и переходи<br/>к продвижению прямо сейчас.</p>
                <btnPrimary sign="Добавить трек" showIcon="true" @btnPrimaryClick="buttonClick"/>
            </div>
            <div class="banner__img"></div>
        </div>
        <!-- <div class="banner__right">
            <img src="/img/bannerPhoto.png" alt="Веселый человек с гитарой">
        </div>     -->
</template>

<script>
import btnPrimary from "./btnPrimary";

export default {
    name: "bannerFirstTrack.vue",
    components: {
        btnPrimary
    },
    methods: {
        buttonClick() {
            this.$emit("btnPrimaryClick");
        }
    }
}

</script>
