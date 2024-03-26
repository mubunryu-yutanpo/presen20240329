<template>
    <form @submit.prevent="submitComment" class="c-form p-comment">
        <textarea id="message" v-model="form.message" placeholder="メッセージを入力してください" required class="c-textarea p-comment__textarea"></textarea>
        <InputError :message="form.errors.message"></InputError>
        <button type="submit" class="c-button p-comment__submit">
            <i class="fa-solid fa-paper-plane c-icon p-comment__icon"></i>
        </button>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    projectId : Number,
});

const form = useForm({
    message : '',
});

function submitComment() {
    form.post(route('publick_message.add', props.projectId));
}

</script>
