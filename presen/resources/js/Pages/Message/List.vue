<template>
    <Head title="DMList"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">DM一覧</h1>
        </template>

        <div class="c-box--message">

            <div class="c-box--dm p-directMessage" v-for="chat in chats.data" :key="chat.id">

                <div class="c-box--user p-directMessage__user">
                    <div class="p-directMessage__user--image">
                        <img :src="chat.partner.avatar" class="p-directMessage__user--image--item">
                    </div>
                    <p class="p-directMessage__user--name">{{ chat.partner.name }}</p>
                </div>

                <div class="p-directMessage__notification">
                    <p class="p-directMessage__notification--unread" v-if="chat.unread">新しいメッセージがあります</p>
<!--                    <p class="p-directMessage__notification&#45;&#45;read" v-else>{{ chat.direct_message[0].comment }}</p>-->
                </div>

                <Link :href="`/${chat.id}/${chat.partner.id}/${$page.props.auth.user.id}`">メッセージを確認する</Link>
            </div>
        </div>

        <!-- ページネーション部分 -->
        <Pagination
            :links="chats.links"
            :current-page="chats.current_page"
            :last-page="chats.last_page"
        />

    </AuthenticatedLayout>
</template>

<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

defineProps([
    'chats',
]);
</script>

