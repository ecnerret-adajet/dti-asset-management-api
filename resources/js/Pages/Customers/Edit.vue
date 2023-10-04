<script setup>
import BasicLayout from "../../Layouts/BasicLayout.vue";
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
  customer: Object,
});

const form = useForm(props.customer);

const updateAsset = () => {
  form.patch(`/inventory/${props.asset.id}`);
};

</script>
<template>

</template>
