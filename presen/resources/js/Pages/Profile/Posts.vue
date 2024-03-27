
<template>
    <Head title="PostList"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">投稿したプロジェクト</h1>
        </template>

        <div class="c-siteView">
            <ProjectList user="" :projects="projects" />
        </div>
    </AuthenticatedLayout>

</template>

<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import ProjectList from "@/Components/ProjectList.vue";

defineProps([
    'projects',
]);

</script>
