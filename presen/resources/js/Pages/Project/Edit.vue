<template>
    <Head title="EditProject"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="c-title c-title--top">プロジェクト編集</h1>
        </template>

        <div class="c-siteView">
            <form @submit.prevent="updateProject" class="c-form p-edit">

                <label for="title" class="c-label p-edit__label">タイトル *</label>
                <input id="title" class="c-input p-edit__input" type="text" name="title" required placeholder="255文字以内" v-model="form.title">
                <InputError :message="form.errors.title"></InputError>

                <label for="type">プロジェクトの種類 *</label>
                <select v-model="form.type" name="type" id="type" class="c-select p-edit__select" required>
                    <option value="" hidden>選択してください</option>
                    <option v-for="type in types" :key="type.id" :value="type.id">{{ type.name }}</option>
                </select>
                <InputError :message="form.errors.type"></InputError>


                <label for="price" class="c-label p-edit__label">料金 *</label>
                <input id="price" class="c-input p-edit__input" type="number" name="price" required v-model="form.price">
                <InputError :message="form.errors.price"></InputError>


                <label for="content" class="c-label p-edit__label">内容 *</label>
                <textarea
                    id="content"
                    class="c-textarea p-edit__textarea"
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


                <ImagePreview label="サムネイル" inputId="thumbnail" name="thumbnail" :imageName="props.project.thumbnail" @file-selected="handleFileChange"></ImagePreview>
                <InputError :message="form.errors.thumbnail"></InputError>


                <input class="c-submit p-edit__submit" type="submit" :disabled="form.processing" value="更新して保存">

            </form>

            <form class="c-form p-projectDelete" @submit.prevent="deleteProject">
                <input type="submit" value="削除する" class="c-submit p-projectDelete__submit">
            </form>

        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm, router} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import ImagePreview from "@/Pages/Forms/ImagePreview.vue";
import {ref} from "vue";

const props = defineProps({
    project : Object,
    types : Array,
});

const form = useForm({
    title: props.project.title || '',
    type: props.project.type_id || '',
    price: props.project.price || '',
    content: props.project.content || '',
    thumbnail: props.project.thumbnail || null,
});

const thumbnail = ref(null);

// サムネの画像プレビュー
function handleFileChange(file) {
    thumbnail.value = file;
}

// 更新処理
function updateProject() {
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('type', form.type);
    formData.append('price', form.price);
    formData.append('content', form.content);

    if (thumbnail.value) {
        formData.append('thumbnail', thumbnail.value, thumbnail.value.name);
    }

    router.post(route('project.update', { project_id: props.project.id }), formData, {
        forceFormData: true,
    });
}

// 削除処理
function deleteProject() {
    if (!confirm('この操作は取り消せません。削除しますか？')) {
        return;
    }
    router.post(route('project.delete', { project_id: props.project.id }));
}


</script>

