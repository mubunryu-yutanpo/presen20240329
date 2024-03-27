<template>
    <Head title="ProjectDetail"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">プロジェクト詳細</h1>
        </template>

        <div class="c-siteView p-wrap">

            <div class="p-detail">

                <!--       シェア         -->
                <button class="c-button p-detail__share" @click="shareOnX">
                    <i class="fa-brands fa-x-twitter c-icon"></i>
                    シェアする
                </button>

                <h3 class="c-title c-title--project p-detail__title">{{ project.title }}</h3>

                <div class="c-box--image p-detail__thumbnail">
                    <img :src="project.thumbnail" alt="" class="c-image p-detail__thumbnail--item">
                </div>

                <h4 class="c-text p-detail__title--sub">【内容】</h4>
                <p class="c-text p-detail__content">{{ project.content }}</p>

                <h4 class="c-text p-detail__title--sub">【目安料金】</h4>
                <p class="c-price p-detail__price">{{ formattedPrice }} 円</p>


                <!--      コメント      -->
                <h4 class="c-text p-detail__title--sub">【コメント】</h4>
                <div class="c-box--message p-publicMessage">
                    <div class="p-publicMessage__container" v-for="message in messages" :key="message.id" v-if="messages.length > 0">

                        <div class="c-box--user p-publicMessage__user">
                            <p class="c-text--user p-publicMessage__user--name">{{ message.user.name }}</p>
                            <div class="c-box--image p-publicMessage__avatar">
                                <img :src="message.user.avatar" alt="" class="c-image p-publicMessage__avatar--image">
                            </div>
                        </div>

                        <div class="p-publicMessage__content">
                            <p class="c-text p-publicMessage__content--comment">{{ message.comment }}</p>
                        </div>
                    </div>

                    <div class="p-publicMessage__none" v-else>
                        <p class="c-text p-publicMessage__none--text">まだコメントはありません</p>
                    </div>
                </div>

                <CommentForm :projectId="project.id"></CommentForm>


                <!--     応募もしくは編集       -->
                <p v-if="applyFlg" class="c-text p-detail__applied">この案件にはすでに応募しています</p>

                <ApplyForm :projectId="project.id" v-else-if="user.id !== project.user.id"></ApplyForm>

                <div class="c-box--link p-detail__link" v-else>
                    <Link :href="`/project/edit/${project.id}`" class="c-link p-detail__link--item">編集する</Link>
                </div>

            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import CommentForm from "@/Pages/Forms/PublicMessageCommentForm.vue";
import ApplyForm from "@/Pages/Forms/ApplyForm.vue";
import {computed} from "vue";


const { project, user, messages, applyFlg } = defineProps({
    project: Object,
    user: Object,
    messages: Array,
    applyFlg: Boolean,
});

// 価格を3桁区切りに
const formattedPrice = computed(() => {
    return Number(project.price).toLocaleString('ja-JP');
});

// Xにシェアする
const shareOnX = () => {
    const xText = `プロジェクト名: 【 ${project.title} 】- match-マッチ-　IT技術のアウトソーシングをもっと気軽に！ぜひ試してみてね！`;
    const xUrl = `https://sonzaisinaikedone.com/project/detail/${project.id}`;
    const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(xText)}&url=${encodeURIComponent(xUrl)}`;
    window.open(twitterUrl, '_blank');
};

</script>
