<script setup>
import BasicLayout from "../../Layouts/BasicLayout.vue";
import CreateModal from "./CreateModal.vue";
import { router, Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";

const show = ref(false);
const props = defineProps({
  statuses: Object,
  filters: Object,
});

const form = useForm({
  name: props.filters.name,
});

watch(
  () => form,
  throttle(() => {
    router.get("/statuses", pickBy(form), {
      preserveState: true,
    });
  }, 150),
  { deep: true }
);

const openModal = () => {
  show.value = !show.value;
};


</script>
<template>
  <BasicLayout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                  <h3 class="card-title align-items-start flex-column">
                    <span
                      class="card-label font-weight-bolder font-size-h3 text-dark"
                      >Status Manamgement</span
                    >
                    <span class="text-muted mt-1 font-weight-bold font-size-sm"
                      >general status for assets, users etc..</span
                    >
                  </h3>
                  <div class="card-toolbar">
                    <!--begin::Button-->
                    <button
                      @click="openModal()"
                      class="btn btn-primary font-weight-bolder"
                    >
                      <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
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
                            <circle fill="#000000" cx="9" cy="15" r="6" />
                            <path
                              d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                              fill="#000000"
                              opacity="0.3"
                            />
                          </g>
                        </svg>
                        <!--end::Svg Icon--> </span
                      >Add Record
                    </button>
                    <!--end::Button-->
                  </div>
                </div>
                <!--end::Header-->
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
                          <th class="pr-0" style="width: 300px">Name</th>
                          <th style="min-width: 150px">Remarks</th>
                          <th style="min-width: 150px">Status</th>
                          <th class="pr-0 text-right" style="min-width: 150px">
                            action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(status, l) in statuses.data" :key="l">
                          <td class="pr-2">
                            <span class="text-capitalize">
                              {{ status.name }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ status.description }}
                            </span>
                          </td>
                          <td>
                            <span
                              class="label label-dot mr-2"
                              :class="{
                                ' label-success ': status.is_active === 1,
                                ' label-danger ': status.is_active === 0,
                              }"
                            ></span
                            ><span
                              class="font-weight-bold text-capitalize"
                              :class="{
                                ' text-success ': status.is_active === 1,
                                ' text-danger ': status.is_active === 0,
                              }"
                              >{{
                                status.is_active === 1
                                  ? "Active"
                                  : "Deactivated"
                              }}</span
                            >
                          </td>
                          <td class="pr-0 text-right">
                            <Link
                              href="/"
                              class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3"
                            >
                              <span
                                class="svg-icon svg-icon-md svg-icon-primary"
                              >
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
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
                                      d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                      fill="#000000"
                                      fill-rule="nonzero"
                                      transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"
                                    />
                                    <path
                                      d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                      fill="#000000"
                                      fill-rule="nonzero"
                                      opacity="0.3"
                                    />
                                  </g>
                                </svg>
                                <!--end::Svg Icon-->
                              </span>
                            </Link>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!--end::Table-->
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

    <create-modal
      unique_id="assetTypeModal"
      title="Create Asset Type"
      :show="show"
      @submit="createLocation($event)"
      @close="show = $event"
    />

  </BasicLayout>
</template>
