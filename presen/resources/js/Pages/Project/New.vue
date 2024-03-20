<template>
    <Head title="NewProject"></Head>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">プロジェクト詳細</h1>
        </template>

        <form @submit.prevent="createProject" class="c-form p-create">

            <label for="title" class="c-label p-create__label">タイトル *</label>
            <input id="title" class="c-input p-create__input" type="text" name="title" required placeholder="255文字以内" v-model="form.title">
            <InputError :message="form.errors.title"></InputError>

            <label for="type">プロジェクトの種類 *</label>
            <select v-model="form.type" name="type" id="type" class="c-select p-create__select">
                <option value="" hidden>選択してください</option>
                <option v-for="type in types" :key="type.id" :value="type.id">{{ type.name }}</option>
            </select>
            <InputError :message="form.errors.type"></InputError>


            <label for="price" class="c-label p-create__label">料金 *</label>
            <input id="price" class="c-input p-create__input" type="number" name="price" required v-model="form.price">
            <InputError :message="form.errors.price"></InputError>


            <label for="content" class="c-label p-create__label">内容 *</label>
            <textarea
                id="content"
                class="c-textarea p-create__textarea"
                name="content"
                cols="30"
                rows="10"
                required
                placeholder="プロジェクトの内容を2,000文字以内で記入してください"
                v-model="form.content"></textarea>
            <!--     文字数カウンター       -->
            <div class="p-counter">
                <span :class="{'p-counter__text':true, 'over': form.content.length > 2000}">{{ form.content.length }}</span>
                / 2,000
            </div>
            <InputError :message="form.errors.content"></InputError>


            <ImagePreview label="サムネイル" inputId="thumbnail" name="thumbnail" @file-selected="handleFileChange"></ImagePreview>
            <InputError :message="form.errors.thumbnail"></InputError>


            <input class="c-submit p-create__submit" type="submit" value="登録する！">

        </form>

    </AuthenticatedLayout>
</template>

<script setup>
import {useForm, Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { ref } from 'vue';
import ImagePreview from "@/Pages/Forms/ImagePreview.vue";

defineProps(['types']);

const form = useForm({
    title: '',
    type: '',
    price: '',
    content: '',
});

const thumbnail = ref(null);

function handleFileChange(file) {
    thumbnail.value = file;
}

function createProject() {
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('type', form.type);
    formData.append('price', form.price);
    formData.append('content', form.content);

    if (thumbnail.value) {
        formData.append('thumbnail', thumbnail.value, thumbnail.value.name);
    }

    // routerを使う
    router.post(route('project.add'), formData, {
        forceFormData: true,
    });
}
</script>
