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
const isSubmitting = ref(false);
const showCustomerModal = ref(false);
const isCreatingCustomer = ref(false);

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

const customLabel = (option) => {
  let label = option.title;
  if (option.serial_number) {
    label += ` - SN: ${option.serial_number}`;
  }
  if (option.part_number) {
    label += ` - PN: ${option.part_number}`;
  }
  return label;
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

const setMinQty = (item) => {
  const filteredAssetOrder = asset_orders.value.map((order) => {
    if (order.id === item.id) {
      return {
        ...order,
        qty: 1,
        unit_price_total: 1 * parseFloat(order.unit_price),
      };
    }
    return order;
  });
  asset_orders.value = filteredAssetOrder;
  toast.notify("Quantity set to minimum (1)");
};

const setMaxQty = (item) => {
  // Determine the max available quantity
  const maxAvailable = item.max_qty && item.max_qty < item.current_value
    ? item.max_qty
    : item.current_value;

  const filteredAssetOrder = asset_orders.value.map((order) => {
    if (order.id === item.id) {
      return {
        ...order,
        qty: maxAvailable,
        unit_price_total: maxAvailable * parseFloat(order.unit_price),
      };
    }
    return order;
  });
  asset_orders.value = filteredAssetOrder;
  toast.notify(`Quantity set to maximum (${maxAvailable})`);
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

// Handle direct input changes on quantity field
const handleQtyInput = (order) => {
  // Determine the max available quantity
  const maxAvailable = order.max_qty && order.max_qty < order.current_value
    ? order.max_qty
    : order.current_value;

  // Parse the quantity as a number
  let qty = parseInt(order.qty);

  // If not a valid number, set to 1
  if (isNaN(qty) || qty < 1) {
    order.qty = 1;
    toast.notify("Quantity must be at least 1");
  }
  // If entered qty exceeds available stock
  else if (qty > maxAvailable) {
    order.qty = maxAvailable;
    toast.notify("Opps!, the current stock is less than the order qty");
  } else {
    order.qty = qty;
  }

  // Update the total price
  order.unit_price_total = order.qty * parseFloat(order.unit_price);
};

// Handle blur event to ensure final validation
const handleQtyBlur = (order) => {
  // Determine the max available quantity
  const maxAvailable = order.max_qty && order.max_qty < order.current_value
    ? order.max_qty
    : order.current_value;

  // Parse the quantity as a number
  let qty = parseInt(order.qty);

  // If not a valid number, set to 1
  if (isNaN(qty) || qty < 1) {
    order.qty = 1;
    toast.notify("Quantity must be at least 1");
  }
  // If entered qty exceeds available stock
  else if (qty > maxAvailable) {
    order.qty = maxAvailable;
    toast.notify("Opps!, the current stock is less than the order qty");
  } else {
    order.qty = qty;
  }

  // Update the total price
  order.unit_price_total = order.qty * parseFloat(order.unit_price);
};

const form = useForm({
  selected_customer: null,
  selected_orders: null,
  grand_total: null,
  total_qty_orders: null,
  reference: null,
});

const customerForm = ref({
  name: '',
  email: '',
  phone_number: '',
  address: '',
  representative_name: '',
});

const customerFormErrors = ref({
  name: '',
  email: '',
  phone_number: '',
});

const openCustomerModal = () => {
  showCustomerModal.value = true;
  customerForm.value = {
    name: '',
    email: '',
    phone_number: '',
    address: '',
    representative_name: '',
  };
  customerFormErrors.value = {
    name: '',
    email: '',
    phone_number: '',
  };
};

const closeCustomerModal = () => {
  showCustomerModal.value = false;
};

const createCustomer = () => {
  // Reset errors
  customerFormErrors.value = {
    name: '',
    email: '',
    phone_number: '',
  };

  // Validate required fields
  let hasError = false;
  if (!customerForm.value.name) {
    customerFormErrors.value.name = 'Customer name is required';
    hasError = true;
  }
  if (!customerForm.value.email) {
    customerFormErrors.value.email = 'Email is required';
    hasError = true;
  }
  if (!customerForm.value.phone_number) {
    customerFormErrors.value.phone_number = 'Phone number is required';
    hasError = true;
  }

  if (hasError) {
    return;
  }

  isCreatingCustomer.value = true;
  customersService
    .store(customerForm.value)
    .then((response) => {
      if (response.status && response.status >= 400) {
        // Handle validation errors from backend
        if (response.data && response.data.errors) {
          customerFormErrors.value = {
            name: response.data.errors.name ? response.data.errors.name[0] : '',
            email: response.data.errors.email ? response.data.errors.email[0] : '',
            phone_number: response.data.errors.phone_number ? response.data.errors.phone_number[0] : '',
          };
        }
        toast.notify('Failed to create customer', 'error');
      } else {
        // Success - add to customers list and select it
        const newCustomer = {
          id: response.id,
          name: response.name,
        };
        customers.value.push(newCustomer);
        form.selected_customer = newCustomer;
        closeCustomerModal();
        toast.notify('Customer created successfully');
      }
    })
    .catch((error) => {
      toast.notify('Failed to create customer', 'error');
      console.error(error);
    })
    .finally(() => {
      isCreatingCustomer.value = false;
    });
};

const storeOrder = () => {
  isSubmitting.value = true;
  form
    .transform((data) => ({
        ...data,
        total_qty_orders: getTotalQtyOrders.value,
    }))
    .post("/orders", {
    onSuccess: () => {
      sweetAlert.basicAlert("Succesfully created!", "New Order", "success");
      isSubmitting.value = false;
    },
    onError: () => {
      isSubmitting.value = false;
    },
    onFinish: () => {
      isSubmitting.value = false;
    }
  });
};

// Initialize the wizard component
const initWizard = () => {
  if (typeof KTWizard !== 'undefined') {
    const wizardEl = document.getElementById('kt_wizard');
    const formEl = document.getElementById('kt_form');
    
    if (wizardEl) {
      // Initialize the wizard
      const wizard = new KTWizard(wizardEl, {
        startStep: 1,
        clickableSteps: false
      });

      // Handle next button clicks manually to ensure proper step progression
      const nextButtons = wizardEl.querySelectorAll('[data-wizard-type="action-next"]');
      if (nextButtons.length > 0) {
        nextButtons.forEach(button => {
          button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const currentStep = wizard.getStep();
            
            // Validate current step
            if (currentStep === 1 && !form.selected_customer) {
              toast.notify('Please select a customer before proceeding', 'error');
              return false;
            } else if (currentStep === 2 && asset_orders.value.length === 0) {
              toast.notify('Please add at least one item to your order', 'error');
              return false;
            }
            
            // Move to the next step (explicitly go to step + 1)
            wizard.goTo(currentStep + 1);
          });
        });
      }
      
      // Handle previous button clicks
      const prevButtons = wizardEl.querySelectorAll('[data-wizard-type="action-prev"]');
      if (prevButtons.length > 0) {
        prevButtons.forEach(button => {
          button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const currentStep = wizard.getStep();
            wizard.goTo(currentStep - 1);
          });
        });
      }
    }
  }
};

