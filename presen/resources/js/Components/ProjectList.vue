<template>
    <div class="c-box--grid p-wrap">

        <div class="c-box--project p-project" v-for="project in projects.data" :key="project.id">
            <Link :href="`/project/detail/${project.id}`" class="c-link p-project__link">
                <h2 class="p-project__title">{{ project.title }}</h2>
            </Link>

            <div v-if="user !== ''" class="c-box--user p-project__user">
                <p class="c-text p-project__user--name">投稿者： {{ project.user.name }}</p>
                <div class="c-box--image p-project__user--image">
                    <img :src="project.user.avatar" alt="" class="c-image p-project__user--image--item">
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
import {Link} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

defineProps([
    'user',
    'projects',
]);
</script>
