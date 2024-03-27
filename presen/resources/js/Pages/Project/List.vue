
<template>
    <Head title="ProjectList"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">プロジェクト一覧</h1>
        </template>

        <!-- ソート -->
        <div class="p-sort">
            <select v-model="sortOption" @change="fetchSortedProjects" class="c-select p-sort__select">
                <option value="newest">投稿日の新しい順</option>
                <option value="oldest">投稿日の古い順</option>
                <option value="information">タイプ：情報提供</option>
                <option value="project">タイプ：案件・依頼</option>
                <option value="recruit">タイプ：求人</option>
                <option value="service">タイプ：サービス提供</option>
                <option value="other">タイプ：その他</option>
            </select>
        </div>


        <ProjectList :projects="projects" />

    </AuthenticatedLayout>

</template>

<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import ProjectList from "@/Components/ProjectList.vue";
import {ref} from "vue";

defineProps([
    'projects',
]);

const sortOption = ref('newest');

// 並べ替えオプションが変更された時の処理
function fetchSortedProjects() {
    router.get(route('list', { sort: sortOption.value }), {}, { preserveState: true });
}

</script>
