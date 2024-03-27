<template>
    <Head title="DMList"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">DM一覧</h1>
        </template>

        <div class="c-box--message p-wrap">

            <div class="c-box--dm p-dmList" v-for="chat in chats.data" :key="chat.id">

                <div class="c-box--user p-dmList__user">
                    <div class="c-box--image p-dmList__avatar">
                        <img :src="chat.partner.avatar" class="c-image p-dmList__avatar--image">
                    </div>
                    <p class="p-dmList__user--name">{{ chat.partner.name }}</p>
                </div>

                <div class="p-dmList__notification">
                    <p class="p-dmList__notification--unread" v-if="chat.unread">
                        <span class="p-dmList__notification--point">⚫︎</span>
                        新しいメッセージがあります
                    </p>

                    <!-- direct_messagesが存在し、かつ長さが0より大きい場合のみメッセージを表示 -->
                    <p class="p-dmList__notification--read" v-else-if="chat.direct_messages && chat.direct_messages.length > 0">
                        {{ chat.direct_messages[0].comment }}
                    </p>
                </div>

                <div class="c-box--link p-dmList__action">
                    <Link :href="`/chat/${chat.id}`" class="c-link p-dmList__link">メッセージを確認する</Link>
                </div>
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

