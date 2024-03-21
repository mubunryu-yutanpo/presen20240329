<template>
    <nav class="p-paginate">
        <ul class="p-paginate__list">
            <!-- ページネーションリンクのループ開始 -->
            <li v-for="(link, index) in links" :key="index" :class="{'disabled': !link.url}" class="p-paginate__page">
                <!-- 最初と最後のページ時は「前」「次」は非表示 -->
                <template v-if="!(index === 0 && currentPage === 1) && !(index === links.length - 1 && currentPage === lastPage)">
                    <Link v-if="link.url" :href="link.url" class="p-paginate__page--link" v-html="link.label"></Link>
                    <span v-else class="p-paginate__page--text" v-html="link.label"></span>
                </template>
            </li>
        </ul>
    </nav>
</template>

<script setup>
import { defineProps } from 'vue';
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    links: Array,
    currentPage: Number,
    lastPage: Number,
});
</script>
