<script setup>
import { ref, watch } from "vue";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { router, Link, useForm } from "@inertiajs/vue3";
import BasicLayout from "../Layouts/BasicLayout.vue";

const baseUrl = window.location.origin;

const props = defineProps({
  filters: Object,
  assets: Object,
  locations: Array,
  asset_types: Array,
  statuses: Array,
});

const form = useForm({
  name: props.filters.name,
  model: props.filters.model,
  serial_number: props.filters.serial_number,
  location: props.filters.location,
  status: props.filters.status,
  asset_type: props.filters.asset_type,
});

watch(
  () => form,
  throttle(() => {
    router.get("/inventory", pickBy(form), {
      preserveState: true,
    });
  }, 150),
  { deep: true }
);
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
                      >Asset Inventory</span
                    >
                    <span class="text-muted mt-1 font-weight-bold font-size-sm"
                      >Manage over assets and components</span
                    >
                  </h3>
                  <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <!-- <div class="dropdown dropdown-inline mr-2">
                      <button
                        type="button"
                        class="btn btn-light-primary font-weight-bolder dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
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
                              <rect x="0" y="0" width="24" height="24" />
                              <path
                                d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                fill="#000000"
                                opacity="0.3"
                              />
                              <path
                                d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                fill="#000000"
                              />
                            </g>
                          </svg>
                         </span
                        >Export
                      </button>
                      <div
                        class="dropdown-menu dropdown-menu-sm dropdown-menu-right"
                      >
                        <ul class="navi flex-column navi-hover py-2">
                          <li
                            class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2"
                          >
                            Choose an option:
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="la la-print"></i>
                              </span>
                              <span class="navi-text">Print</span>
                            </a>
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="la la-copy"></i>
                              </span>
                              <span class="navi-text">Copy</span>
                            </a>
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="la la-file-excel-o"></i>
                              </span>
                              <span class="navi-text">Excel</span>
                            </a>
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="la la-file-text-o"></i>
                              </span>
                              <span class="navi-text">CSV</span>
                            </a>
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="la la-file-pdf-o"></i>
                              </span>
                              <span class="navi-text">PDF</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div> -->
                    <!--end::Dropdown-->

                    <!--begin::Button-->
                    <Link href="/inventory/create" class="btn btn-primary font-weight-bolder">
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
                      >Add Record</Link
                    >
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
                      <div class="col-lg-10 col-xl-10">
                        <div class="row align-items-center">
                          <div class="col-md-3 my-2 my-md-0">
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
                          <div class="col-md-3 my-2 my-md-0">
                            <select
                              v-model="form.status"
                              class="form-control"
                              id="kt_datatable_search_status"
                            >
                              <option :value="null">Status</option>
                              <option
                                class="text-capitalized"
                                v-for="(status, s) in statuses"
                                :key="s"
                                :value="status.id"
                              >
                                {{ status.name }}
                              </option>
                            </select>
                          </div>
                          <div class="col-md-3 my-2 my-md-0">
                            <select
                              v-model="form.status"
                              class="form-control"
                              id="kt_datatable_search_type"
                            >
                              <option :value="null">Asset Type</option>
                              <option
                                v-for="(type, t) in asset_types"
                                :key="t"
                                :value="type.id"
                              >
                                {{ type.name }}
                              </option>
                            </select>
                          </div>
                          <div class="col-md-3 my-2 my-md-0">
                            <select
                              v-model="form.status"
                              class="form-control"
                              id="kt_datatable_search_type"
                            >
                              <option :value="null">Location</option>
                              <option
                                v-for="(location, l) in locations"
                                :key="l"
                                :value="location.id"
                              >
                                {{ location.name }}
                              </option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-2 col-xl-2 mt-5 mt-lg-0">
                        <a
                          href="#"
                          class="btn btn-light-primary px-6 font-weight-bold"
                          >Search</a
                        >
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
                          <th class="pr-0" colspan="2" style="width: 200px">
                            Name
                          </th>
                          <th style="min-width: 150px">Model</th>
                          <th style="min-width: 150px">Purchase Date</th>
                          <th style="min-width: 150px">Status</th>
                          <th style="min-width: 150px">Type</th>
                          <th class="pr-0 text-right" style="min-width: 150px">
                            action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(asset, a) in assets.data" :key="a">
                          <td class="pr-2" width="8%">
                            <div class="symbol symbol-50 symbol-light mt-1">
                              <span class="symbol-label">
                                <img
                                  :src="`${baseUrl}/${asset.image_path}`"
                                  class="h-75 align-self-end"
                                  alt=""
                                />
                              </span>
                            </div>
                          </td>
                          <td class="pl-0">
                            <span class="text-capitalize">
                            {{ asset.name }}
                            </span>
                            <span class="text-muted text-capitalize text-muted d-block">{{
                              asset.serial_number
                            }}</span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ asset.model }}
                            </span>
                          </td>
                          <td>
                            {{ asset.purchase_date }}
                          </td>
                          <td>
                            <span
                              class="label label-success label-dot mr-2"
                            ></span
                            ><span
                              class="font-weight-bold text-capitalize text-success"
                              >{{ asset.status.name }}</span
                            >
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ asset.asset_type.name }}
                            </span>
                          </td>
                          <td class="pr-0 text-right">
                            <a
                              href="#"
                              class="btn btn-icon btn-light btn-hover-primary btn-sm"
                            >
                              <span
                                class="svg-icon svg-icon-md svg-icon-primary"
                              >
                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
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
                                      d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z"
                                      fill="#000000"
                                    />
                                    <path
                                      d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z"
                                      fill="#000000"
                                      opacity="0.3"
                                    />
                                  </g>
                                </svg>
                                <!--end::Svg Icon-->
                              </span>
                            </a>
                            <Link
                              :href="`/inventory/${asset.id}`"
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
  </BasicLayout>
</template>
