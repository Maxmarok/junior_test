<template>
    <div class="page__center wide">
        <div class="page__row page__row_head" v-if="!mobile">
            <div class="page__col col__header d-flex flex-column flex-sm-row justify-content-space-between">
                <div class="mt-4 mt-sm-0">
                    <div class="page__hello h5" v-if="user" v-html="user.name+','"/>
                    <div class="page__welcome h2">Привет 👋</div>
                </div>

                <div class="mt-4 mt-sm-0" v-if="items">
                    <p class="mb-2">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle class="color" cx="7" cy="7" r="6.5" fill="#7FBA7A"/>
                        </svg>

                        <span class="color-gray ml-2 align-middle">На продвижении</span>
                    </p>
                    <p>
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle class="color" cx="7" cy="7" r="6.5" fill="#FF4242"/>
                        </svg>

                        <span class="color-gray ml-2 align-middle">Есть заявки</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="page__row" v-if="mobile && items">
            <div class="d-flex flex-row align-items-center justify-content-between">
                <h1>Мои треки</h1>
                <img :src="url + 'img/icon_plus_main.svg'" @click="openMusicModal" class="mb-2" />
            </div>
        </div>

        <div class="page__row" v-if="mobile && items">
             <div class="page__panel">
                <p>
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle class="color" cx="6" cy="6" r="5.5" fill="#7FBA7A"/>
                    </svg>

                    <span>На продвижении</span>
                </p>
                <p>
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle class="color" cx="6" cy="6" r="5.5" fill="#FF4242"/>
                    </svg>

                    <span>Есть заявки</span>
                </p>
            </div>
        </div>

        
        <div v-if="items && items.length>0" class="page__row page__row_border">
            <div class="page__col">
                <div class="products__grid">
                    <div class="products__item" @click="openMusicModal" v-if="!mobile">
                        <div class="products__preview new"></div>
                        <div class="products__details">
                            <div class="products__title title">Добавить трек</div>
                        </div>
                    </div>
                    <songCard v-for="item in items" :author="item.author" :title="item.title" :image="item.image" :key="item.id" />
                </div>
            </div>
        </div>

        <div v-else class="page__col">
            <bannerFirstTrack  @btnPrimaryClick="openMusicModal"/>
        </div>

        <b-modal id="music-modal" centered hide-footer>
            <div class="modal-center d-flex flex-column text-center mx-auto">
                <div class="form-block">
                    <input type="text" class="form-control" placeholder="Ссылка на звук в TikTok" v-model="val" required="" />
                    <p class="form-tip text-danger" v-if="error" v-html="error" />
                    <button class="btn btn-lg btn-primary btn-block my-4" @click="getMusic(val)" :disabled="!val" v-if="!waiting" v-html="val ? 'Найти трек' : 'Введите ссылку на трек'" />
                    <div class="loading" :class="{active: waiting}" />
                    <p class="form-tip" v-if="waiting" v-html="'Ищем трек, это займет от 5 до 10 секунд'" />
                </div>
            </div>
        </b-modal>

        <b-modal id="song-modal" centered hide-footer>
            <div class="modal-center d-flex flex-column mx-auto">
                <div class="text-center">
                     <b-img :src="cover" rounded="circle" alt="Обложка альбома" width="132" height="132"></b-img>
                </div>
                <div class="form-block">
                    <b-form-group label="Ссылка на звук в TikTok" label-for="song-input" invalid-feedback="Ссылка не указана" label-class="song__label">
                        <input id="song-input" type="text" class="form-control song__input" placeholder="Ссылка на звук в TikTok" v-model="val" required="" />
                    </b-form-group>    
                    <b-form-group label="Название" label-for="title-input" invalid-feedback="Название не указано" label-class="song__label">
                        <input id="title-input" type="text" class="form-control song__input" placeholder="Название" v-model="titleSong" required="" />
                    </b-form-group>     
                    <b-form-group label="Исполнитель" label-for="artist-input" invalid-feedback="Ссылка не указана" label-class="song__label">
                        <input id="artist-input" type="text" class="form-control song__input" placeholder="Исполнитель" v-model="author" required="" />
                    </b-form-group>       
                    <b-form-group label="Альбом" label-for="album-input" invalid-feedback="Ссылка не указана" label-class="song__label">
                        <input id="album-input" type="text" class="form-control song__input" placeholder="Альбом" v-model="album" required="" />
                    </b-form-group>      
                     <p class="form-tip text-danger" v-if="error" v-html="error" /> 
                    <button class="btn btn-lg btn-primary btn-block my-4" @click="addSong()" :disabled="!val" v-if="!waiting" v-html="'Добавить'" />
                    <div class="loading" :class="{active: waiting}" />
                    <p class="form-tip" v-if="waiting" v-html="'Добавляем трек, это займет от 5 до 10 секунд'" />
                </div>
            </div>
        </b-modal>

    </div>
