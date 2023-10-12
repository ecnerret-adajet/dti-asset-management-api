<script setup>
import { watch, reactive, onMounted, ref } from "vue";
import { router, Link, useForm } from "@inertiajs/vue3";
import { useToastr } from "../../Services/useToastr";
import { useSweetAlert } from "../../Services/useSweetAlert";

// api
import ReceivingStatusApi from "../../Api/ReceivingStatusApi";
import ReceivingApi from "../../Api/ReceivingApi";

const receivingStatusService = new ReceivingStatusApi();
const receivingService = new ReceivingApi();

const emit = defineEmits(["close", "onSuccess"]);

const props = defineProps({
  unique_id: String,
  title: String,
  asset: Object,
  asset_id: Number,
  show: { type: Boolean, default: false },
});

const errors = ref(null);
const receiving_statuses = ref([]);
const form = useForm({
  qty: null,
  receiving_status_id: null,
  remarks: null,
  asset_id: null,
});

const sweetAlert = useSweetAlert();
const toast = useToastr();

const handleSubmit = () => {
  form
    .transform((data) => ({
      ...data,
      asset_id: props.asset.id,
    }))
    .post("/receivings", {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
        closeModal();
        sweetAlert.basicAlert(
          "Submitted succesfully!",
          "Asset Request",
          "success"
        );
      },
    });
};

const fetchReceivingStatuses = () => {
  return receivingStatusService
    .list()
    .then((response) => {
      receiving_statuses.value = response;
    })
    .catch((error) => {
      errors.value = error;
    });
};

const closeModal = () => {
  emit("close", false);
  $(`#${props.unique_id}`).modal("hide");
};

const myChangeEvent = (val) => {
  console.log(val);
};

const mySelectEvent = ({ id, text }) => {
  console.log({ id, text });
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

onMounted(() => {
  fetchReceivingStatuses();
});
</script>
<template>
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
          <form id="receivingForm" class="form" @submit.prevent="handleSubmit">
            <!--begin::Body-->
            <div class="card-body">
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label"
                  >Receiving Status</label
                >
                <div class="col-lg-9 col-xl-9">
                  <select
                    v-model="form.receiving_status_id"
                    class="form-control form-control-lg form-control-solid"
                  >
                    <option value="null">Select Receiving Status</option>
                    <option
                      v-for="(rstatus, l) in receiving_statuses"
                      :key="l"
                      :value="rstatus.id"
                    >
                      {{ rstatus.name }}
                    </option>
                  </select>
                  <div class="fv-plugins-message-container"></div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Quantity</label>
                <div class="col-lg-9 col-xl-9">
                  <input
                    v-model="form.qty"
                    placeholder="0"
                    class="form-control form-control-lg form-control-solid"
                    type="number"
                  />
                  <div
                    v-if="form.errors.qty"
                    class="fv-plugins-message-container text-danger mt-3"
                  >
                    <div class="fv-help-block">
                      {{ form.errors.qty }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Remarks</label>
                <div class="col-lg-9 col-xl-9">
                  <input
                    v-model="form.remarks"
                    placeholder="Short Description"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                </div>
              </div>
            </div>
            <!--end::Body-->
          </form>
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
            @click="handleSubmit()"
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
