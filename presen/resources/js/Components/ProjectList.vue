<template>
    <div class="c-box--grid p-wrap p-wrap--project">

        <!-- ソート -->
        <select v-model="sortOption" @change="fetchSortedProjects" class="c-select p-sort">
            <option value="newest">投稿日の新しい順</option>
            <option value="oldest">投稿日の古い順</option>
            <option value="information">タイプ：情報提供</option>
            <option value="project">タイプ：案件・依頼</option>
            <option value="recruit">タイプ：求人</option>
            <option value="service">タイプ：サービス提供</option>
            <option value="other">タイプ：その他</option>
        </select>

        <template v-if="projects.data.length">
            <div class="c-box--project p-project" v-for="project in projects.data" :key="project.id">
                <Link :href="`/project/detail/${project.id}`" class="c-link p-project__link">
                    <h2 class="p-project__title">{{ project.title }}</h2>
                </Link>

                <div v-if="user !== ''" class="c-box--user p-project__user">
                    <p class="c-text p-project__user--name">投稿者： {{ project.user.name }}</p>
                    <div class="c-box--image p-project__avatar">
                        <img :src="project.user.avatar" alt="" class="c-image p-project__avatar--image">
                    </div>
                </div>

                <div class="p-project__thumbnail">
                    <img :src="project.thumbnail" class="p-project__thumbnail--item">
                </div>

                <div class="p-project__content">
                    <h4 class="p-project__content--title">内容</h4>
                    <p class="p-project__content--text">{{ project.content }}</p>
                </div>

            </div>
        </template>
        <div v-else class="p-project__none">
            <strong class="p-project__none--text">プロジェクトが存在しません</strong>
        </div>
    </div>

    <!-- ページネーション部分 -->
    <Pagination
        :links="projects.links"
        :current-page="projects.current_page"
        :last-page="projects.last_page"
    />

</template>

<style scoped>

</style>
<script setup>
import {Link, router} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import {ref} from "vue";

defineProps([
    'user',
    'projects',
]);

const sortOption = ref('newest');

// 並べ替えオプションが変更された時の処理
function fetchSortedProjects() {
    router.get(route('list', { sort: sortOption.value }), {}, { preserveState: true });
}
</script>
