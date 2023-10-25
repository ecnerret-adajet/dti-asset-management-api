<script setup>
import { watch, reactive, onMounted, ref } from "vue";
import BasicLayout from "../Layouts/BasicLayout.vue";

// api
import ReportsApi from '../Api/ReportsApi';

const reportsService = new ReportsApi();
const errors = ref(null);

const totalassetcount = ref(0);
const totalspendingcount = ref(0);
const totalsoldcount = ref(0);
const totalrequestcount = ref(0);

const fetchTotalAssets = () => {
  return reportsService
    .totalAssets()
    .then((response) => {
        console.log(response)
      totalassetcount.value = response;
    })
    .catch((error) => {
      errors.value = error;
    });
};

const fetchTotalSpending = () => {
  return reportsService
    .totalSpending()
    .then((response) => {
      totalspendingcount.value = response;
    })
    .catch((error) => {
      errors.value = error;
    });
};

const fetchTotalSold = () => {
  return reportsService
    .totalSold()
    .then((response) => {
      totalsoldcount.value = response;
    })
    .catch((error) => {
      errors.value = error;
    });
};

const fetchTotalRequets = () => {
  return reportsService
    .totalRequests()
    .then((response) => {
      totalrequestcount.value = response;
    })
    .catch((error) => {
      errors.value = error;
    });
};

const currencyFormatter = (amount) => {
  const currencyAmount = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "PHP", // Change to your desired currency code (e.g., 'EUR' for Euro)
  });
  return currencyAmount.format(amount);
};

onMounted(() => {
  fetchTotalAssets();
  fetchTotalSpending();
  fetchTotalSold();
  fetchTotalRequets();
});

