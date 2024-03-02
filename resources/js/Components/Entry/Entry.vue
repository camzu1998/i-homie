<script>
export default {
    props: {
        title: {
            type: String,
            required: true,
        },
        description: {
            type: String,
            required: false,
        },
        room: {
            type: Object,
            required: false,
        },
        user: {
            type: Object,
            required: false,
        },
        date: {
            type: String,
            required: false,
        },
        status: {
            type: Boolean,
            required: false,
            default: null
        },
    },
    methods: {
        removeField(index) {
            this.fields.splice(index, 1);
        },
        addField() {
            this.fields.push({ value: '' });
        },
    },
};
</script>

<template>
    <div class="card mb-2">
        <div class="card-body">
            <div class="card-title" v-if="description">
                {{ title }}
            </div>
            <div class="card-text">
                {{ description ?? title }}
            </div>
            <a href="#" :class=" status ? 'btn btn-success' : 'btn btn-info'" v-if="status != null">{{ status ? 'Done!' : 'To do' }}</a>
        </div>
    </div>
</template>
