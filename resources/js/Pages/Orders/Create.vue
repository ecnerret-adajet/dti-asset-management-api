<script setup>
import InventoryLayout from "../../Layouts/InventoryLayout.vue";
import { ref, onMounted, computed } from "vue";
import { router, useForm } from "@inertiajs/vue3";

import { useSweetAlert } from "../../Services/useSweetAlert";
import { useToastr } from "../../Services/useToastr";
import VueMultiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";

const baseUrl = window.location.origin;

// api
import AssetsApi from "../../Api/AssetsApi";
import CustomersApi from "../../Api/CustomersApi";

const assetsService = new AssetsApi();
const customersService = new CustomersApi();

const sweetAlert = useSweetAlert();
const toast = useToastr();

const props = defineProps({
  order_statuses: Array,
});

const errors = ref(null);
const customers = ref([]);
const assets = ref([]);
const selected_customer_id = ref(0);
const selected_asset_item = ref(null);
const asset_orders = ref([]);

const fetchCustomers = () => {
  return customersService
    .list()
    .then((response) => {
      customers.value = response.map((item) => ({
        id: item.id,
        name: item.name,
      }));
    })
    .catch((error) => {
      errors.value = error;
    });
};

const fetchAssets = () => {
  return assetsService
    .list()
    .then((response) => {
      assets.value = response;
    })
    .catch((error) => {
      errors.value = error;
    });
};

const myChangeEvent = (val) => {
  console.log(val);
};

const mySelectEvent = ({ id, text }) => {
  console.log({ id, text });
};

const currencyFormatter = (amount) => {
  const currencyAmount = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "PHP", // Change to your desired currency code (e.g., 'EUR' for Euro)
  });
  return currencyAmount.format(amount);
};

// add asset to orders arry
const addOrder = () => {
  const isAlreadyAdded = asset_orders.value.some(
    (order) => order.id === selected_asset_item.value.id
  );
  if (isAlreadyAdded === false) {
    asset_orders.value.push(selected_asset_item.value);
    selected_asset_item.value = null;
    return toast.notify("Added successfully");
  } else {
    return toast.notify("Already been added");
  }
};

// remove order
const removeOrder = (index) => {
  asset_orders.value.splice(index, 1);
  toast.notify("Removed an order");
};

const updateQty = (mode, item) => {
  // check first if the current stock is less than the new qty
  if (mode == "add") {
    const checkStocks = asset_orders.value
      .filter((order) => order.id === item.id)
      .reduce((acc, item) => {
        return acc + item.qty;
      }, 0);

    const toBeQty = checkStocks + 1;
    if (toBeQty > item.current_value) {
      return toast.notify("Opps!, the current stock is less the the order qty");
    }
  }

  const filteredAssetOrder = asset_orders.value.map((order) => {
    if (order.id === item.id) {
      let total_qty =
        mode === "add" ? parseInt(order.qty) + 1 : parseInt(order.qty) - 1;
      return {
        ...order,
        qty: total_qty,
        unit_price_total: total_qty * parseFloat(order.unit_price),
      };
    }
    return order;
  });

  asset_orders.value = filteredAssetOrder;
};

const orderedItems = computed(() => {
  const getOrderedItems = asset_orders.value.map((order) => {
    return {
      ...order,
      unit_price_total: parseInt(order.qty) * parseFloat(order.unit_price),
    };
  });
  form.selected_orders = getOrderedItems;
  return getOrderedItems;
});

const subTotal = computed(() => {
  const getTotal = asset_orders.value
    .reduce((accumlator, item) => {
      return accumlator + item.unit_price * item.qty;
    }, 0)
    .toFixed(2);
    form.grand_total = getTotal;
    return getTotal;
});

const getTotalQtyOrders = computed(() => {
    return  asset_orders.value
    .reduce((accumlator, item) => {
        return accumlator + item.qty;
    }, 0);
})

const form = useForm({
  selected_customer: null,
  selected_orders: null,
  grand_total: null,
  total_qty_orders: null,
});

