<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">プロフィール変更</h2>

            <p class="mt-1 text-sm text-gray-600">
                アカウント情報を更新したい場合は以下のフォームの項目を変更してください。
            </p>
        </header>

        <form @submit.prevent="updateProfile" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="アカウント名" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    メールアドレスが承認されていません。
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        承認メールを再送する
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    メールアドレス宛に承認用のメールを送信しました！
                </div>
            </div>

            <!-- アバター画像アップロード -->
            <div>
                <InputLabel for="avatar" value="Avatar" />

                <ImagePreview
                    :label="'Current Avatar'"
                    :inputId="'avatar'"
                    :name="'avatar'"
                    :imageName="form.avatar || user.avatar"
                    @file-selected="handleAvatarChange"
                />
                <InputError :message="form.errors.avatar" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage, router } from '@inertiajs/vue3';
import ImagePreview from "@/Pages/Forms/ImagePreview.vue";
import {ref} from "vue";

const props =defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    profile: Object,
});

const user = usePage().props.auth.user;

const avatar = ref(null);

const form = useForm({
    name: props.profile.name,
    email: props.profile.email,
});

// アバターのファイル選択時の処理
function handleAvatarChange(file) {
    // ファイルをフォームデータにセット
    form.avatar = file;
}

function updateProfile(){
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('email', form.email);
    formData.append('avatar', form.avatar);

    if (avatar.value) {
        formData.append('avatar', avatar.value, avatar.value.name);
    }

    router.post(route('profile.update'), formData, {
        forceFormData: true,
    });
}

</script>
