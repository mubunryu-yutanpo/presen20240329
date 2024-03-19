<template>
    <Head title="ProjectDetail"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">プロジェクト詳細</h1>
        </template>

        <div class="c-siteView p-wrap">

            <!--      詳細      -->
            <div class="p-detail__detail">
                <h3 class="c-title c-title--project p-detail__title">{{ project.title }}</h3>

                <div class="c-box--image p-detail__thumbnail">
                    <img :src="project.thumbnail" alt="" class="c-image p-detail__image--item">
                </div>

                <h4 class="c-text p-detail__title--sub">【内容】</h4>
                <p class="c-text p-detail__text">{{ project.content }}</p>

                <p class="c-price p-detail__price">{{ project.price }}</p>
            </div>

            <!--      コメント      -->
            <div class="c-box--message p-publicMessage">
                <div class="p-publicMessage__container" v-for="message in messages" :key="message.id">

                    <div class="c-box--user p-publicMessage__user">
                        <p class="c-text--user p-publicMessage__user--name">{{ message.user.name }}</p>
                        <div class="c-box--image p-publicMessage__user--container">
                            <img :src="message.user.avatar" alt="" class="c-image p-publicMessage__user--image">
                        </div>
                    </div>

                    <div class="p-publicMessage__about">
                        <p class="c-text p-publicMessage__about--comment">{{ message.comment }}</p>
                    </div>
                </div>

                <CommentForm :projectId="project.id"></CommentForm>

            </div>

            <!--     応募もしくは編集       -->
            <p v-if="applyFlg" class="c-text">この案件にはすでに応募しています</p>

            <ApplyForm :projectId="project.id" v-else-if="user.id !== project.user.id"></ApplyForm>

            <div class="c-box--link p-detail__link" v-else>
                <Link :href="`/project/edit/${project.id}`" class="c-link p-detail__link--item">編集する</Link>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import CommentForm from "@/Pages/Forms/PublicMessageCommentForm.vue";
import ApplyForm from "@/Pages/Forms/ApplyForm.vue";


defineProps([
    'project',
    'user',
    'messages',
    'applyFlg',
]);
</script>
