<script setup>
import { watch, reactive, onMounted, ref } from "vue";
import { router, Link, useForm } from "@inertiajs/vue3";
import { useToastr } from "../../Services/useToastr";
import Select2 from "vue3-select2-component";

// api
import CustomersApi from "../../Api/CustomersApi";

const customersService = new CustomersApi();

const toast = useToastr();

const emit = defineEmits(["close", "onSuccess"]);

const props = defineProps({
  unique_id: String,
  title: String,
  asset: Object,
  show: { type: Boolean, default: false },
});

const errors = ref(null);
const customers = ref([]);
const form = useForm({
  name: null,
  remarks: null,
  customer_id: null,
});

const fetchCustomers = () => {
  return customersService
    .list()
    .then((response) => {
      customers.value = response.map(item => ({ id: item.id, text: item.name }));
    })
    .catch((error) => {
      errors.value = error;
    });
};

const closeModal = () => {
  emit("close", false);
  $(`#${props.unique_id}`).modal("hide");
};

const handleSubmit = () => {
  form.post("/locations", {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      closeModal();
      toast.notify("Created successfully");
    },
  });
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
  fetchCustomers();
});
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
          <form id="locationForm" class="form" @submit.prevent="handleSubmit">
            <!--begin::Body-->
            <div class="card-body">
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Sold To</label>
                <div class="col-lg-9 col-xl-9">
                  <Select2
                    v-model="form.customer_id"
                    :options="customers"
                    class="form-control select2" id="kt_select2_1"
                    :settings="{ width: '100%' }"
                    @change="myChangeEvent($event)"
                    @select="mySelectEvent($event)"
                  />
                  <div
                    v-if="form.errors.customer_id"
                    class="fv-plugins-message-container text-danger mt-3"
                  >
                    <div class="fv-help-block">
                      {{ form.errors.customer_id }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                <div class="col-lg-9 col-xl-9">
                  <input
                    v-model="form.name"
                    placeholder="Input Asset Name"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                  <div
                    v-if="form.errors.name"
                    class="fv-plugins-message-container text-danger mt-3"
                  >
                    <div class="fv-help-block">
                      {{ form.errors.name }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label"
                  >Description</label
                >
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
