<template>
    <div>
        <div v-if="$page.props.flash.status === 'success'" class="p-flashMessage p-flashMessage--success">
            {{ $page.props.flash.message }}
        </div>
        <div v-if="$page.props.flash.status === 'error'" class="p-flashMessage p-flashMessage--error">
            {{ $page.props.flash.message }}
        </div>
    </div>
</template>
