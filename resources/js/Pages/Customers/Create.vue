<script setup>
import InventoryLayout from "../../Layouts/InventoryLayout.vue";
import { useSweetAlert } from '../../Services/useSweetAlert';
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const baseUrl = window.location.origin;

const sweetAlert = useSweetAlert();

const form = useForm({
  name: null,
  address: null,
  email: null,
  phone_number: null,
  representative_name: null,
});

const storeCustomer = () => {
  form.post("/customers",{
    onSuccess: () => {
        form.reset();
        sweetAlert.basicAlert("Succesfully created!","New Customer","success");
    }
  });
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
          </ul>
        </div>
        <div class="card-toolbar">
          <button
            type="submit"
            @click="storeCustomer()"
            :disabled="form.processing"
            class="btn btn-success mr-2"
          >
            Submit
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
                  <h3 class="font-size-h6 mb-5">New Customer</h3>
                </div>
              </div>
              <!--end::Heading-->

              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Name</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.name"
                    placeholder="Input customer name"
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
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Address</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.address"
                    placeholder="Input address"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                  <div
                    v-if="form.errors.address"
                    class="fv-plugins-message-container text-danger mt-3"
                  >
                    <div class="fv-help-block">
                      {{ form.errors.address }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Email</label
                >
                <div class="col-lg-9 col-xl-6">
                  <div class="input-group input-group-lg input-group-solid">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="la la-at"></i>
                      </span>
                    </div>
                    <input
                      v-model="form.email"
                      type="text"
                      class="form-control form-control-lg form-control-solid"
                      placeholder="Email"
                    />
                  </div>
                  <div
                    v-if="form.errors.email"
                    class="fv-plugins-message-container text-danger mt-3"
                  >
                    <div class="fv-help-block">
                      {{ form.errors.email }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Phone Number</label
                >
                <div class="col-lg-9 col-xl-6">
                  <div class="input-group input-group-lg input-group-solid">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="la la-phone"></i>
                      </span>
                    </div>
                    <input
                      type="text"
                      v-model="form.phone_number"
                      class="form-control form-control-lg form-control-solid"
                      placeholder="Phone"
                    />
                  </div>
                  <div
                    v-if="form.errors.phone_number"
                    class="fv-plugins-message-container text-danger mt-3"
                  >
                    <div class="fv-help-block">
                      {{ form.errors.phone_number }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 text-right col-form-label"
                  >Representative Name</label
                >
                <div class="col-lg-9 col-xl-6">
                  <input
                    v-model="form.representative_name"
                    placeholder="Input representative"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                  />
                  <div
                    v-if="form.errors.representative_name"
                    class="fv-plugins-message-container text-danger mt-3"
                  >
                    <div class="fv-help-block">
                      {{ form.errors.representative_name }}
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="separator separator-dashed my-10"></div> -->
            </form>
          </div>
        </div>
      </div>
      <!--end::Body-->
    </div>
    <!--end::Card-->
  </InventoryLayout>
</template>
