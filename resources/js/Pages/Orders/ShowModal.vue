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
  order: { type: Object, default: () => {} },
  order_statuses: { type: Object, default: () => [] },
});

const form = useForm({
  order_status_id: props.order.order_status_id,
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
    //   form.defaults('order_status_id', props.order.order_status_id)
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
  form.patch(`/orders/status/${props.order.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      closeModal();
      emit("submit", false);
      sweetAlert.basicAlert("Succesfully updated!", "Order Status", "success");
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
          <!--begin::Section-->
          <h6 class="font-weight-bolder mb-3">To Deliver:</h6>
          <div class="text-dark-50 line-height-lg">
            <div>{{ order.customer?.name }}</div>
            <div>{{ order.customer?.address }}</div>
            <div>{{ order.customer?.phone_number }}</div>
          </div>
          <div class="separator separator-dashed my-5"></div>
          <!--end::Section-->
          <!--begin::Section-->
          <div class="text-dark-50 line-height-lg">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="pl-0 font-weight-bold text-muted text-uppercase">
                      Ordered Items
                    </th>
                    <th
                      class="text-right font-weight-bold text-muted text-uppercase"
                    >
                      Qty
                    </th>
                    <th
                      class="text-right font-weight-bold text-muted text-uppercase"
                    >
                      Unit Price
                    </th>
                    <th
                      class="text-right pr-0 font-weight-bold text-muted text-uppercase"
                    >
                      Amount
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(item, o) in order.assets"
                    :key="`summary-${o}`"
                    class="font-weight-boldest border-bottom-0"
                  >
                    <td class="border-0 pl-0 pt-7 d-flex align-items-center">
                      <!--begin::Symbol-->
                      <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
                        <div
                          class="symbol-label"
                          :style="`background-image: url(${baseUrl}/${item.image_path})`"
                        ></div>
                      </div>
                      <!--end::Symbol-->
                      <a href="#" class="text-dark text-hover-primary">{{
                        item.name
                      }}</a>
                    </td>
                    <td class="border-0 text-right pt-7 align-middle">
                      {{ item.pivot.qty }}
                    </td>
                    <td class="border-0 text-right pt-7 align-middle">
                      P {{ item.pivot.unit_price }}
                    </td>
                    <td class="border-0 text-right pt-7 align-middle">
                      P
                      {{
                        currencyFormatter(
                          item.pivot.qty * item.pivot.unit_price
                        )
                      }}
                    </td>
                  </tr>
                  <tr class="mt-3 border-top-1">
                    <td colspan="2" class="border-0 pt-0"></td>
                    <td
                      class="border-0 pt-0 font-weight-bolder font-size-h5 text-right"
                    >
                      Grand Total
                    </td>
                    <td
                      class="border-0 pt-0 font-weight-bolder font-size-h5 text-success text-right pr-0"
                    >
                      {{ currencyFormatter(order.total_cost) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="separator separator-dashed my-5"></div>
          <div class="form-group row">
            <label class="col-2 text-right col-form-label">Order Status</label>
            <div class="col-10">
              <select
                v-model="form.order_status_id"
                class="form-control form-control-lg form-control-solid"
              >
                <option
                  v-for="(status, l) in order_statuses"
                  :key="l"
                  :value="status.id"
                >
                  {{ status.name }}
                </option>
              </select>
              <div
                v-if="form.errors.order_status_id"
                class="fv-plugins-message-container text-danger mt-3"
              >
                <div class="fv-help-block">
                  {{ form.errors.order_status_id }}
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