</script>
<template>
  <BasicLayout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
      <!--begin::Subheader-->
      <div
        class="subheader py-2 py-lg-12 subheader-transparent"
        id="kt_subheader"
      >
        <div
          class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
        >
          <!--begin::Info-->
          <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Heading-->
            <div class="d-flex flex-column">
              <!--begin::Title-->
              <h2 class="text-white font-weight-bold my-2 mr-5">Dashboard</h2>
              <!--end::Title-->
              <!--begin::Breadcrumb-->
              <div class="d-flex align-items-center font-weight-bold my-2">
                <!--begin::Item-->
                <a href="#" class="opacity-75 hover-opacity-100">
                  <i class="flaticon2-shelter text-white icon-1x"></i>
                </a>
                <!--end::Item-->
                <!--begin::Item-->
                <span
                  class="label label-dot label-sm bg-white opacity-75 mx-3"
                ></span>
                <a
                  href=""
                  class="text-white text-hover-white opacity-75 hover-opacity-100"
                  >Dashboard</a
                >
                <!--end::Item-->
                <!--begin::Item-->
                <span
                  class="label label-dot label-sm bg-white opacity-75 mx-3"
                ></span>
                <a
                  href=""
                  class="text-white text-hover-white opacity-75 hover-opacity-100"
                  >Latest Updated</a
                >
                <!--end::Item-->
              </div>
              <!--end::Breadcrumb-->
            </div>
            <!--end::Heading-->
          </div>
          <!--end::Info-->
          <!--begin::Toolbar-->
          <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a
              href="#"
              class="btn btn-transparent-white font-weight-bold py-3 px-6 mr-2"
              >Reports</a
            >
            <!--end::Button-->
            <!--begin::Dropdown-->
            <div
              class="dropdown dropdown-inline ml-2"
              data-toggle="tooltip"
              title="Quick actions"
              data-placement="top"
            >
              <a
                href="#"
                class="btn btn-white font-weight-bold py-3 px-6"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                >Actions</a
              >
              <div
                class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right"
              >
                <!--begin::Navigation-->
                <ul class="navi navi-hover py-5">
                  <li class="navi-item">
                    <a href="#" class="navi-link">
                      <span class="navi-icon">
                        <i class="flaticon2-drop"></i>
                      </span>
                      <span class="navi-text">New Group</span>
                    </a>
                  </li>
                  <li class="navi-item">
                    <a href="#" class="navi-link">
                      <span class="navi-icon">
                        <i class="flaticon2-list-3"></i>
                      </span>
                      <span class="navi-text">Contacts</span>
                    </a>
                  </li>
                  <li class="navi-item">
                    <a href="#" class="navi-link">
                      <span class="navi-icon">
                        <i class="flaticon2-rocket-1"></i>
                      </span>
                      <span class="navi-text">Groups</span>
                      <span class="navi-link-badge">
                        <span
                          class="label label-light-primary label-inline font-weight-bold"
                          >new</span
                        >
                      </span>
                    </a>
                  </li>
                  <li class="navi-item">
                    <a href="#" class="navi-link">
                      <span class="navi-icon">
                        <i class="flaticon2-bell-2"></i>
                      </span>
                      <span class="navi-text">Calls</span>
                    </a>
                  </li>
                  <li class="navi-item">
                    <a href="#" class="navi-link">
                      <span class="navi-icon">
                        <i class="flaticon2-gear"></i>
                      </span>
                      <span class="navi-text">Settings</span>
                    </a>
                  </li>
                  <li class="navi-separator my-3"></li>
                  <li class="navi-item">
                    <a href="#" class="navi-link">
                      <span class="navi-icon">
                        <i class="flaticon2-magnifier-tool"></i>
                      </span>
                      <span class="navi-text">Help</span>
                    </a>
                  </li>
                  <li class="navi-item">
                    <a href="#" class="navi-link">
                      <span class="navi-icon">
                        <i class="flaticon2-bell-2"></i>
                      </span>
                      <span class="navi-text">Privacy</span>
                      <span class="navi-link-badge">
                        <span
                          class="label label-light-danger label-rounded font-weight-bold"
                          >5</span
                        >
                      </span>
                    </a>
                  </li>
                </ul>
                <!--end::Navigation-->
              </div>
            </div>
            <!--end::Dropdown-->
          </div>
          <!--end::Toolbar-->
        </div>
      </div>
      <!--end::Subheader-->
      <!--begin::Entry-->
      <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
          <!--begin::Dashboard-->

          <div class="row">
            <div class="col-xl-3">
              <!--begin::Stats Widget 29-->
              <div
                class="card card-custom bgi-no-repeat card-stretch gutter-b"
                style="
                  background-position: right top;
                  background-size: 30% auto;
                  background-image: url(assets/media/svg/shapes/abstract-1.svg);
                "
              >
                <!--begin::Body-->
                <div class="card-body">
                  <span class="svg-icon svg-icon-2x svg-icon-info">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
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
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path
                          d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z"
                          fill="#000000"
                          opacity="0.3"
                        ></path>
                        <path
                          d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z"
                          fill="#000000"
                        ></path>
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                  <span
                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block"
                    >{{ totalassetcount }}</span
                  >
                  <span class="font-weight-bold text-muted font-size-sm"
                    >Total Assets</span
                  >
                </div>
                <!--end::Body-->
              </div>
              <!--end::Stats Widget 29-->
            </div>
            <div class="col-xl-3">
              <!--begin::Stats Widget 30-->
              <div class="card card-custom bg-info card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                  <span class="svg-icon svg-icon-2x svg-icon-white">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
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
                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        <path
                          d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                          fill="#000000"
                          fill-rule="nonzero"
                          opacity="0.3"
                        ></path>
                        <path
                          d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                          fill="#000000"
                          fill-rule="nonzero"
                        ></path>
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                  <span
                    class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block"
                    >{{ currencyFormatter(totalspendingcount) }}</span
                  >
                  <span class="font-weight-bold text-white font-size-sm"
                    >Total Spending</span
                  >
                </div>
                <!--end::Body-->
              </div>
              <!--end::Stats Widget 30-->
            </div>
            <div class="col-xl-3">
              <!--begin::Stats Widget 31-->
              <div class="card card-custom bg-danger card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                  <span class="svg-icon svg-icon-2x svg-icon-white">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
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
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <rect
                          fill="#000000"
                          opacity="0.3"
                          x="13"
                          y="4"
                          width="3"
                          height="16"
                          rx="1.5"
                        ></rect>
                        <rect
                          fill="#000000"
                          x="8"
                          y="9"
                          width="3"
                          height="11"
                          rx="1.5"
                        ></rect>
                        <rect
                          fill="#000000"
                          x="18"
                          y="11"
                          width="3"
                          height="9"
                          rx="1.5"
                        ></rect>
                        <rect
                          fill="#000000"
                          x="3"
                          y="13"
                          width="3"
                          height="7"
                          rx="1.5"
                        ></rect>
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                  <span
                    class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block"
                    >{{ totalsoldcount }}</span
                  >
                  <span class="font-weight-bold text-white font-size-sm"
                    >Total Quantity Sold</span
                  >
                </div>
                <!--end::Body-->
              </div>
              <!--end::Stats Widget 31-->
            </div>
            <div class="col-xl-3">
              <!--begin::Stats Widget 32-->
              <div class="card card-custom bg-dark card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                  <span class="svg-icon svg-icon-2x svg-icon-white">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
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
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path
                          d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z"
                          fill="#000000"
                        ></path>
                        <path
                          d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z"
                          fill="#000000"
                          opacity="0.3"
                        ></path>
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                  <span
                    class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 text-hover-primary d-block"
                    >{{ totalrequestcount }}</span
                  >
                  <span class="font-weight-bold text-white font-size-sm"
                    >Total Quantity Request</span
                  >
                </div>
                <!--end::Body-->
              </div>
              <!--end::Stats Widget 32-->
            </div>
          </div>

          <!--begin::Row-->
          <div class="row">
            <div class="col-lg-6 col-xxl-4">
              <!--begin::Tiles Widget 1-->
              <div class="card card-custom gutter-b card-stretch">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                  <div class="card-title">
                    <div class="card-label">
                      <div class="font-weight-bolder">Weekly Sales Stats</div>
                      <div class="font-size-sm text-muted mt-2">
                        890,344 Sales
                      </div>
                    </div>
                  </div>
                  <div class="card-toolbar">
                    <div class="dropdown dropdown-inline">
                      <a
                        href="#"
                        class="btn btn-clean btn-sm btn-icon"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        <i class="ki ki-bold-more-hor"></i>
                      </a>
                      <div
                        class="dropdown-menu dropdown-menu-md dropdown-menu-right"
                      >
                        <!--begin::Navigation-->
                        <ul class="navi navi-hover py-5">
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="flaticon2-drop"></i>
                              </span>
                              <span class="navi-text">New Group</span>
                            </a>
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="flaticon2-list-3"></i>
                              </span>
                              <span class="navi-text">Contacts</span>
                            </a>
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="flaticon2-rocket-1"></i>
                              </span>
                              <span class="navi-text">Groups</span>
                              <span class="navi-link-badge">
                                <span
                                  class="label label-light-primary label-inline font-weight-bold"
                                  >new</span
                                >
                              </span>
                            </a>
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="flaticon2-bell-2"></i>
                              </span>
                              <span class="navi-text">Calls</span>
                            </a>
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="flaticon2-gear"></i>
                              </span>
                              <span class="navi-text">Settings</span>
                            </a>
                          </li>
                          <li class="navi-separator my-3"></li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="flaticon2-magnifier-tool"></i>
                              </span>
                              <span class="navi-text">Help</span>
                            </a>
                          </li>
                          <li class="navi-item">
                            <a href="#" class="navi-link">
                              <span class="navi-icon">
                                <i class="flaticon2-bell-2"></i>
                              </span>
                              <span class="navi-text">Privacy</span>
                              <span class="navi-link-badge">
                                <span
                                  class="label label-light-danger label-rounded font-weight-bold"
                                  >5</span
                                >
                              </span>
                            </a>
                          </li>
                        </ul>
                        <!--end::Navigation-->
                      </div>
                    </div>
                  </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body d-flex flex-column px-0">
                  <!--begin::Chart-->
                  <div
                    id="kt_tiles_widget_1_chart"
                    data-color="danger"
                    style="height: 125px"
                  ></div>
                  <!--end::Chart-->
                  <!--begin::Items-->
                  <div class="flex-grow-1 card-spacer-x">
                    <!--begin::Item-->
                    <div
                      class="d-flex align-items-center justify-content-between mb-10"
                    >
                      <div class="d-flex align-items-center mr-2">
                        <div
                          class="symbol symbol-50 symbol-light mr-3 flex-shrink-0"
                        >
                          <div class="symbol-label">
                            <img
                              src="assets/media/svg/misc/006-plurk.svg"
                              alt=""
                              class="h-50"
                            />
                          </div>
                        </div>
                        <div>
                          <a
                            href="#"
                            class="font-size-h6 text-dark-75 text-hover-primary font-weight-bolder"
                            >Top Authors</a
                          >
                          <div
                            class="font-size-sm text-muted font-weight-bold mt-1"
                          >
                            Ricky Hunt, Sandra Trepp
                          </div>
                        </div>
                      </div>
                      <div
                        class="label label-light label-inline font-weight-bold text-dark-50 py-4 px-3 font-size-base"
                      >
                        +105$
                      </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div
                      class="d-flex align-items-center justify-content-between mb-10"
                    >
                      <div class="d-flex align-items-center mr-2">
                        <div
                          class="symbol symbol-50 symbol-light mr-3 flex-shrink-0"
                        >
                          <div class="symbol-label">
                            <img
                              src="assets/media/svg/misc/015-telegram.svg"
                              alt=""
                              class="h-50"
                            />
                          </div>
                        </div>
                        <div>
                          <a
                            href="#"
                            class="font-size-h6 text-dark-75 text-hover-primary font-weight-bolder"
                            >Bestsellers</a
                          >
                          <div
                            class="font-size-sm text-muted font-weight-bold mt-1"
                          >
                            Pitstop Email Marketing
                          </div>
                        </div>
                      </div>
                      <div
                        class="label label-light label-inline font-weight-bold text-dark-50 py-4 px-3 font-size-base"
                      >
                        +60$
                      </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div
                      class="d-flex align-items-center justify-content-between"
                    >
                      <div class="d-flex align-items-center mr-2">
                        <div
                          class="symbol symbol-50 symbol-light mr-3 flex-shrink-0"
                        >
                          <div class="symbol-label">
                            <img
                              src="assets/media/svg/misc/003-puzzle.svg"
                              alt=""
                              class="h-50"
                            />
                          </div>
                        </div>
                        <div>
                          <a
                            href="#"
                            class="font-size-h6 text-dark-75 text-hover-primary font-weight-bolder"
                            >Top Engagement</a
                          >
                          <div
                            class="font-size-sm text-muted font-weight-bold mt-1"
                          >
                            KT.com solution provider
                          </div>
                        </div>
                      </div>
                      <div
                        class="label label-light label-inline font-weight-bold text-dark-50 py-4 px-3 font-size-base"
                      >
                        +75$
                      </div>
                    </div>
                    <!--end::Item-->
                  </div>
                  <!--end::Items-->
                </div>
                <!--end::Body-->
              </div>
              <!--end::Tiles Widget 1-->
            </div>
            <div class="col-lg-6 col-xxl-8">
              <!--begin::Advance Table Widget 1-->
              <div class="card card-custom card-stretch gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 py-5">
                  <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark"
                      >Agents Stats</span
                    >
                    <span class="text-muted mt-3 font-weight-bold font-size-sm"
                      >More than 400+ new members</span
                    >
                  </h3>
                  <div class="card-toolbar">
                    <a
                      href="#"
                      class="btn btn-success font-weight-bolder font-size-sm"
                    >
                      <span class="svg-icon svg-icon-md svg-icon-white">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
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
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                              d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                              fill="#000000"
                              fill-rule="nonzero"
                              opacity="0.3"
                            />
                            <path
                              d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                              fill="#000000"
                              fill-rule="nonzero"
                            />
                          </g>
                        </svg>
                        <!--end::Svg Icon--> </span
                      >Add New Member</a
                    >
                  </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-0">
                  <!--begin::Table-->
                  <div class="table-responsive">
                    <table
                      class="table table-head-custom table-vertical-center"
                      id="kt_advance_table_widget_1"
                    >
                      <thead>
                        <tr class="text-left">
                          <th class="pl-0" style="width: 20px">
                            <label class="checkbox checkbox-lg checkbox-inline">
                              <input type="checkbox" value="1" />
                              <span></span>
                            </label>
                          </th>
                          <th class="pr-0" style="width: 50px">authors</th>
                          <th style="min-width: 200px"></th>
                          <th style="min-width: 150px">company</th>
                          <th style="min-width: 150px">progress</th>
                          <th class="pr-0 text-right" style="min-width: 150px">
                            action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="pl-0">
                            <label class="checkbox checkbox-lg checkbox-inline">
                              <input type="checkbox" value="1" />
                              <span></span>
                            </label>
                          </td>
                          <td class="pr-0">
                            <div class="symbol symbol-50 symbol-light mt-1">
                              <span class="symbol-label">
                                <img
                                  src="assets/media/svg/avatars/001-boy.svg"
                                  class="h-75 align-self-end"
                                  alt=""
                                />
                              </span>
                            </div>
                          </td>
                          <td class="pl-0">
                            <a
                              href="#"
                              class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"
                              >Brad Simmons</a
                            >
                            <span
                              class="text-muted font-weight-bold text-muted d-block"
                              >HTML, JS, ReactJS</span
                            >
                          </td>
                          <td>
                            <span
                              class="text-dark-75 font-weight-bolder d-block font-size-lg"
                              >Intertico</span
                            >
                            <span class="text-muted font-weight-bold"
                              >Web, UI/UX Design</span
                            >
                          </td>
                          <td>
                            <div class="d-flex flex-column w-100 mr-2">
                              <div
                                class="d-flex align-items-center justify-content-between mb-2"
                              >
                                <span
                                  class="text-muted mr-2 font-size-sm font-weight-bold"
                                  >65%</span
                                >
                                <span
                                  class="text-muted font-size-sm font-weight-bold"
                                  >Progress</span
                                >
                              </div>
                              <div class="progress progress-xs w-100">
                                <div
                                  class="progress-bar bg-danger"
                                  role="progressbar"
                                  style="width: 65%"
                                  aria-valuenow="50"
                                  aria-valuemin="0"
                                  aria-valuemax="100"
                                ></div>
                              </div>
                            </div>
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
                            <a
                              href="#"
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
                            </a>
                            <a
                              href="#"
                              class="btn btn-icon btn-light btn-hover-primary btn-sm"
                            >
                              <span
                                class="svg-icon svg-icon-md svg-icon-primary"
                              >
                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
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
                                      d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                      fill="#000000"
                                      fill-rule="nonzero"
                                    />
                                    <path
                                      d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                      fill="#000000"
                                      opacity="0.3"
                                    />
                                  </g>
                                </svg>
                                <!--end::Svg Icon-->
                              </span>
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <td class="pl-0">
                            <label class="checkbox checkbox-lg checkbox-inline">
                              <input type="checkbox" value="1" />
                              <span></span>
                            </label>
                          </td>
                          <td class="pr-0">
                            <div class="symbol symbol-50 symbol-light mt-1">
                              <span class="symbol-label">
                                <img
                                  src="assets/media/svg/avatars/018-girl-9.svg"
                                  class="h-75 align-self-end"
                                  alt=""
                                />
                              </span>
                            </div>
                          </td>
                          <td class="pl-0">
                            <a
                              href="#"
                              class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"
                              >Jessie Clarcson</a
                            >
                            <span
                              class="text-muted font-weight-bold text-muted d-block"
                              >C#, ASP.NET, MS SQL</span
                            >
                          </td>
                          <td>
                            <span
                              class="text-dark-75 font-weight-bolder d-block font-size-lg"
                              >Agoda</span
                            >
                            <span class="text-muted font-weight-bold"
                              >Houses &amp; Hotels</span
                            >
                          </td>
                          <td>
                            <div class="d-flex flex-column w-100 mr-2">
                              <div
                                class="d-flex align-items-center justify-content-between mb-2"
                              >
                                <span
                                  class="text-muted mr-2 font-size-sm font-weight-bold"
                                  >83%</span
                                >
                                <span
                                  class="text-muted font-size-sm font-weight-bold"
                                  >Progress</span
                                >
                              </div>
                              <div class="progress progress-xs w-100">
                                <div
                                  class="progress-bar bg-success"
                                  role="progressbar"
                                  style="width: 83%"
                                  aria-valuenow="50"
                                  aria-valuemin="0"
                                  aria-valuemax="100"
                                ></div>
                              </div>
                            </div>
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
                            <a
                              href="#"
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
                            </a>
                            <a
                              href="#"
                              class="btn btn-icon btn-light btn-hover-primary btn-sm"
                            >
                              <span
                                class="svg-icon svg-icon-md svg-icon-primary"
                              >
                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
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
                                      d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                      fill="#000000"
                                      fill-rule="nonzero"
                                    />
                                    <path
                                      d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                      fill="#000000"
                                      opacity="0.3"
                                    />
                                  </g>
                                </svg>
                                <!--end::Svg Icon-->
                              </span>
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <td class="pl-0">
                            <label class="checkbox checkbox-lg checkbox-inline">
                              <input type="checkbox" value="1" />
                              <span></span>
                            </label>
                          </td>
                          <td class="pr-0">
                            <div class="symbol symbol-50 symbol-lightv mt-1">
                              <span class="symbol-label">
                                <img
                                  src="assets/media/svg/avatars/047-girl-25.svg"
                                  class="h-75 align-self-end"
                                  alt=""
                                />
                              </span>
                            </div>
                          </td>
                          <td class="pl-0">
                            <a
                              href="#"
                              class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"
                              >Lebron Wayde</a
                            >
                            <span
                              class="text-muted font-weight-bold text-muted d-block"
                              >PHP, Laravel, VueJS</span
                            >
                          </td>
                          <td>
                            <span
                              class="text-dark-75 font-weight-bolder d-block font-size-lg"
                              >RoadGee</span
                            >
                            <span class="text-muted font-weight-bold"
                              >Transportation</span
                            >
                          </td>
                          <td>
                            <div class="d-flex flex-column w-100 mr-2">
                              <div
                                class="d-flex align-items-center justify-content-between mb-2"
                              >
                                <span
                                  class="text-muted mr-2 font-size-sm font-weight-bold"
                                  >47%</span
                                >
                                <span
                                  class="text-muted font-size-sm font-weight-bold"
                                  >Progress</span
                                >
                              </div>
                              <div class="progress progress-xs w-100">
                                <div
                                  class="progress-bar bg-primary"
                                  role="progressbar"
                                  style="width: 83%"
                                  aria-valuenow="50"
                                  aria-valuemin="0"
                                  aria-valuemax="100"
                                ></div>
                              </div>
                            </div>
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
                            <a
                              href="#"
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
                            </a>
                            <a
                              href="#"
                              class="btn btn-icon btn-light btn-hover-primary btn-sm"
                            >
                              <span
                                class="svg-icon svg-icon-md svg-icon-primary"
                              >
                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
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
                                      d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                      fill="#000000"
                                      fill-rule="nonzero"
                                    />
                                    <path
                                      d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                      fill="#000000"
                                      opacity="0.3"
                                    />
                                  </g>
                                </svg>
                                <!--end::Svg Icon-->
                              </span>
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <td class="pl-0">
                            <label class="checkbox checkbox-lg checkbox-inline">
                              <input type="checkbox" value="1" />
                              <span></span>
                            </label>
                          </td>
                          <td class="pr-0">
                            <div class="symbol symbol-50 symbol-light mt-1">
                              <span class="symbol-label">
                                <img
                                  src="assets/media/svg/avatars/014-girl-7.svg"
                                  class="h-75 align-self-end"
                                  alt=""
                                />
                              </span>
                            </div>
                          </td>
                          <td class="pl-0">
                            <a
                              href="#"
                              class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"
                              >Natali Trump</a
                            >
                            <span
                              class="text-muted font-weight-bold text-muted d-block"
                              >Python, PostgreSQL, ReactJS</span
                            >
                          </td>
                          <td>
                            <span
                              class="text-dark-75 font-weight-bolder d-block font-size-lg"
                              >The Hill</span
                            >
                            <span class="text-muted font-weight-bold"
                              >Insurance</span
                            >
                          </td>
                          <td>
                            <div class="d-flex flex-column w-100 mr-2">
                              <div
                                class="d-flex align-items-center justify-content-between mb-2"
                              >
                                <span
                                  class="text-muted mr-2 font-size-sm font-weight-bold"
                                  >71%</span
                                >
                                <span
                                  class="text-muted font-size-sm font-weight-bold"
                                  >Progress</span
                                >
                              </div>
                              <div class="progress progress-xs w-100">
                                <div
                                  class="progress-bar bg-danger"
                                  role="progressbar"
                                  style="width: 71%"
                                  aria-valuenow="50"
                                  aria-valuemin="0"
                                  aria-valuemax="100"
                                ></div>
                              </div>
                            </div>
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
                            <a
                              href="#"
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
                            </a>
                            <a
                              href="#"
                              class="btn btn-icon btn-light btn-hover-primary btn-sm"
                            >
                              <span
                                class="svg-icon svg-icon-md svg-icon-primary"
                              >
                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
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
                                      d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                      fill="#000000"
                                      fill-rule="nonzero"
                                    />
                                    <path
                                      d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                      fill="#000000"
                                      opacity="0.3"
                                    />
                                  </g>
                                </svg>
                                <!--end::Svg Icon-->
                              </span>
                            </a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!--end::Table-->
                </div>
                <!--end::Body-->
              </div>
              <!--end::Advance Table Widget 1-->
            </div>
          </div>
          <!--end::Row-->

          <!--end::Dashboard-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::Entry-->
    </div>
    <!--end::Content-->
  </BasicLayout>
</template>

