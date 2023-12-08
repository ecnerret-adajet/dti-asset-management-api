<script setup>
import InventoryLayout from "../../Layouts/InventoryLayout.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";

import { useSweetAlert } from "../../Services/useSweetAlert";
import VueMultiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";

const page = usePage();

const sweetAlert = useSweetAlert();

const roles = computed(() => page.props.auth.roles);

const props = defineProps({
  locations: Array,
  asset_types: Array,
  statuses: Array,
  suppliers: Array,
});

const form = useForm({
  image_path: null,
  name: null,
  description: null,
  location_id: null,
  asset_type_id: null,
  model: null,
  serial_number: null,
  purchase_date: null,
  current_value: null,
  manufacturer: null,
  unit_price: 0,
  import_price: 0,
  local_price: 0,
  status_id: 1,
  supplier_id: 1,
  storage_location: null,
  unit_price_currency: null,
  import_price_currency: null,
});

const selected_supplier = ref(null);
const previewImage = ref(null);

const storeAsset = () => {
  form
    .transform((data) => ({
      ...data,
      supplier_id: selected_supplier.value.id,
    }))
    .post("/inventory", {
      onSuccess: () => {
        sweetAlert.basicAlert("Created succesfully!", "New Asset", "success");
      },
    });
};

const previewFile = (event) => {
  const file = event.target.files[0];

  if (file) {
    const reader = new FileReader();

    reader.onload = (e) => {
      previewImage.value = e.target.result;
    };

    reader.readAsDataURL(file);
  } else {
    previewImage.value = null;
  }
};
</script>
<template>
  <InventoryLayout>
    <!--begin::Card-->
    <div class="card card-custom card-stretch">
      <!--begin::Header-->
      <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
          <h3 class="card-label font-weight-bolder text-dark">
            New Asset Entry
          </h3>
          <span class="text-muted font-weight-bold font-size-sm mt-1"
            >Inventory new record</span
          >
        </div>
        <div class="card-toolbar">
          <button
            type="submit"
            @click="storeAsset()"
            :disabled="form.processing"
            class="btn btn-success mr-2"
          >
            Submit
          </button>
          <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
      </div>
      <!--end::Header-->
      <!--begin::Form-->
      <form class="form" @submit.prevent="storeAsset">
        <!--begin::Body-->
        <div class="card-body">
          <div class="row">
            <label class="col-xl-3"></label>
            <div class="col-lg-9 col-xl-6">
              <h5 class="font-weight-bold mb-6">General Information</h5>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Image</label>
            <div class="col-lg-9 col-xl-6">
              <div
                class="image-input image-input-outline"
                id="kt_profile_avatar"
                style="
                  background-image: url(/assets/media/users/image-asset.jpeg);
                "
              >
                <div
                  class="image-input-wrapper"
                  :style="`background-image: url(${previewImage})`"
                ></div>
                <label
                  class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                  data-action="change"
                  data-toggle="tooltip"
                  title=""
                  data-original-title="Upload image"
                >
                  <i class="fa fa-pen icon-sm text-muted"></i>
                  <input
                    type="file"
                    name="profile_avatar"
                    @change="previewFile"
                    @input="form.image_path = $event.target.files[0]"
                    accept=".png, .jpg, .jpeg"
                  />
                  <input type="hidden" name="profile_avatar_remove" />
                </label>
                <span
                  class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                  data-action="cancel"
                  data-toggle="tooltip"
                  title="Cancel avatar"
                >
                  <i class="ki ki-bold-close icon-xs text-muted"></i>
                </span>
                <span
                  class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                  data-action="remove"
                  data-toggle="tooltip"
                  title="Remove avatar"
                >
                  <i class="ki ki-bold-close icon-xs text-muted"></i>
                </span>
              </div>
              <span class="form-text text-muted"
                >Allowed file types: png, jpg, jpeg.</span
              >
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Supplier</label>
            <div class="col-lg-9 col-xl-6">
              <VueMultiselect
                v-model="selected_supplier"
                :options="suppliers"
                :close-on-select="true"
                :clear-on-select="false"
                placeholder="Search supplier"
                label="name"
                track-by="name"
              />
              <div
                v-if="form.errors.supplier_id"
                class="fv-plugins-message-container text-danger mt-3"
              >
                <div class="fv-help-block">
                  {{ form.errors.supplier_id }}
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
            <div class="col-lg-9 col-xl-6">
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
            <label class="col-xl-3 col-lg-3 col-form-label">Description</label>
            <div class="col-lg-9 col-xl-6">
              <textarea
                v-model="form.description"
                class="form-control form-control-lg form-control-solid"
                id="exampleTextarea"
                rows="4"
                type="text"
                placeholder="Type product description"
              ></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Location</label>
            <div class="col-lg-9 col-xl-6">
              <select
                v-model="form.location_id"
                class="form-control form-control-lg form-control-solid"
              >
                <option value="">Select</option>
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
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label"
              >Storage Location</label
            >
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.storage_location"
                placeholder="Input Storage Location"
                class="form-control form-control-lg form-control-solid"
                type="text"
              />
              <div
                v-if="form.errors.storage_location"
                class="fv-plugins-message-container text-danger mt-3"
              >
                <div class="fv-help-block">
                  {{ form.errors.storage_location }}
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-xl-3"></label>
            <div class="col-lg-9 col-xl-6">
              <h5 class="font-weight-bold mt-10 mb-6">Product Details</h5>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Asset Type</label>
            <div class="col-lg-9 col-xl-6">
              <select
                v-model="form.asset_type_id"
                class="form-control form-control-lg form-control-solid"
              >
                <option value="">Select</option>
                <option
                  v-for="(assettype, a) in asset_types"
                  :key="a"
                  :value="assettype.id"
                >
                  {{ assettype.name }}
                </option>
              </select>
              <div class="fv-plugins-message-container"></div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Model</label>
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.model"
                placeholder="Input Model Name"
                class="form-control form-control-lg form-control-solid"
                type="text"
              />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label"
              >Serial Number</label
            >
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.serial_number"
                placeholder="Input Serial Number"
                class="form-control form-control-lg form-control-solid"
                type="text"
              />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Manufacturer</label>
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.manufacturer"
                placeholder="Input Manufacturer"
                class="form-control form-control-lg form-control-solid"
                type="text"
              />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label"
              >Purchase Date</label
            >
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.purchase_date"
                placeholder="Input Purchase Date"
                class="form-control form-control-lg form-control-solid"
                type="date"
              />
            </div>
          </div>
          <div class="row">
            <label class="col-xl-3"></label>
            <div class="col-lg-9 col-xl-6">
              <h5 class="font-weight-bold mt-10 mb-6">Inventory Details</h5>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label"
              >Current Stock</label
            >
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.current_value"
                placeholder="Input Serial Number"
                class="form-control form-control-lg form-control-solid"
                type="number"
              />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Unit Price</label>
            <div class="col-lg-2 col-xl-2">
              <input
                v-model="form.unit_price_currency"
                placeholder="Input Currency"
                class="form-control form-control-lg form-control-solid"
                type="text"
              />
            </div>
            <div class="col-lg-7 col-xl-4">
              <input
                v-model="form.unit_price"
                placeholder="Input Unit Price"
                class="form-control form-control-lg form-control-solid"
                type="number"
              />
            </div>
          </div>

          <!-- for admin viewer only -->
          <div v-if="roles.includes('admin')" class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Import Price</label>
            <div class="col-lg-2 col-xl-2">
              <input
                v-model="form.import_price_currency"
                placeholder="Input Import Currency"
                class="form-control form-control-lg form-control-solid"
                type="text"
              />
            </div>
            <div class="col-lg-7 col-xl-4">
              <input
                v-model="form.import_price"
                placeholder="Input Import Price"
                class="form-control form-control-lg form-control-solid"
                type="number"
              />
            </div>
          </div>

          <!-- for admin viewer only -->
          <div v-if="roles.includes('admin')" class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Local Price</label>
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.local_price"
                placeholder="Input Local Price"
                class="form-control form-control-lg form-control-solid"
                type="number"
              />
            </div>
          </div>
        </div>
        <!--end::Body-->
      </form>
      <!--end::Form-->
    </div>
  </InventoryLayout>
</template>
