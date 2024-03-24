<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    projectId: Number,
});

const form = useForm({});

function submitApply() {
    form.post(route('apply', { project_id: props.projectId }));
}
</script>

<template>
    <form @submit.prevent="submitApply" class="c-form p-apply">
        <button type="submit" class="c-submit p-apply__submit">応募する！</button>
    </form>
</template>
