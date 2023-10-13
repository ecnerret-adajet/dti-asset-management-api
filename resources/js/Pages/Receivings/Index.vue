<script setup>
import BasicLayout from "../../Layouts/BasicLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import SubHeader from "../../Components/SubHeader.vue";
import { router, Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";

import ShowModal from "./ShowModal.vue";

const props = defineProps({
  receiving_statuses: Array,
  filters: Object,
  receivings: Object,
});

const breadcrumbs = ref([
  { id: 1, name: "Apps", url: "/" },
  { id: 2, name: "Requests", url: "/inventory/receivings" },
]);

const show = ref(false);
const selected_receiving = ref({});

const form = useForm({
  name: props.filters.asset_name,
});

watch(
  () => form,
  throttle(() => {
    router.get("/inventory/receivings", pickBy(form), {
      preserveState: true,
    });
  }, 150),
  { deep: true }
);

const openShowDetails = (item) => {
  show.value = !show.value;
  selected_receiving.value = item;
};
</script>
<template>
  <BasicLayout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
      <!-- sub header -->
      <SubHeader title="Asset Requests" :breadcrumbs="breadcrumbs" />
      <!-- end subheader -->
      <!--begin::Entry-->
      <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
          <!--begin::Teachers-->
          <div class="d-flex flex-row">
            <!-- aside position -->

            <!--begin::Content-->
            <div class="flex-row-fluid">
              <!--begin::Card-->
              <div class="card card-custom">

                <!--begin::Body-->
                <div class="card-body">
                  <!--begin: Search Form-->
                  <!--begin::Search Form-->
                  <div class="mb-5">
                    <div class="row align-items-center">
                      <div class="col-lg-12 col-xl-12">
                        <div class="row align-items-center">
                          <div class="col-md-12 my-2 my-md-0">
                            <div class="input-icon">
                              <input
                                type="text"
                                v-model="form.name"
                                class="form-control form-control-solid"
                                placeholder="Search name..."
                                id="kt_datatable_search_query"
                              />
                              <span>
                                <i class="flaticon2-search-1 text-muted"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--end::Search Form-->
                  <!--end: Search Form-->
                  <!--begin: Datatable-->
                  <!--begin::Table-->
                  <div class="table-responsive">
                    <table
                      class="table table-head-custom table-vertical-center"
                      id="kt_advance_table_widget_1"
                    >
                      <thead>
                        <tr class="text-left">
                          <th class="pr-0" style="width: 300px">Asset Name</th>
                          <th style="min-width: 150px">Quantity</th>
                          <th style="min-width: 150px">Status</th>
                          <th class="pr-0 text-right" style="min-width: 150px">
                            action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(receiving, l) in receivings.data" :key="l">
                          <td class="pr-2">
                            <span class="text-capitalize">
                              {{ receiving.asset.name }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ receiving.qty }}
                            </span>
                          </td>
                          <td>
                            <span
                              :class="{
                                ' label-light-info ':
                                  receiving.receiving_status.id === 1,
                                ' label-light-primary ':
                                  receiving.receiving_status.id === 2,
                                ' label-light-warning ':
                                  receiving.receiving_status.id === 3,
                                ' label-light-success ':
                                  receiving.receiving_status.id === 4,
                              }"
                              class="label label-lg font-weight-bold text-capitalize label-inline"
                              >{{ receiving.receiving_status.name }}</span
                            >
                          </td>
                          <td class="pr-0 text-right">
                            <div v-show="receiving.receiving_status.id !=4" class="dropdown dropdown-inline">
                              <a
                                href="javascript::void(0)"
                                class="btn btn-sm btn-clean btn-icon mr-2"
                                data-toggle="dropdown"
                              >
                                <span class="svg-icon svg-icon-md">
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
                                      <rect
                                        x="0"
                                        y="0"
                                        width="24"
                                        height="24"
                                      ></rect>
                                      <path
                                        d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                        fill="#000000"
                                      ></path>
                                    </g>
                                  </svg>
                                </span>
                              </a>
                              <div
                                class="dropdown-menu dropdown-menu-sm dropdown-menu-right"
                              >
                                <ul class="navi flex-column navi-hover py-2">
                                  <li
                                    class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2"
                                  >
                                    Choose an action:
                                  </li>
                                  <li class="navi-item">
                                    <a href="javascript:;" class="navi-link">
                                      <span class="navi-icon"
                                        ><i class="fa fa-truck-loading"></i
                                      ></span>
                                      <span class="navi-text"
                                        >Order Status</span
                                      >
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>

                            <button
                              v-show="receiving.receiving_status.id !=4"
                              type="button"
                              @click="openShowDetails(receiving)"
                              class="btn btn-sm btn-clean btn-icon mr-2"
                              title="Open Order"
                            >
                              <span class="svg-icon svg-icon-md">
                                <span
                                  class="svg-icon svg-icon-primary svg-icon-2x"
                                  ><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Navigation\Up-right.svg--><svg
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
                                      <polygon points="0 0 24 0 24 24 0 24" />
                                      <rect
                                        fill="#000000"
                                        opacity="0.3"
                                        transform="translate(11.646447, 12.853553) rotate(-315.000000) translate(-11.646447, -12.853553) "
                                        x="10.6464466"
                                        y="5.85355339"
                                        width="2"
                                        height="14"
                                        rx="1"
                                      />
                                      <path
                                        d="M8.1109127,8.90380592 C7.55862795,8.90380592 7.1109127,8.45609067 7.1109127,7.90380592 C7.1109127,7.35152117 7.55862795,6.90380592 8.1109127,6.90380592 L16.5961941,6.90380592 C17.1315855,6.90380592 17.5719943,7.32548256 17.5952502,7.8603687 L17.9488036,15.9920967 C17.9727933,16.5438602 17.5449482,17.0106003 16.9931847,17.0345901 C16.4414212,17.0585798 15.974681,16.6307346 15.9506913,16.0789711 L15.6387276,8.90380592 L8.1109127,8.90380592 Z"
                                        fill="#000000"
                                        fill-rule="nonzero"
                                      />
                                    </g></svg
                                  ><!--end::Svg Icon--></span
                                >
                              </span>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!--end::Table-->
                  <!--begin::Pagination-->
                  <Pagination class="mt-6" :links="receivings.links" />
                  <!--end::Pagination-->
                  <!--end: Datatable-->
                </div>
                <!--end::Body-->
              </div>
              <!--end::Card-->
            </div>
            <!--end::Content-->
          </div>
          <!--end::Teachers-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::Entry-->
    </div>
    <!--end::Content-->

    <show-modal
      unique_id="receivingDetailsModal"
      title="Request Details"
      :show="show"
      @close="show = $event"
      :receiving="selected_receiving"
      :receiving_statuses="receiving_statuses"
    />
  </BasicLayout>
</template>
