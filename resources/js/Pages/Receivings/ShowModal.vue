<script setup>
import { watch, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { useSweetAlert } from "../../Services/useSweetAlert";

const sweetAlert = useSweetAlert();

const baseUrl = window.location.origin;

const emit = defineEmits(["close", "submit"]);

const props = defineProps({
  unique_id: String,
  title: String,
  show: { type: Boolean, default: false },
  receiving: { type: Object, default: () => {} },
  receiving_statuses: { type: Object, default: () => [] },
});

const form = useForm({
  receiving_status_id: props.receiving.receiving_status_id,
});

const currencyFormatter = (amount) => {
  const currencyAmount = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "PHP", // Change to your desired currency code (e.g., 'EUR' for Euro)
  });
  return currencyAmount.format(amount);
};

watch(
  () => props.show,
  (newValue, oldValue) => {
    if (newValue === true) {
      $(`#${props.unique_id}`).modal({
        backdrop: "static",
        keyboard: false,
      });
    } else {
      $(`#${props.unique_id}`).modal("hide");
    }
  }
);

const closeModal = () => {
  emit("close", false);
  $(`#${props.unique_id}`).modal("hide");
};

const handleSubmit = () => {
  form.patch(`/receivings/status/${props.receiving.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      closeModal();
      emit("submit", false);
      sweetAlert.basicAlert("Succesfully updated!", "Asset Request", "success");
    },
  });
};

</script>
<template>
 <!-- Modal-->
  <div
    class="modal fade"
    :id="unique_id"
    data-backdrop="static"
    tabindex="-1"
    role="dialog"
    aria-labelledby="staticBackdrop"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
          <button
            @click="closeModal"
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group row">
            <label class="col-2 text-right col-form-label">Request Status</label>
            <div class="col-10">
              <select
                v-model="form.receiving_status_id"
                class="form-control form-control-lg form-control-solid"
              >
                <option
                  v-for="(status, l) in receiving_statuses"
                  :key="l"
                  :value="status.id"
                >
                  {{ status.name }}
                </option>
              </select>
              <div
                v-if="form.errors.receiving_status_id"
                class="fv-plugins-message-container text-danger mt-3"
              >
                <div class="fv-help-block">
                  {{ form.errors.receiving_status_id }}
                </div>
              </div>
              <span class="form-text text-muted"
                >Select the order status and click the "Submit" button to save
                changes.</span
              >
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            @click="closeModal"
            class="btn btn-light-primary font-weight-bold"
            data-dismiss="modal"
          >
            Close
          </button>
          <button
            type="button"
            @click="handleSubmit"
            :disabled="form.processing"
            class="btn btn-primary font-weight-bold"
          >
            Submit
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
