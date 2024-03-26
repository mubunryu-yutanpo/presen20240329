<template>
    <form @submit.prevent="submitComment" class="c-form p-messageForm">
        <textarea id="message" v-model="form.message" placeholder="メッセージを入力してください" required class="c-input p-messageForm__textarea"></textarea>
        <InputError :message="form.errors.message"></InputError>
        <button type="submit" class="c-button p-messageForm__submit">
            <i class="fa-solid fa-paper-plane c-icon p-messageForm__icon"></i>
        </button>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    chatId : Number,
    user1Id: Number,
    user2Id: Number,
});

const form = useForm({
    message : '',
});

function submitComment() {
    form.post(route('dm.add', {chat_id: props.chatId, user1_id: props.user1Id, user2_id: props.user2Id}));
}

</script>