const storeOrder = () => {
  form
    .transform((data) => ({
        ...data,
        total_qty_orders: getTotalQtyOrders.value,
    }))
    .post("/orders", {
    onSuccess: () => {
      sweetAlert.basicAlert("Succesfully created!", "New Order", "success");
    },
  });
};

onMounted(() => {
  fetchCustomers();
  fetchAssets();
});
</script>
<template>
  <InventoryLayout>
    <!--begin::Layout-->
    <div class="flex-row-fluid ml-lg-8">
      <!--begin::Section-->
      <div class="card card-custom card-transparent">
        <div class="card-body p-0">
          <!--begin: Wizard-->
          <div
            class="wizard wizard-4"
            id="kt_wizard"
            data-wizard-state="step-first"
            data-wizard-clickable="false"
          >
            <!--begin: Wizard Nav-->
            <div class="wizard-nav">
              <div class="wizard-steps" data-total-steps="3">
                <!--begin::Wizard Step 1 Nav-->
                <div
                  class="wizard-step"
                  data-wizard-type="step"
                  data-wizard-state="current"
                >
                  <div class="wizard-wrapper">
                    <div class="wizard-number">1</div>
                    <div class="wizard-label">
                      <div class="wizard-title">Customer</div>
                      <div class="wizard-desc">Select Customer</div>
                    </div>
                  </div>
                </div>
                <!--end::Wizard Step 1 Nav-->
                <!--begin::Wizard Step 2 Nav-->
                <div class="wizard-step" data-wizard-type="step">
                  <div class="wizard-wrapper">
                    <div class="wizard-number">2</div>
                    <div class="wizard-label">
                      <div class="wizard-title">Orders</div>
                      <div class="wizard-desc">Manage orders</div>
                    </div>
                  </div>
                </div>
                <!--end::Wizard Step 2 Nav-->
                <!--begin::Wizard Step 3 Nav-->
                <div class="wizard-step" data-wizard-type="step">
                  <div class="wizard-wrapper">
                    <div class="wizard-number">3</div>
                    <div class="wizard-label">
                      <div class="wizard-title">Confirm</div>
                      <div class="wizard-desc">Review and Submit</div>
                    </div>
                  </div>
                </div>
                <!--end::Wizard Step 3 Nav-->
              </div>
            </div>
            <!--end: Wizard Nav-->
            <!--begin: Wizard Body-->
            <div class="card card-custom card-shadowless rounded-top-0">
              <div class="card-body p-0">
                <div
                  class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10"
                >
                  <div class="col-xl-12 col-xxl-7">
                    <!--begin: Wizard Form-->
                    <form
                      @submit.prevent="storeOrder()"
                      class="form mt-0 mt-lg-10"
                      id="kt_form"
                    >
                      <!--begin: Wizard Step 1-->
                      <div
                        class="pb-5"
                        data-wizard-type="step-content"
                        data-wizard-state="current"
                      >
                        <h4 class="mb-10 font-weight-bold text-dark">
                          Select from Customers
                        </h4>
                        <!--begin::Input-->
                        <div class="form-group">
                          <label>Customer Name</label>
                          <VueMultiselect
                            v-model="form.selected_customer"
                            :options="customers"
                            :close-on-select="true"
                            :clear-on-select="false"
                            placeholder="Search customer"
                            label="name"
                            track-by="name"
                          />
                          <span class="form-text text-muted"
                            >Please select a customer.</span
                          >
                        </div>
                        <!--end::Input-->
                      </div>
                      <!--end: Wizard Step 1-->
                      <!--begin: Wizard Step 2-->
                      <div class="pb-5" data-wizard-type="step-content">
                        <h4 class="mb-10 font-weight-bold text-dark">
                          Add orders from assets
                        </h4>

                        <!-- <div class="row">
                            <div class="col-xl-12">
                                <DropdownSearch :options="customers" />
                            </div>
                         </div> -->

                        <div class="row">
                          <div class="col-xl-12">
                            <!--begin::Input-->
                            <div class="form-group">
                              <label>Select Asset</label>
                              <!-- <input
                                type="text"
                                class="form-control form-control-solid form-control-lg"
                                name="ccname"
                                placeholder="Card Name"
                                value="John Wick"
                              /> -->
                              <div class="d-flex justify-content-between">
                                <VueMultiselect
                                  v-model="selected_asset_item"
                                  placeholder="Select Asset"
                                  label="title"
                                  track-by="title"
                                  :options="assets"
                                  :option-height="104"
                                  :show-labels="false"
                                />
                                <button
                                  @click="addOrder()"
                                  class="btn ml-3"
                                  type="button"
                                  :class="{
                                    '  btn-primary ':
                                      selected_asset_item != null,
                                    ' btn-secondary disabled ':
                                      selected_asset_item === null,
                                  }"
                                >
                                  Add
                                </button>
                              </div>

                              <span class="form-text text-muted"
                                >Please enter your Card Name.</span
                              >
                            </div>
                            <!--end::Input-->
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table">
                                <!--begin::Cart Header-->
                                <thead>
                                  <tr>
                                    <th>Ordered Items</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Price</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <!--end::Cart Header-->
                                <tbody>
                                  <!--begin::Cart Content-->
                                  <template v-if="asset_orders.length > 0">
                                    <tr
                                      v-for="(order, o) in asset_orders"
                                      :key="o"
                                    >
                                      <td
                                        class="d-flex align-items-center font-weight-bolder"
                                      >
                                        <!--begin::Symbol-->
                                        <div
                                          class="symbol symbol-60 flex-shrink-0 mr-4 bg-light"
                                        >
                                          <div
                                            class="symbol-label"
                                            :style="`
                                            background-image: url(${baseUrl}/${order.img});
                                          `"
                                          ></div>
                                        </div>
                                        <!--end::Symbol-->
                                        <a
                                          href="#"
                                          class="text-dark text-hover-primary"
                                          >{{ order.title }}</a
                                        >
                                      </td>
                                      <td class="text-center align-middle">
                                        <button
                                          type="button"
                                          @click="updateQty('deduct', order)"
                                          class="btn btn-xs btn-light-success btn-icon mr-2"
                                        >
                                          <i class="ki ki-minus icon-xs"></i>
                                        </button>
                                        <span class="mr-2 font-weight-bolder">{{
                                          order.qty
                                        }}</span>
                                        <button
                                          type="button"
                                          @click="updateQty('add', order)"
                                          class="btn btn-xs btn-light-success btn-icon"
                                        >
                                          <i class="ki ki-plus icon-xs"></i>
                                        </button>
                                      </td>
                                      <td
                                        class="text-right align-middle font-weight-bolder font-size-h5"
                                      >
                                        P {{ order.unit_price }}
                                      </td>
                                      <td class="text-right align-middle">
                                        <button
                                          type="button"
                                          @click="removeOrder(o)"
                                          class="btn btn-danger font-weight-bolder font-size-sm"
                                        >
                                          Remove
                                        </button>
                                      </td>
                                    </tr>
                                  </template>
                                  <tr v-if="asset_orders.length == 0">
                                    <td colspan="4" class="font-weight-bolder">
                                      <h3 class="text-muted text-center p-3">
                                        No order yet!
                                      </h3>
                                    </td>
                                  </tr>
                                  <!--end::Cart Content-->
                                  <!--begin::Cart Footer-->
                                  <tr v-if="asset_orders.length > 0">
                                    <td colspan="2"></td>
                                    <td
                                      class="font-weight-bolder font-size-h4 text-right"
                                    >
                                      Subtotal
                                    </td>
                                    <td
                                      class="font-weight-bolder font-size-h4 text-right"
                                    >
                                      {{ currencyFormatter(subTotal) }}
                                    </td>
                                  </tr>
                                  <!--end::Cart Footer-->
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--end: Wizard Step 2-->
                      <!--begin: Wizard Step 3-->
                      <div class="pb-5" data-wizard-type="step-content">
                        <!--begin::Section-->
                        <h4 class="mb-10 font-weight-bold text-dark">
                          Review your Order and Submit
                        </h4>
                        <h6 class="font-weight-bolder mb-3">To Deliver:</h6>
                        <div class="text-dark-50 line-height-lg">
                          <div>{{ form.selected_customer?.name }}</div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <!--end::Section-->
                        <!--begin::Section-->
                        <h6 class="font-weight-bolder mb-3">Order Details:</h6>
                        <div class="text-dark-50 line-height-lg">
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th
                                    class="pl-0 font-weight-bold text-muted text-uppercase"
                                  >
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
                                <template v-if="orderedItems.length > 0">
                                  <tr
                                    v-for="(order, o) in orderedItems"
                                    :key="`summary-${o}`"
                                    class="font-weight-boldest border-bottom-0"
                                  >
                                    <td
                                      class="border-0 pl-0 pt-7 d-flex align-items-center"
                                    >
                                      <!--begin::Symbol-->
                                      <div
                                        class="symbol symbol-40 flex-shrink-0 mr-4 bg-light"
                                      >
                                        <div
                                          class="symbol-label"
                                          :style="`background-image: url(${baseUrl}/${order.img})`"
                                        ></div>
                                      </div>
                                      <!--end::Symbol-->
                                      <a
                                        href="#"
                                        class="text-dark text-hover-primary"
                                        >{{ order.title }}</a
                                      >
                                    </td>
                                    <td
                                      class="border-0 text-right pt-7 align-middle"
                                    >
                                      {{ order.qty }}
                                    </td>
                                    <td
                                      class="border-0 text-right pt-7 align-middle"
                                    >
                                      P {{ order.unit_price }}
                                    </td>
                                    <td
                                      class="border-0 text-primary pr-0 pt-7 text-right align-middle"
                                    >
                                      P {{ order.unit_price_total }}
                                    </td>
                                  </tr>
                                </template>
                                <tr class="mt-3">
                                  <td colspan="2" class="border-0 pt-0"></td>
                                  <td
                                    class="border-0 pt-0 font-weight-bolder font-size-h5 text-right"
                                  >
                                    Grand Total
                                  </td>
                                  <td
                                    class="border-0 pt-0 font-weight-bolder font-size-h5 text-success text-right pr-0"
                                  >
                                    {{ currencyFormatter(subTotal) }}
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <!--end::Section-->
                        <!--begin::Section-->
                        <h6 class="font-weight-bolder mb-3">
                          Delivery Service Type:
                        </h6>
                        <div class="text-dark-50 line-height-lg">
                          <div>Overnight Delivery with Regular Packaging</div>
                          <div>
                            Preferred Morning (8:00AM - 11:00AM) Delivery
                          </div>
                        </div>
                        <!--end::Section-->
                      </div>
                      <!--end: Wizard Step 3-->
                      <!--begin: Wizard Actions-->
                      <div
                        class="d-flex justify-content-between border-top mt-5 pt-10"
                      >
                        <div class="mr-2">
                          <button
                            type="button"
                            class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4"
                            data-wizard-type="action-prev"
                          >
                            Previous
                          </button>
                        </div>
                        <div>
                          <button
                            type="button"
                            class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"
                            @click="storeOrder()"
                            data-wizard-type="action-submit"
                          >
                            Submit
                          </button>
                          <button
                            type="button"
                            class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                            data-wizard-type="action-next"
                          >
                            Next
                          </button>
                        </div>
                      </div>
                      <!--end: Wizard Actions-->
                    </form>
                    <!--end: Wizard Form-->
                  </div>
                </div>
              </div>
            </div>
            <!--end: Wizard Bpdy-->
          </div>
          <!--end: Wizard-->
        </div>
      </div>
      <!--end::Section-->
    </div>
    <!--end::Layout-->
  </InventoryLayout>
</template>
