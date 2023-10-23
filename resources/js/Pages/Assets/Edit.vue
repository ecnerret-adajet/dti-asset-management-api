<script setup>
import InventoryLayout from "../../Layouts/InventoryLayout.vue";
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";

const baseUrl = window.location.origin;

const props = defineProps({
  asset: Object,
  locations: Array,
  asset_types: Array,
  status: Array,
});

const form = useForm(props.asset);
const previewImage = ref(`${baseUrl}/${props.asset.image_path}`);

const updateAsset = () => {
  form.patch(`/inventory/${props.asset.id}`);
};

const previewFile = (event) => {
  const file = event.target.files[0];

  form.image_path

  if (file) {
    const reader = new FileReader();

    reader.onload = (e) => {
      previewImage.value = e.target.result;
    };

    reader.readAsDataURL(file);
  } else {
    previewImage.value = `${baseUrl}/${props.asset.image_path}`;
  }
};

</script>
<template>
  <InventoryLayout>
    <!--begin::Card-->
    <div class="card card-custom card-stretch">
      <!--Begin::Header-->
      <div class="card-header card-header-tabs-line">
        <div class="card-toolbar">
          <ul
            class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x"
            role="tablist"
          >
            <li class="nav-item mr-3">
              <a
                class="nav-link active"
                data-toggle="tab"
                href="#kt_apps_contacts_view_tab_2"
              >
                <span class="nav-icon mr-2">
                  <span class="svg-icon mr-3">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink"
                      width="24px"
                      height="24px"
                      viewBox="0 0 24 24"
                      version="1.1"
                    >
                      <g
                        stroke="none"
                        stroke-width="1"
                        fill="none"
                        fill-rule="evenodd"
                      >
                        <rect x="0" y="0" width="24" height="24" />
                        <path
                          d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z"
                          fill="#000000"
                          fill-rule="nonzero"
                          opacity="0.3"
                        />
                        <path
                          d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                          fill="#000000"
                        />
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                </span>
                <span class="nav-text font-weight-bold">General Info</span>
              </a>
            </li>
            <li class="nav-item mr-3">
              <a
                class="nav-link"
                data-toggle="tab"
                href="#kt_apps_contacts_view_tab_3"
              >
                <span class="nav-icon mr-2">
                  <span class="svg-icon mr-3">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Devices/Display1.svg-->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink"
                      width="24px"
                      height="24px"
                      viewBox="0 0 24 24"
                      version="1.1"
                    >
                      <g
                        stroke="none"
                        stroke-width="1"
                        fill="none"
                        fill-rule="evenodd"
                      >
                        <rect x="0" y="0" width="24" height="24" />
                        <path
                          d="M11,20 L11,17 C11,16.4477153 11.4477153,16 12,16 C12.5522847,16 13,16.4477153 13,17 L13,20 L15.5,20 C15.7761424,20 16,20.2238576 16,20.5 C16,20.7761424 15.7761424,21 15.5,21 L8.5,21 C8.22385763,21 8,20.7761424 8,20.5 C8,20.2238576 8.22385763,20 8.5,20 L11,20 Z"
                          fill="#000000"
                          opacity="0.3"
                        />
                        <path
                          d="M3,5 L21,5 C21.5522847,5 22,5.44771525 22,6 L22,16 C22,16.5522847 21.5522847,17 21,17 L3,17 C2.44771525,17 2,16.5522847 2,16 L2,6 C2,5.44771525 2.44771525,5 3,5 Z M4.5,8 C4.22385763,8 4,8.22385763 4,8.5 C4,8.77614237 4.22385763,9 4.5,9 L13.5,9 C13.7761424,9 14,8.77614237 14,8.5 C14,8.22385763 13.7761424,8 13.5,8 L4.5,8 Z M4.5,10 C4.22385763,10 4,10.2238576 4,10.5 C4,10.7761424 4.22385763,11 4.5,11 L7.5,11 C7.77614237,11 8,10.7761424 8,10.5 C8,10.2238576 7.77614237,10 7.5,10 L4.5,10 Z"
                          fill="#000000"
                        />
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                </span>
                <span class="nav-text font-weight-bold">Stock Details</span>
              </a>
            </li>
            <li class="nav-item mr-3">
              <a
                class="nav-link"
                data-toggle="tab"
                href="#kt_apps_contacts_view_tab_4"
              >
                <span class="nav-icon mr-2">
                  <span class="svg-icon mr-3">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Globe.svg-->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink"
                      width="24px"
                      height="24px"
                      viewBox="0 0 24 24"
                      version="1.1"
                    >
                      <g
                        stroke="none"
                        stroke-width="1"
                        fill="none"
                        fill-rule="evenodd"
                      >
                        <rect x="0" y="0" width="24" height="24" />
                        <path
                          d="M13,18.9450712 L13,20 L14,20 C15.1045695,20 16,20.8954305 16,22 L8,22 C8,20.8954305 8.8954305,20 10,20 L11,20 L11,18.9448245 C9.02872877,18.7261967 7.20827378,17.866394 5.79372555,16.5182701 L4.73856106,17.6741866 C4.36621808,18.0820826 3.73370941,18.110904 3.32581341,17.7385611 C2.9179174,17.3662181 2.88909597,16.7337094 3.26143894,16.3258134 L5.04940685,14.367122 C5.46150313,13.9156769 6.17860937,13.9363085 6.56406875,14.4106998 C7.88623094,16.037907 9.86320756,17 12,17 C15.8659932,17 19,13.8659932 19,10 C19,7.73468744 17.9175842,5.65198725 16.1214335,4.34123851 C15.6753081,4.01567657 15.5775721,3.39010038 15.903134,2.94397499 C16.228696,2.49784959 16.8542722,2.4001136 17.3003976,2.72567554 C19.6071362,4.40902808 21,7.08906798 21,10 C21,14.6325537 17.4999505,18.4476269 13,18.9450712 Z"
                          fill="#000000"
                          fill-rule="nonzero"
                        />
                        <circle
                          fill="#000000"
                          opacity="0.3"
                          cx="12"
                          cy="10"
                          r="6"
                        />
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                </span>
                <span class="nav-text font-weight-bold">History Logs</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                data-toggle="tab"
                href="#kt_apps_contacts_view_tab_1"
              >
                <span class="nav-icon mr-2">
                  <span class="svg-icon mr-3">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink"
                      width="24px"
                      height="24px"
                      viewBox="0 0 24 24"
                      version="1.1"
                    >
                      <g
                        stroke="none"
                        stroke-width="1"
                        fill="none"
                        fill-rule="evenodd"
                      >
                        <rect x="0" y="0" width="24" height="24" />
                        <path
                          d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z"
                          fill="#000000"
                        />
                        <circle
                          fill="#000000"
                          opacity="0.3"
                          cx="18.5"
                          cy="5.5"
                          r="2.5"
                        />
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                </span>
                <span class="nav-text font-weight-bold">Notes</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="card-toolbar">
          <button
            type="submit"
            @click="updateAsset()"
            :disabled="form.processing"
            class="btn btn-success mr-2"
          >
            Update
          </button>
        </div>
      </div>
      <!--end::Header-->
      <!--Begin::Body-->
      <div class="card-body px-0">
        <div class="tab-content pt-5">
          <!--begin::Tab Content-->
          <div
            class="tab-pane active"
            id="kt_apps_contacts_view_tab_2"
            role="tabpanel"
          >
            <form class="form">
              <!--begin::Heading-->
              <div class="row">
                <div class="col-lg-9 col-xl-6 offset-xl-3">
                  <h3 class="font-size-h6 mb-5">Asset Image:</h3>
                </div>
              </div>
              <!--end::Heading-->
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Image</label
                >
                <div class="col-lg-9 col-xl-9">
                  <div
                    class="image-input image-input-outline"
                    id="kt_user_avatar"
                    style="
                      background-image: url(/assets/media/users/image-asset.jpeg);
                    "
                  >
                    <div
                      class="image-input-wrapper"
                      :style="`
                        background-image: url(${previewImage});
                      `"
                    ></div>
                    <label
                      class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                      data-action="change"
                      data-toggle="tooltip"
                      title=""
                      data-original-title="Change avatar"
                    >
                      <i class="fa fa-pen icon-sm text-muted"></i>
                      <input
                        type="file"
                        @change="previewFile"
                        @input="form.image_path = $event.target.files[0]"
                        name="profile_avatar"
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
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Name</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.name"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Description</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.description"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Location</label
                >
                <div class="col-lg-9 col-xl-6">
                  <select
                    v-model="form.location_id"
                    class="form-control form-control-lg form-control-solid"
                  >
                    <option
                      v-for="(location, l) in locations"
                      :key="l"
                      :value="location.id"
                    >
                      {{ location.name }}
                    </option>
                  </select>
                  <div
                    v-if="form.errors.location_id"
                    class="fv-plugins-message-container text-danger mt-3"
                  >
                    <div class="fv-help-block">
                      {{ form.errors.location_id }}
                    </div>
                  </div>
                  <span class="form-text text-muted"
                    >If you want your invoices addressed to a company. Leave
                    blank to use your full name.</span
                  >
                </div>
              </div>
              <div class="separator separator-dashed my-10"></div>
              <!--begin::Heading-->
              <div class="row">
                <div class="col-lg-9 col-xl-6 offset-xl-3">
                  <h3 class="font-size-h6 mb-5">Product Details:</h3>
                </div>
              </div>
              <!--end::Heading-->
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Asset Type</label
                >
                <div class="col-lg-9 col-xl-6">
                  <select
                    v-model="form.asset_type_id"
                    class="form-control form-control-lg form-control-solid"
                  >
                    <option
                      v-for="(assettype, a) in asset_types"
                      :key="a"
                      :value="assettype.id"
                    >
                      {{ assettype.name }}
                    </option>
                  </select>
                  <div
                    v-if="form.errors.asset_type_id"
                    class="fv-plugins-message-container text-danger mt-3"
                  >
                    <div class="fv-help-block">
                      {{ form.errors.asset_type_id }}
                    </div>
                  </div>
                  <span class="form-text text-muted"
                    >We'll never share your email with anyone else.</span
                  >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Model</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.model"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Serial Number</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.serial_number"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Manufacturer</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.manufacturer"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                </div>
              </div>

              <!-- <div class="separator separator-dashed my-10"></div> -->
            </form>
          </div>
          <!--end::Tab Content-->
          <!--begin::Tab Content-->
          <div
            class="tab-pane"
            id="kt_apps_contacts_view_tab_3"
            role="tabpanel"
          >
            <form class="form">
              <!--begin::Notice-->
              <!-- <div class="row">
                <div class="col-lg-9 col-xl-6 offset-xl-3">
                  <div
                    class="alert alert-custom alert-light-danger fade show mb-9"
                    role="alert"
                  >
                    <div class="alert-icon">
                      <i class="flaticon-warning"></i>
                    </div>
                    <div class="alert-text">
                      Configure user passwords to expire periodically.
                      <br />Users will need warning that their passwords are
                      going to expire, or they might inadvertently get locked
                      out of the system!
                    </div>
                    <div class="alert-close">
                      <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">
                          <i class="ki ki-close"></i>
                        </span>
                      </button>
                    </div>
                  </div>
                </div>
              </div> -->
              <!--end::Notice-->
              <!--begin::Heading-->
              <div class="row">
                <div class="col-lg-9 col-xl-6 offset-xl-3">
                  <h3 class="font-size-h6 mb-5">Stock Information:</h3>
                </div>
              </div>
              <!--end::Heading-->
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Purchase Date</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.purchase_date"
                    disabled
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Current Stock</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.current_value"
                    class="form-control form-control-lg form-control-solid"
                    type="number"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Unit Price</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.unit_price"
                    class="form-control form-control-lg form-control-solid"
                    type="number"
                  />
                </div>
              </div>
            </form>
          </div>
          <!--end::Tab Content-->
          <!--begin::Tab Content-->
          <div
            class="tab-pane"
            id="kt_apps_contacts_view_tab_4"
            role="tabpanel"
          >
            <form class="form">
              <div class="row">
                <label class="col-xl-3"></label>
                <div class="col-lg-9 col-xl-6">
                  <h3 class="font-size-h6 mb-5">Setup Email Notification:</h3>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Email Notification</label
                >
                <div class="col-lg-9 col-xl-6">
                  <span class="switch">
                    <label>
                      <input
                        type="checkbox"
                        checked="checked"
                        name="email_notification_1"
                      />
                      <span></span>
                    </label>
                  </span>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Send Copy To Personal Email</label
                >
                <div class="col-lg-9 col-xl-6">
                  <span class="switch">
                    <label>
                      <input type="checkbox" name="email_notification_2" />
                      <span></span>
                    </label>
                  </span>
                </div>
              </div>
              <div class="separator separator-dashed my-10"></div>
              <!--begin::Heading-->
              <div class="row">
                <div class="col-lg-9 col-xl-6 offset-xl-3">
                  <h3 class="font-size-h6 mb-5">Activity Related Emails:</h3>
                </div>
              </div>
              <!--end::Heading-->
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right"
                  >When To Email</label
                >
                <div class="col-lg-9 col-xl-6">
                  <div class="checkbox-list">
                    <label class="checkbox">
                      <input type="checkbox" />
                      <span></span>You have new notifications.</label
                    >
                    <label class="checkbox">
                      <input type="checkbox" />
                      <span></span>You're sent a direct message</label
                    >
                    <label class="checkbox">
                      <input type="checkbox" checked="checked" />
                      <span></span>Someone adds you as a connection</label
                    >
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right"
                  >When To Escalate Emails</label
                >
                <div class="col-lg-9 col-xl-6">
                  <div class="checkbox-list">
                    <label class="checkbox">
                      <input type="checkbox" />
                      <span></span>Upon new order.</label
                    >
                    <label class="checkbox">
                      <input type="checkbox" />
                      <span></span>New membership approval</label
                    >
                    <label class="checkbox">
                      <input type="checkbox" checked="checked" />
                      <span></span>Member registration</label
                    >
                  </div>
                </div>
              </div>
              <div class="separator separator-dashed my-10"></div>
              <!--begin::Heading-->
              <div class="row">
                <div class="col-lg-9 col-xl-6 offset-xl-3">
                  <h3 class="font-size-h6 mb-5">Updates From Keenthemes:</h3>
                </div>
              </div>
              <!--end::Heading-->
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right"
                  >Email You With</label
                >
                <div class="col-lg-9 col-xl-6">
                  <div class="checkbox-list">
                    <label class="checkbox">
                      <input type="checkbox" />
                      <span></span>News about Metronic product and feature
                      updates</label
                    >
                    <label class="checkbox">
                      <input type="checkbox" />
                      <span></span>Tips on getting more out of Keen</label
                    >
                    <label class="checkbox">
                      <input type="checkbox" checked="checked" />
                      <span></span>Things you missed since you last logged into
                      Keen</label
                    >
                    <label class="checkbox">
                      <input type="checkbox" checked="checked" />
                      <span></span>News about Metronic on partner products and
                      other services</label
                    >
                    <label class="checkbox">
                      <input type="checkbox" checked="checked" />
                      <span></span>Tips on Metronic business products</label
                    >
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!--end::Tab Content-->
          <!--begin::Tab Content-->
          <div
            class="tab-pane"
            id="kt_apps_contacts_view_tab_1"
            role="tabpanel"
          >
            <div class="container">
              <form class="form">
                <div class="form-group">
                  <textarea
                    class="form-control form-control-lg form-control-solid"
                    id="exampleTextarea"
                    rows="3"
                    placeholder="Type notes"
                  ></textarea>
                </div>
                <div class="row">
                  <div class="col">
                    <a href="#" class="btn btn-light-primary font-weight-bold"
                      >Add notes</a
                    >
                    <a href="#" class="btn btn-clean font-weight-bold"
                      >Cancel</a
                    >
                  </div>
                </div>
              </form>
              <div class="separator separator-dashed my-10"></div>
              <!--begin::Timeline-->
              <div class="timeline timeline-3">
                <div class="timeline-items">
                  <div class="timeline-item">
                    <div class="timeline-media">
                      <img alt="Pic" src="assets/media/users/300_25.jpg" />
                    </div>
                    <div class="timeline-content">
                      <div
                        class="d-flex align-items-center justify-content-between mb-3"
                      >
                        <div class="mr-2">
                          <a
                            href="#"
                            class="text-dark-75 text-hover-primary font-weight-bold"
                            >New order has been placed</a
                          >
                          <span class="text-muted ml-2">Today</span>
                          <span
                            class="label label-light-success font-weight-bolder label-inline ml-2"
                            >new</span
                          >
                        </div>
                        <div
                          class="dropdown ml-2"
                          data-toggle="tooltip"
                          title="Quick actions"
                          data-placement="left"
                        >
                          <a
                            href="#"
                            class="btn btn-hover-light-primary btn-sm btn-icon"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i
                              class="ki ki-more-hor font-size-lg text-primary"
                            ></i>
                          </a>
                          <div
                            class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right"
                          >
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                              <li class="navi-header font-weight-bold py-4">
                                <span class="font-size-lg">Choose Label:</span>
                                <i
                                  class="flaticon2-information icon-md text-muted"
                                  data-toggle="tooltip"
                                  data-placement="right"
                                  title="Click to learn more..."
                                ></i>
                              </li>
                              <li class="navi-separator mb-3 opacity-70"></li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-success"
                                      >Customer</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-danger"
                                      >Partner</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-warning"
                                      >Suplier</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-primary"
                                      >Member</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-dark"
                                      >Staff</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-separator mt-3 opacity-70"></li>
                              <li class="navi-footer py-4">
                                <a
                                  class="btn btn-clean font-weight-bold btn-sm"
                                  href="#"
                                >
                                  <i class="ki ki-plus icon-sm"></i>Add new</a
                                >
                              </li>
                            </ul>
                            <!--end::Navigation-->
                          </div>
                        </div>
                      </div>
                      <p class="p-0">
                        Sed ut perspiciatis unde omnis iste natus error sit
                        voluptatem accusantium doloremque laudantium, totam rem
                        aperiam, eaque ipsa quae ab illo inventore veritatis et
                        quasi architecto.
                      </p>
                    </div>
                  </div>
                  <div class="timeline-item">
                    <div class="timeline-media">
                      <i class="flaticon2-shield text-danger"></i>
                    </div>
                    <div class="timeline-content">
                      <div
                        class="d-flex align-items-center justify-content-between mb-3"
                      >
                        <div class="mr-2">
                          <a
                            href="#"
                            class="text-dark-75 text-hover-primary font-weight-bold"
                            >Member has sent a request.</a
                          >
                          <span class="text-muted ml-2">8:30PM 20 June</span>
                          <span
                            class="label label-light-danger font-weight-bolder label-inline ml-2"
                            >pending</span
                          >
                        </div>
                        <div
                          class="dropdown ml-2"
                          data-toggle="tooltip"
                          title="Quick actions"
                          data-placement="left"
                        >
                          <a
                            href="#"
                            class="btn btn-hover-light-primary btn-sm btn-icon"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i
                              class="ki ki-more-hor font-size-lg text-primary"
                            ></i>
                          </a>
                          <div
                            class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right"
                          >
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                              <li class="navi-header font-weight-bold py-4">
                                <span class="font-size-lg">Choose Label:</span>
                                <i
                                  class="flaticon2-information icon-md text-muted"
                                  data-toggle="tooltip"
                                  data-placement="right"
                                  title="Click to learn more..."
                                ></i>
                              </li>
                              <li class="navi-separator mb-3 opacity-70"></li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-success"
                                      >Customer</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-danger"
                                      >Partner</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-warning"
                                      >Suplier</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-primary"
                                      >Member</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-dark"
                                      >Staff</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-separator mt-3 opacity-70"></li>
                              <li class="navi-footer py-4">
                                <a
                                  class="btn btn-clean font-weight-bold btn-sm"
                                  href="#"
                                >
                                  <i class="ki ki-plus icon-sm"></i>Add new</a
                                >
                              </li>
                            </ul>
                            <!--end::Navigation-->
                          </div>
                        </div>
                      </div>
                      <p class="p-0">
                        Sed ut perspiciatis unde omnis iste natus error sit
                        voluptatem accusantium doloremque laudantium, totam rem
                        aperiam, eaque ipsa quae ab illo inventore veritatis et
                        quasi architecto.
                      </p>
                    </div>
                  </div>
                  <div class="timeline-item">
                    <div class="timeline-media">
                      <i class="flaticon2-layers text-warning"></i>
                    </div>
                    <div class="timeline-content">
                      <div
                        class="d-flex align-items-center justify-content-between mb-3"
                      >
                        <div class="mr-2">
                          <a
                            href="#"
                            class="text-dark-75 text-hover-primary font-weight-bold"
                            >System deployment has been completed.</a
                          >
                          <span class="text-muted ml-2">11:00AM 30 June</span>
                          <span
                            class="label label-light-warning font-weight-bolder label-inline ml-2"
                            >done</span
                          >
                        </div>
                        <div
                          class="dropdown ml-2"
                          data-toggle="tooltip"
                          title="Quick actions"
                          data-placement="left"
                        >
                          <a
                            href="#"
                            class="btn btn-hover-light-primary btn-sm btn-icon"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i
                              class="ki ki-more-hor font-size-lg text-primary"
                            ></i>
                          </a>
                          <div
                            class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right"
                          >
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                              <li class="navi-header font-weight-bold py-4">
                                <span class="font-size-lg">Choose Label:</span>
                                <i
                                  class="flaticon2-information icon-md text-muted"
                                  data-toggle="tooltip"
                                  data-placement="right"
                                  title="Click to learn more..."
                                ></i>
                              </li>
                              <li class="navi-separator mb-3 opacity-70"></li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-success"
                                      >Customer</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-danger"
                                      >Partner</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-warning"
                                      >Suplier</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-primary"
                                      >Member</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-dark"
                                      >Staff</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-separator mt-3 opacity-70"></li>
                              <li class="navi-footer py-4">
                                <a
                                  class="btn btn-clean font-weight-bold btn-sm"
                                  href="#"
                                >
                                  <i class="ki ki-plus icon-sm"></i>Add new</a
                                >
                              </li>
                            </ul>
                            <!--end::Navigation-->
                          </div>
                        </div>
                      </div>
                      <p class="p-0">
                        Sed ut perspiciatis unde omnis iste natus error sit
                        voluptatem accusantium doloremque laudantium, totam rem
                        aperiam, eaque ipsa quae ab illo inventore veritatis et
                        quasi architecto.
                      </p>
                    </div>
                  </div>
                  <div class="timeline-item">
                    <div class="timeline-media">
                      <i class="flaticon2-notification fl text-primary"></i>
                    </div>
                    <div class="timeline-content">
                      <div
                        class="d-flex align-items-center justify-content-between mb-3"
                      >
                        <div class="mr-2">
                          <a
                            href="#"
                            class="text-dark-75 text-hover-primary font-weight-bold"
                            >Database backup has been completed.</a
                          >
                          <span class="text-muted ml-2">2 months ago</span>
                          <span
                            class="label label-light-primary font-weight-bolder label-inline ml-2"
                            >delivered</span
                          >
                        </div>
                        <div
                          class="dropdown ml-2"
                          data-toggle="tooltip"
                          title="Quick actions"
                          data-placement="left"
                        >
                          <a
                            href="#"
                            class="btn btn-hover-light-primary btn-sm btn-icon"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i
                              class="ki ki-more-hor font-size-lg text-primary"
                            ></i>
                          </a>
                          <div
                            class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right"
                          >
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                              <li class="navi-header font-weight-bold py-4">
                                <span class="font-size-lg">Choose Label:</span>
                                <i
                                  class="flaticon2-information icon-md text-muted"
                                  data-toggle="tooltip"
                                  data-placement="right"
                                  title="Click to learn more..."
                                ></i>
                              </li>
                              <li class="navi-separator mb-3 opacity-70"></li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-success"
                                      >Customer</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-danger"
                                      >Partner</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-warning"
                                      >Suplier</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-primary"
                                      >Member</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-item">
                                <a href="#" class="navi-link">
                                  <span class="navi-text">
                                    <span
                                      class="label label-xl label-inline label-light-dark"
                                      >Staff</span
                                    >
                                  </span>
                                </a>
                              </li>
                              <li class="navi-separator mt-3 opacity-70"></li>
                              <li class="navi-footer py-4">
                                <a
                                  class="btn btn-clean font-weight-bold btn-sm"
                                  href="#"
                                >
                                  <i class="ki ki-plus icon-sm"></i>Add new</a
                                >
                              </li>
                            </ul>
                            <!--end::Navigation-->
                          </div>
                        </div>
                      </div>
                      <p class="p-0">
                        Sed ut perspiciatis unde omnis iste natus error sit
                        voluptatem accusantium doloremque laudantium, totam rem
                        aperiam, eaque ipsa quae ab illo inventore veritatis et
                        quasi architecto.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!--end::Timeline-->
            </div>
          </div>
          <!--end::Tab Content-->
        </div>
      </div>
      <!--end::Body-->
    </div>
    <!--end::Card-->
  </InventoryLayout>
</template>