onMounted(() => {
  fetchCustomers();
  fetchAssets();
  
  // Initialize wizard after a short delay to ensure DOM is fully loaded
  setTimeout(() => {
    initWizard();
  }, 100);
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
                        <div class="d-flex justify-content-between align-items-center mb-10">
                          <h4 class="font-weight-bold text-dark mb-0">
                            Select from Customers
                          </h4>
                          <button
                            type="button"
                            @click="openCustomerModal()"
                            class="btn btn-sm btn-light-primary font-weight-bold"
                          >
                            <i class="ki ki-plus icon-sm"></i>
                            Add New Customer
                          </button>
                        </div>
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
                              <label>Reference</label>
                              <input
                                v-model="form.reference"
                                type="text"
                                class="form-control form-control-solid form-control-lg"
                                placeholder="Enter reference"
                              />
                              <span class="form-text text-muted"
                                >Optional reference for this order.</span
                              >
                            </div>
                            <!--end::Input-->
                          </div>
                        </div>

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
                                  track-by="id"
                                  :options="assets"
                                  :option-height="104"
                                  :show-labels="false"
                                  :custom-label="customLabel"
                                >
                                  <template v-slot:option="props">
                                    <div>
                                      <span class="font-weight-bold">{{ props.option.title }}</span>
                                      <div class="small font-weight-bold">
                                        <span v-if="props.option.serial_number">SN: {{ props.option.serial_number }}</span>
                                        <span v-if="props.option.part_number" class="ml-2">PN: {{ props.option.part_number }}</span>
                                      </div>
                                    </div>
                                  </template>
                                  <template v-slot:singleLabel="props">
                                    <div>
                                      <span class="font-weight-bold">{{ props.option.title }}</span>
                                      <span class="small font-weight-bold ml-2">
                                        <span v-if="props.option.serial_number">SN: {{ props.option.serial_number }}</span>
                                        <span v-if="props.option.part_number" class="ml-2">PN: {{ props.option.part_number }}</span>
                                      </span>
                                    </div>
                                  </template>
                                </VueMultiselect>
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

                              <!-- <span class="form-text text-muted"
                                >Please enter your Card Name.</span
                              > -->
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
                                    <th class="text-left">Price</th>
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
                                        <div>
                                          <a
                                            href="#"
                                            class="text-dark text-hover-primary d-block"
                                            >{{ order.title }}</a
                                          >
                                          <div class="text-muted font-size-sm font-weight-normal">
                                            <span v-if="order.serial_number">SN: {{ order.serial_number }}</span>
                                            <span v-if="order.serial_number && order.part_number"> | </span>
                                            <span v-if="order.part_number">PN: {{ order.part_number }}</span>
                                          </div>
                                        </div>
                                      </td>
                                      <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                          <button
                                            type="button"
                                            @click="setMinQty(order)"
                                            class="btn btn-xs btn-light-info btn-icon"
                                            title="Set to minimum (1)"
                                          >
                                            <i class="flaticon2-fast-back icon-xs"></i>
                                          </button>
                                          <button
                                            type="button"
                                            @click="updateQty('deduct', order)"
                                            class="btn btn-xs btn-light-success btn-icon ml-1"
                                            title="Decrease quantity"
                                          >
                                            <i class="ki ki-minus icon-xs"></i>
                                          </button>

                                          <input
                                            v-model.number="order.qty"
                                            @input="handleQtyInput(order)"
                                            @blur="handleQtyBlur(order)"
                                            class="form-control form-control-solid text-center mx-2"
                                            style="min-width: 80px; max-width: 100px;"
                                            type="number"
                                            min="1"
                                            :max="order.max_qty && order.max_qty < order.current_value ? order.max_qty : order.current_value"
                                          />

                                          <button
                                            type="button"
                                            @click="updateQty('add', order)"
                                            class="btn btn-xs btn-light-success btn-icon"
                                            title="Increase quantity"
                                          >
                                            <i class="ki ki-plus icon-xs"></i>
                                          </button>
                                          <button
                                            type="button"
                                            @click="setMaxQty(order)"
                                            class="btn btn-xs btn-light-info btn-icon ml-1"
                                            title="Set to maximum available"
                                          >
                                            <i class="flaticon2-fast-next icon-xs"></i>
                                          </button>
                                        </div>
                                      </td>
                                      <td
                                        width="15%"
                                        class="text-right align-middle font-weight-bolder font-size-h5"
                                      >
                                        <!-- P {{ order.unit_price }} -->
                                        <input
                                            v-model="order.unit_price"
                                            class="form-control form-control-solid"
                                            type="number"
                                        />
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
                                      <div>
                                        <a
                                          href="#"
                                          class="text-dark text-hover-primary d-block"
                                          >{{ order.title }}</a
                                        >
                                        <div class="text-muted font-size-sm font-weight-normal">
                                          <span v-if="order.serial_number">SN: {{ order.serial_number }}</span>
                                          <span v-if="order.serial_number && order.part_number"> | </span>
                                          <span v-if="order.part_number">PN: {{ order.part_number }}</span>
                                        </div>
                                      </div>
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
                            :disabled="isSubmitting"
                          >
                            <span v-if="isSubmitting" class="spinner spinner-white mr-2"></span>
                            {{ isSubmitting ? 'Submitting...' : 'Submit' }}
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

    <!-- Quick Add Customer Modal -->
    <div v-if="showCustomerModal" class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold">Add New Customer</h5>
            <button type="button" class="close" @click="closeCustomerModal()">
              <i aria-hidden="true" class="ki ki-close"></i>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createCustomer()">
              <div class="form-group">
                <label class="font-weight-bold">Customer Name <span class="text-danger">*</span></label>
                <input
                  v-model="customerForm.name"
                  type="text"
                  class="form-control"
                  :class="{'is-invalid': customerFormErrors.name}"
                  placeholder="Enter customer name"
                />
                <div v-if="customerFormErrors.name" class="invalid-feedback d-block">
                  {{ customerFormErrors.name }}
                </div>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                <input
                  v-model="customerForm.email"
                  type="email"
                  class="form-control"
                  :class="{'is-invalid': customerFormErrors.email}"
                  placeholder="Enter email address"
                />
                <div v-if="customerFormErrors.email" class="invalid-feedback d-block">
                  {{ customerFormErrors.email }}
                </div>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Phone Number <span class="text-danger">*</span></label>
                <input
                  v-model="customerForm.phone_number"
                  type="text"
                  class="form-control"
                  :class="{'is-invalid': customerFormErrors.phone_number}"
                  placeholder="Enter phone number"
                />
                <div v-if="customerFormErrors.phone_number" class="invalid-feedback d-block">
                  {{ customerFormErrors.phone_number }}
                </div>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Address</label>
                <input
                  v-model="customerForm.address"
                  type="text"
                  class="form-control"
                  placeholder="Enter address (optional)"
                />
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Representative Name</label>
                <input
                  v-model="customerForm.representative_name"
                  type="text"
                  class="form-control"
                  placeholder="Enter representative name (optional)"
                />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary font-weight-bold" @click="closeCustomerModal()">
              Cancel
            </button>
            <button
              type="button"
              class="btn btn-primary font-weight-bold"
              @click="createCustomer()"
              :disabled="isCreatingCustomer"
            >
              <span v-if="isCreatingCustomer" class="spinner spinner-white mr-2"></span>
              {{ isCreatingCustomer ? 'Creating...' : 'Create Customer' }}
            </button>
          </div>
        </div>
      </div>
    </div>

  </InventoryLayout>
</template>
