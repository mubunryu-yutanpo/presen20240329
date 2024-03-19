
<template>
    <Head title="ProjectList"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">プロジェクト一覧</h1>
        </template>

        <div class="c-box--grid p-wrap">

            <div class="c-box--project p-project" v-for="project in projects.data" :key="project.id">
                <Link :href="`/project/detail/${project.id}`" class="c-link p-project__link">
                    <h2 class="p-project__title">{{ project.title }}</h2>
                </Link>

                <div class="c-box--user p-project__user">
                    <p class="c-text p-project__user--name">投稿者： {{ project.user.name }}</p>
                    <div class="c-box--image p-project__user--image">
                        <img :src="project.thumbnail" alt="" class="c-image p-project__user--image--item">
                    </div>
                </div>

                <div class="p-project__content">
                    <h4 class="p-project__content--title">内容</h4>
                    <p class="p-project__content--text">{{ project.content }}</p>
                </div>

            </div>
        </div>

        <!--    pagination    -->
        <nav class="p-paginate">
            <ul class="p-paginate__list">
                <!-- ページネーションリンクのループ開始 -->
                <li v-for="(link, index) in projects.links" :key="index" :class="{'disabled': !link.url}" class="p-paginate__page">
                    <!-- 最初と最後のページ時は「前」「次」は非表示 -->
                    <template v-if="!(index === 0 && projects.current_page === 1) && !(index === projects.links.length - 1 && projects.current_page === projects.last_page)">
                        <Link v-if="link.url" :href="link.url" class="p-paginate__page--link" v-html="link.label"></Link>
                        <span v-else class="p-paginate__page--text" v-html="link.label"></span>
                    </template>
                </li>
            </ul>
        </nav>

    </AuthenticatedLayout>

</template>

<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";

defineProps([
    'projects',
]);

</script>
