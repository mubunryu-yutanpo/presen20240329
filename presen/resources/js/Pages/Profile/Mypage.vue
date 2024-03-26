<template>

    <Head title="Mypage"></Head>

    <AuthenticatedLayout>
        <!--  header  -->
        <template #header>
            <h1 class="c-title c-title--top">Mypage</h1>
        </template>

        <div class="p-mypage c-siteView">

            <div class="c-box--user p-mypage__user">
                <div class="c-box--image p-mypage__avatar">
                    <img :src="user.avatar" alt="" class="c-image p-mypage__avatar--image">
                </div>
                <p class="c-text p-mypage__name">{{ user.name }}さん</p>
            </div>

            <div v-if="unreadFlg" class="p-mypage__notification">
                <p class="c-text p-mypage__notification--text">新しいメッセージがあります</p>
            </div>

            <!-- 投稿した案件の表示 -->
            <section class="c-section p-posted">
                <h2 class="c-title c-title--sub p-posted__title">投稿した案件</h2>

                <div class="c-box--project p-project" v-for="project in postedProjects" :key="project.id">
                    <h3 class="c-title c-title--project p-project__title">{{ project.title }}</h3>
                    <div class="c-box--image p-project__image">
                        <img :src="project.thumbnail" alt="" class="c-image p-project__image--item">
                    </div>
                    <p class="c-text p-project__text">{{ project.content }}</p>
                    <Link :href="project.detailUrl" class="c-link p-project__link">このプロジェクトを見る</Link>
                </div>
            </section>

            <!-- 応募した案件 -->
            <section class="c-section p-applied">
                <h2 class="c-title c-title--sub p-applied__title">応募した案件</h2>

                <div class="c-box--project p-project" v-for="apply in appliedProjects" :key="apply.id">
                    <h3 class="c-title c-title--project p-project__title">{{ apply.project.title }}</h3>
                    <img :src="apply.project.thumbnail" alt="" class="c-image p-project__image">
                    <p class="c-text p-project__text">{{ apply.project.content }}</p>
                    <Link :href="apply.project.detailUrl" class="c-link p-project__link">このプロジェクトを見る</Link>
                </div>
            </section>

            <!-- 応募した案件 -->
            <section class="c-section p-commented">
                <h2 class="c-title c-title--sub p-commented__title">コメントした案件</h2>

                <div class="c-box--project p-project" v-for="comment in commentedProjects" :key="comment.id">
                    <h3 class="c-title c-title--comment p-commented__title">{{ comment.project.title }}</h3>
                    <img :src="comment.project.thumbnail" alt="" class="c-image p-project__image">
                    <p class="c-text p-project__text">{{ comment.project.content }}</p>
                    <Link :href="comment.project.detailUrl" class="c-link p-project__link">このプロジェクトを見る</Link>
                </div>
            </section>

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {Link} from "@inertiajs/vue3";


// Inertia.js から渡された props を受け取る
defineProps([
    'user',
    'postedProjects',
    'appliedProjects',
    'commentedProjects',
    'unreadFlg',
]);
</script>
