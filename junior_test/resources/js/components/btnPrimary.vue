<template>
    <button class="btn__primary" @click="clickButton">
        <span class="icon__plus" v-if="showIcon"></span>
        <span>{{sign}}</span>
    </button>
</template>

<script>
export default {
    name: "btnPrimary",
    props: {
        sign: "",
        showIcon: false
    },
    methods: {
        clickButton () {
            this.$emit("btnPrimaryClick");
        }
    }
}
</script>

