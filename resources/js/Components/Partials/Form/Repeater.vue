<script setup>
    import { BFormInput } from 'bootstrap-vue-next';
</script>

<script>
export default {
    props: {
        fields: {
            type: Array,
            required: true,
        },
        inputType: {
            type: String,
            default: 'text',
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
    <div class="w-100 d-flex flex-column">
        <div v-for="(field, index) in fields" :key="index" class="d-flex items-center mb-2">
                <BFormInput v-model="field.value" placeholder="Enter your homie nickname" :type="inputType" class="me-2"/>
                <button
                    @click="removeField(index)"
                    class="btn btn-outline-danger"
                >
                    <i class="fas fa-times-circle"></i>
                </button>
        </div>
        <div class="row justify-content-around">
            <button @click="addField" type="button" class="btn btn-outline-success">Add Field</button>
        </div>
    </div>
</template>
