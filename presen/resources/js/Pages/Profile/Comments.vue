
<template>
    <Head title="CommentedList"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">コメントしたプロジェクト一覧</h1>
        </template>

        <div class="c-siteView">
            <ProjectList :user="user" :projects="projects" />
        </div>
    </AuthenticatedLayout>

</template>

<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import ProjectList from "@/Components/ProjectList.vue";

defineProps([
    'user',
    'projects',
]);

</script>
