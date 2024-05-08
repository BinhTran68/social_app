<script setup>
import { defineProps, ref } from 'vue';

const props = defineProps({
    show: Boolean,
    color: {
        type: String,
        default: 'success'
    },
    title: {
        type: String,
        default: 'Success'
    },
    text: {
        type: String,
        default: 'Updated successfully'
    },
    timeout: Number
});

const alert = ref({
    show: props.show,
    color: props.color,
    title: props.title,
    text: props.text,
    timeout: props.timeout
});

const showAlert = () => {
    alert.value.show = true;
    alert.value.timeout = setTimeout(() => {
        dismissAlert();
    }, 5000);
};

const dismissAlert = () => {
    alert.value.show = false;
    clearTimeout(alert.value.timeout);
    alert.value.timeout = null;
};
</script>

<template>
    <v-app>
        <v-container fluid>
            <v-alert v-if="alert.show"
                     :color="alert.color"
                     icon="$success"
                     :title="alert.title"
                     :text="alert.text">
                <template v-if="alert.timeout">
                    <v-btn text @click="dismissAlert">Dismiss</v-btn>
                </template>
            </v-alert>
        </v-container>
    </v-app>
</template>
