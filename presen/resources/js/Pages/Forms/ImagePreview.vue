<template>
    <div class="p-preview">
        <label :for="inputId" class="c-label p-preview__label">{{ label }}</label>
        <div class="p-preview__container">
            <input :id="inputId" class="c-input p-preview__input" type="file" @change="handleFileChange" :name="name">
            <p class="p-preview__text" :class="{'off': imagePreview}">クリックして画像を選択</p>
            <div v-if="imagePreview" class="p-preview__image">
                <img :src="imagePreview" class="p-preview__image--item" />
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from 'vue';

const props = defineProps({
    label: String,
    inputId: String,
    name: String,
    imageName: String,
});

const emits = defineEmits(['file-selected']);

const imagePreview = ref(null);

onMounted(() => {
    // 親コンポーネントから渡されたthumbnail(avatar)がある場合、それをimagePreviewの初期値とする
    if (props.imageName) {
        imagePreview.value = props.imageName;
    }
});

function handleFileChange(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);

        // 親コンポーネントに選択されたファイルを通知
        emits('file-selected', file);
    }
}
</script>
