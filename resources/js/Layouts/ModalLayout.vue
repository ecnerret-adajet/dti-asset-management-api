<script setup>
import { watch, ref } from "vue";

const emit = defineEmits(['close','submit']);

const props = defineProps({
    unique_id: String,
    title: String,
    show: { type: Boolean, default: false },
});


watch(
  () => props.show,
  (newValue, oldValue) => {
    if(newValue === true) {
        $(`#${props.unique_id}`).modal({
            backdrop: "static",
            keyboard: false
        });
        } else {
            $(`#${props.unique_id}`).modal("hide");
        }
  }
);

const closeModal = () => {
    emit('close', false);
    $(`#${props.unique_id}`).modal("hide");
};

const handleSubmit = () => {
    emit('submit', false);
    closeModal();
};

</script>
<template>
<!-- Modal-->
<div class="modal fade" :id="unique_id" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                <slot name="modal-body" />

            </div>
            <div class="modal-footer">
                <button type="button" @click="closeModal" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" @click="handleSubmit" class="btn btn-primary font-weight-bold">Submit</button>
            </div>
        </div>
    </div>
</div>
</template>