</template>

<script>
    import axios from "axios";
    import {mapGetters} from "vuex";
    import { GET_MUSIC_LIST, GET_MUSIC, ADD_MUSIC } from '../api-routes';
    import bannerFirstTrack from "./bannerFirstTrack";
    import songCard from "./songCard";

    export default {
        components: {
            bannerFirstTrack,
            songCard
        },
        name: "Music",

        data() {
            return {
                editing: false,
                val: this.value,
                music: null,
                error: null,
                waiting: false,
                items: null,
                titleSong: "",
                author: "",
                album: "",
                cover: "/img/blankAvatar.png"             
            }
        },
        mounted() {
            this.getMusicList();
        },
        computed: {
            ...mapGetters(['user', 'userAuthorized', 'url', 'tablet', 'mobile']),
        },
        methods: {
            openMusicModal() {
                this.waiting = this.error = false;
                this.$bvModal.show('music-modal');
            },
            getMusicList() {
                axios.get(GET_MUSIC_LIST).then(response => {
                    this.items = response.data;
                });
            },
            addSong() {
                this.waiting = true;
                this.error = null;
                axios.post(ADD_MUSIC, {
                    url : this.val,
                    title : this.titleSong,
                    author : this.author,
                    album : this.album
                }).then(response => {
                    this.waiting = false;
                    this.$bvModal.hide('song-modal');
                    this.getMusicList();
                }).catch(error => {
                    console.log(error);
                    this.waiting = false;
                    if(error !== undefined) {
                        this.error = 'Не удалось добавить трек, попробуйте позже';
                    }
                });            
            },
            setSongParams(data) {
                const music = data.music;
                const artist = data.artist;
                if (music) {
                    this.titleSong = (music.title) ? music.title : "";
                    this.album = (music.album) ? music.album : "";
                    this.cover = (music.coverThumb) ? music.coverThumb : "/img/blankAvatar.png" ;
                    this.author = (music.authorName) ? music.authorName : "Исполнитель неизвестен" ;
                } else {
                   this.titleSong = "";
                   this.album = ""; 
                    this.authorName = "";
                    this.cover = "/img/blankAvatar.png";    
                };    
            },
            getMusic(url) {
                this.waiting = true;
                this.error = null;
                axios.post(GET_MUSIC, {url: url}).then(response => {
                    this.waiting = false;
                    this.song = response.data;
                    this.setSongParams(response.data);
                    this.$bvModal.hide('music-modal');
                    this.$bvModal.show('song-modal');
                    this.error = null;
                }).catch(error => {
                    console.log(error);
                    this.waiting = false;
                    if(error !== undefined) {
                        this.error = 'Не удалось найти трек, попробуйте еще раз';
                    }
                });
            }
        }
    }
</script>

<style scoped>
    .song__input {
        font-size: 16px;
        color: #808191;
        font-weight: 600;
    }

    .song__label {
         font-size: 13px;
        color: #B2B3BD;
        font-weight: 500;       
    }

    .title {
        font-weight: 600;
        font-size: 19px;
        line-height: 23px;
        color: #808191;
    }


    @media only screen and (min-width: 980px)  {
        .products__item {
            margin: 0 55px 20px 0;
            width: calc(50% - 80px);
        }
    }
</style>