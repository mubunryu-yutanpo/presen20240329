<template>
    <Head title="HOME" />

    <div class="p-home">

        <div class="p-home__header">
            <div v-if="canLogin" class="p-homeHeader__container">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('mypage')"
                    class="c-link p-homeHeader__link"
                >マイページ</Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="c-link p-homeHeader__link"
                    >ログイン</Link
                    >

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="c-link p-homeHeader__link"
                    >新規登録</Link>
                </template>
            </div>
        </div>

        <!-- hero -->
        <section class="p-hero">
            <img src="images/hero.png" class="p-hero__image">
            <img src="images/hero_sp.png" class="p-hero__image--sp">
        </section>

        <!-- こんなお悩みありませんか的な部分 -->
        <section class="p-catch">
            <img src="images/catch_image.png" class="p-catch__image">
            <img src="images/catch_image_sp.png" class="p-catch__image--sp">
            <div class="p-catch__container">
                <p class="p-catch__text c-text">
                    <strong class="p-catch__text--big">「match」</strong>
                    はそんなお悩みに応えたサービスです。<br>
                </p>
                <p class="p-catch__text c-text">プロジェクトの依頼・応募などの手間を最小限にし、エンジニアのお仕事のお手伝いをします。</p>
            </div>
        </section>

        <!-- 説明の部分 -->
        <section class="p-about">
            <h2 class="p-about__title c-title">仕事の「欲しい」を気軽にやり取り</h2>
            <p class="p-about__title--sub">- ABOUT -</p>

            <div class="p-about__container">

                <div class="p-about__box">
                    <div class="p-about__image">
                        <img src="images/about_image01.png" class="p-about__image--item">
                        <div class="p-about__image--shadow"></div>
                    </div>
                    <div class="p-about__content">
                        <h3 class="p-about__content--title c-title">やり取りはメッセージで</h3>
                        <p class="p-about__content--text c-text">プロジェクトごとにコメントができ、気軽に気になる部分を聞けます。応募後はDMでやりとりを行います。</p>
                    </div>
                </div>

                <div class="p-about__box c-box--flex c-box--flex-column">
                    <div class="p-about__image">
                        <img src="images/about_image02.png" class="p-about__image--item">
                        <div class="p-about__image--shadow"></div>
                    </div>
                    <div class="p-about__content">
                        <h3 class="p-about__content--title c-title">「とりあえず」での応募OK</h3>
                        <p class="p-about__content--text c-text">面倒な手続きを省いてサクッと応募可能。「まずは話を聞いてみたい。」でも大丈夫!</p>
                    </div>
                </div>

                <div class="p-about__box">
                    <div class="p-about__image">
                        <img src="images/about_image03.png" class="p-about__image--item">
                        <div class="p-about__image--shadow"></div>
                    </div>
                    <div class="p-about__content">
                        <h3 class="p-about__content--title c-title">プロジェクトの投稿・依頼もカンタン</h3>
                        <p class="p-about__content--text c-text">技術者やビジネスパートナー「欲しい」なら依頼することも可能。最小限の情報入力で依頼を出せます。</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- 実績的な部分 -->
        <section class="p-case">
            <h2 class="p-case__title c-title">プロジェクトの一例</h2>
            <p class="p-case__title--sub">- PROJECTS -</p>


            <div class="p-case__container">
                <!-- スライダー -->
                <swiper :modules="[Navigation, Pagination, Virtual]"
                        navigation
                        :pagination="{ clickable: true }"
                        :breakpoints="breakpoints"
                >
                    <swiper-slide class="" v-for="project in projectList" :key="project.id" style="height:auto;">
                        <div class="c-box--project p-project">
                            <h2 class="p-project__title c-title">{{ project.title }}</h2>
                            <div class="p-project__thumbnail">
                                <img :src="project.thumbnail" class="p-project__thumbnail-item">
                            </div>
                            <p class="p-project__content p-project__content--mypage">{{ project.content}}</p>
                        </div>
                    </swiper-slide>
                </swiper>

            </div>

            <div class="p-case__box c-box--link">
                <a href="/list" class="c-link">すべてのプロジェクトを見る</a>
            </div>

        </section>

        <!-- クロージング -->
        <section class="p-action">
            <img src="images/action.png" class="p-action__image">
            <img src="images/action_sp.png" class="p-action__image--sp">
            <button class="p-action__button c-button" @click="toRegister">
                プロジェクトに応募する!
            </button>
            <p class="p-action__text">無料の会員登録が必要です</p>
        </section>
    </div>
</template>

<script setup>
import {Head, Link} from "@inertiajs/vue3";
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { Navigation, Pagination, Virtual } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import {ref} from "vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    projectList: Array,
});

const breakpoints = ref({
    // 640px以下の幅では1つのスライドを表示
    479: {
        slidesPerView: 1,
        spaceBetween: 30,
    },
    // 768px以下の幅では2つのスライドを表示
    767: {
        slidesPerView: 2,
        spaceBetween: 30,
    },
    // 1024px以下の幅では3つのスライドを表示
    1000: {
        slidesPerView: 3,
        spaceBetween: 25,
    },
});

// アクションボタンのクリック時
function toRegister() {
    window.location.href = '/login';
}

</script>
