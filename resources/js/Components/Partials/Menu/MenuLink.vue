<script setup>
const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    href: {
        type: String,
        required: false, // Adjust as needed
    },
    active: {
        type: String,
        required: false, // Adjust as needed
    },
    sidebar: {
        type: String,
        required: false, // Adjust as needed
        default: '',
    },
    icon: {
        type: String,
        required: false, // Adjust as needed
        default: '',
    }
});
</script>

<template>
    <li :class="'nav-item ' + props.sidebar">
        <a :class="'nav-link fs-5 ' + props.active" aria-current="page" :href=" props.href "><i :class="props.icon + ' fs-5 me-1 '"></i>{{ props.name }}</a>
    </li>
</template>
