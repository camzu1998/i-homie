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
});
</script>

<template>
    <li class="nav-item">
        <a class="nav-link {{ props.active }}" aria-current="page" :href=" props.href ">{{ props.name }}</a>
    </li>
</template>
