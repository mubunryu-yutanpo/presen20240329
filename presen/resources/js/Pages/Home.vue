<template>
    <Head title="HOME" />

    <div class="p-home">

        <div
            class="relative"
        >
            <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('mypage')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >マイページ</Link
                >

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >ログイン</Link
                    >

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >新規登録</Link
                    >
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
            <p class="p-about__title--sub">ABOUT</p>

            <div class="p-about__container c-box--flex c-box--flex-4">

                <div class="p-about__box c-box--flex c-box--flex-column">
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

                <div class="p-about__box c-box--flex c-box--flex-column">
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
            <p class="p-case__title--sub">PROJECTS</p>


            <div class="p-case__container">
                <!-- スライダー -->
                <swiper :options="swiperOptions">
                    <swiper-slide class="" v-for="project in projectList" :key="project.id" style="height:auto;">
                        <div class="p-project u-width--100">
                            <h3 class="p-project__title c-title">{{ project.title }}</h3>
                            <div class="p-project__image">
                                <img :src="project.thumbnail" class="p-project__image-item c-image">
                                <p class="p-project__type c-text--type">{{ project.type.name }}</p>
                            </div>
                            <p class="p-project__content c-text">{{ project.content}}</p>
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
import {Swiper, SwiperSlide} from "swiper/vue";
import 'swiper/css';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    projectList: Object,
});

</script>
