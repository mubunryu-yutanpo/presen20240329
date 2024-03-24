<template>
    <Head title="MessageChat" />
    <AuthenticatedLayout>

        <template #header>
            <h1 class="c-title c-title--top">DM詳細</h1>
        </template>

        <div class="c-box--message p-wrap">

            <div v-for="message in messages" :key="message.id" class="p-directMessage" :class="{'mine' : message.user.id === user_id}">

                <div class="c-box--user p-directMessage__user">
                    <div class="c-box--image p-directMessage__avatar">
                        <img :src="message.user.avatar" alt="" class="c-image p-directMessage__avatar--image">
                    </div>
                    <p class="p-directMessage__user--name">{{ message.user.name }}</p>
                </div>

                <div class="p-directMessage__comment">
                    <p class="p-directMessage__comment--text">{{ message.comment }}</p>
                </div>
            </div>

            <DirectMessgeCommentForm :chatId="chat.id" :user1Id="chat.user1_id" :user2Id="chat.user2_id"/>

        </div>
    </AuthenticatedLayout>

</template>

<script setup>

import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DirectMessgeCommentForm from "@/Pages/Forms/DirectMessgeCommentForm.vue";

defineProps([
    'messages',
    'user_id',
    'chat'
]);

</script>

