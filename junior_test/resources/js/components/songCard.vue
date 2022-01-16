<template>
    <div class="products__item">
        <div><img class="roundedImg" :src="image" alt="" width="63" height="63" /></div>
        <div class="products__details">
            <div class="song__author">{{author}}</div>
            <div class="song__title">{{title}}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: "btnPrimary",
    props: {
        author: {
            type: String,
            default: "Автор неизвестен",
        },
        title: {
            type: String,
            default: "",
        },
        image: {
            type: String,
            default: "",
        }
    }
}
</script>
