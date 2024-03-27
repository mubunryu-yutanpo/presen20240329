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
                <Link :href="`/chat/list/${user.id}`" class="c-text p-mypage__notification--link">
                    <i class="fa-regular fa-envelope faa-bounce animated c-icon p-mypage__notification--icon"></i>
                    新着のメッセージ
                </Link>
            </div>

            <!-- 投稿した案件の表示 -->
            <section class="c-section p-posted">
                <h2 class="c-title c-title--sub p-posted__title">
                    <i class="fa-solid fa-bullhorn c-icon"></i>
                    投稿した案件
                </h2>
                <p class="c-text--info">最新の5件まで表示されます</p>

                <div class="p-pjList">
                    <div class="c-box--project p-project" v-for="project in postedProjects" :key="project.id" v-if="postedProjects.length > 0">
                        <Link :href="project.detailUrl" class="c-link p-project__link">
                            <h3 class="c-title c-title--project p-project__title">{{ project.title }}</h3>
                        </Link>
                        <div class="p-project__thumbnail">
                            <img :src="project.thumbnail" alt="" class="p-project__thumbnail--item">
                        </div>
                        <div class="p-project__content">
                            <h4 class="p-project__content--title">内容:</h4>
                            <p class="p-project__content--text">{{ project.content }}</p>
                        </div>

                    </div>

                    <div v-else class="p-project__none">
                        <strong class="p-project__none--text">プロジェクトが存在しません</strong>
                    </div>

                </div>
            </section>

            <!-- 応募した案件 -->
            <section class="c-section p-applied">
                <h2 class="c-title c-title--sub p-applied__title">
                    <i class="fa-regular fa-handshake c-icon"></i>
                    応募した案件
                </h2>
                <p class="c-text--info">最新の5件まで表示されます</p>


                <div class="p-pjList">
                    <div class="c-box--project p-project" v-for="apply in appliedProjects" :key="apply.id" v-if="appliedProjects.length > 0">
                        <Link :href="apply.project.detailUrl" class="c-link p-project__link">
                            <h3 class="c-title c-title--project p-project__title">{{ apply.project.title }}</h3>
                        </Link>
                        <div class="p-project__thumbnail">
                            <img :src="apply.project.thumbnail" alt="" class="p-project__thumbnail--item">
                        </div>
                        <div class="p-project__content">
                            <h4 class="p-project__content--title">内容:</h4>
                            <p class="p-project__content--text">{{ apply.project.content }}</p>
                        </div>

                    </div>

                    <div v-else class="p-project__none">
                        <strong class="p-project__none--text">プロジェクトが存在しません</strong>
                    </div>
                </div>
            </section>

            <!-- 応募した案件 -->
            <section class="c-section p-commented">
                <h2 class="c-title c-title--sub p-commented__title">
                    <i class="fa-regular fa-comment-dots c-icon"></i>
                    コメントした案件
                </h2>
                <p class="c-text--info">最新の5件まで表示されます</p>


                <div class="p-pjList">
                    <div class="c-box--project p-project" v-for="comment in commentedProjects" :key="comment.id" v-if="commentedProjects.length > 0">
                        <Link :href="comment.project.detailUrl" class="c-link p-project__link">
                            <h3 class="c-title c-title--sub p-project__title">{{ comment.project.title }}</h3>
                        </Link>
                        <div class="p-project__thumbnail">
                            <img :src="comment.project.thumbnail" alt="" class="p-project__thumbnail--item">
                        </div>
                        <div class="p-project__content">
                            <h4 class="p-project__content--title">内容:</h4>
                            <p class="p-project__content--text">{{ comment.project.content }}</p>
                        </div>

                    </div>

                    <div v-else class="p-project__none">
                        <strong class="p-project__none--text">プロジェクトが存在しません</strong>
                    </div>
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
