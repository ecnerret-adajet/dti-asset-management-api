<script setup>
import { watch, reactive, onMounted, ref } from "vue";
import { router, Link, useForm } from "@inertiajs/vue3";
import { useToastr } from "../../Services/useToastr";
import { useSweetAlert } from "../../Services/useSweetAlert";

const emit = defineEmits(["close", "onSuccess"]);

const props = defineProps({
  unique_id: String,
  title: String,
  asset: Object,
  asset_id: Number,
  locations: Array,
  show: { type: Boolean, default: false },
});

const errors = ref(null);

const form = useForm({
  location_id: null,
});

const sweetAlert = useSweetAlert();
const toast = useToastr();

const handleSubmit = () => {
  form.patch(`/asset-location/${props.asset.id}`, {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
        closeModal();
        sweetAlert.basicAlert(
          "Updated succesfully!",
          "Change location",
          "success"
        );
      },
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
                  >Change Location</label
                >
                <div class="col-lg-9 col-xl-9">
                  <select
                    v-model="form.location_id"
                    class="form-control form-control-lg form-control-solid"
                  >
                    <option value="null">Select New Location</option>
                    <option
                      v-for="(location, l) in locations"
                      :key="l"
                      :value="location.id"
                    >
                      {{ location.name }}
                    </option>
                  </select>
                  <div class="fv-plugins-message-container"></div>
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
