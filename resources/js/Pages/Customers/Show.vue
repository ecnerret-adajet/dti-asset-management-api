<script setup>
import { ref, onMounted, watch } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import BasicLayout from "../../Layouts/BasicLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";

// api
import CustomersApi from "../../Api/CustomersApi";

const customerService = new CustomersApi();

const props = defineProps({
  customer: Object,
  orders: Object,
  filters: Object,
});

const totalCost = ref(0);
const errors = ref(null);

const fetchTotalCustomerCost = () => {
    customerService.totalCost(props.customer.id)
     .then(res => {
        totalCost.value = res.data
     })
     .catch(error => {
        errors.null = error
     })
}

const currencyFormatter = (amount) => {
  const currencyAmount = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "PHP", // Change to your desired currency code (e.g., 'EUR' for Euro)
  });
  return currencyAmount.format(amount);
};

const form = useForm({
  name: props.filters.asset_name,
  order_status_id: props.filters.order_status_id,
});

watch(
  () => form,
  throttle(() => {
    router.get(`/accounts/customers/${props.customer.id}`, pickBy(form), {
      preserveState: true,
    });
  }, 150),
  { deep: true }
);

onMounted(() => {
    fetchTotalCustomerCost()
});

</script>
<template>
  <BasicLayout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
      <!--begin::Entry-->
      <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
          <!--begin::Card-->
          <div class="card card-custom gutter-b">
            <div class="card-body">
              <div class="d-flex">
                <!--begin: Pic-->
                <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                  <div class="symbol symbol-50 symbol-lg-120">
                    <span
                          class="symbol-label font-size-h3 font-weight-boldest"
                          >{{ customer.name[0] }}
                    </span>
                  </div>
                  <div
                    class="symbol symbol-50 symbol-lg-120 symbol-primary d-none"
                  >
                    <span class="font-size-h3 symbol-label font-weight-boldest"
                      >JM</span
                    >
                  </div>
                </div>
                <!--end: Pic-->
                <!--begin: Info-->
                <div class="flex-grow-1">
                  <!--begin: Title-->
                  <div
                    class="d-flex align-items-center justify-content-between flex-wrap"
                  >
                    <div class="mr-3">
                      <!--begin::Name-->
                      <a
                        href="#"
                        class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3"
                        >{{ customer.name }}
                        <i
                          class="flaticon2-correct text-success icon-md ml-2"
                        ></i
                      ></a>
                      <!--end::Name-->
                      <!--begin::Contacts-->
                      <div class="d-flex flex-wrap my-2">
                        <a
                          href="#"
                          class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"
                        >
                          <span
                            class="svg-icon svg-icon-md svg-icon-gray-500 mr-1"
                          >
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
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
                                  d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                  fill="#000000"
                                />
                                <circle
                                  fill="#000000"
                                  opacity="0.3"
                                  cx="19.5"
                                  cy="17.5"
                                  r="2.5"
                                />
                              </g>
                            </svg>
                            <!--end::Svg Icon--> </span
                          >{{ customer.email }}</a
                        >
                        <a
                          href="#"
                          class="text-muted text-hover-primary font-weight-bold"
                        >
                          <span
                            class="svg-icon svg-icon-md svg-icon-gray-500 mr-1"
                          >
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Marker2.svg-->
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
                                  d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z"
                                  fill="#000000"
                                />
                              </g>
                            </svg>
                            <!--end::Svg Icon--> </span
                          >{{ customer.address }}</a
                        >
                      </div>
                      <!--end::Contacts-->
                    </div>
                  </div>
                  <!--end: Title-->
                  <!--begin: Content-->
                  <div
                    class="d-flex align-items-center flex-wrap justify-content-between"
                  >
                    <div
                      class="flex-grow-1 font-weight-bold text-dark-50 py-5 py-lg-2 mr-5"
                    >
                      I distinguish three main text objectives could be merely
                      to inform people. <br />A second could be persuade people.
                      You want people to bay objective.
                    </div>
                  </div>
                  <!--end: Content-->
                </div>
                <!--end: Info-->
              </div>
              <div class="separator separator-solid my-7"></div>
              <!--begin: Items-->
              <div class="d-flex align-items-center flex-wrap">
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                  <span class="mr-4">
                    <i
                      class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"
                    ></i>
                  </span>
                  <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm"
                      >Earnings</span
                    >
                    <span class="font-weight-bolder font-size-h5">
                      {{ currencyFormatter(totalCost) }}</span
                    >
                  </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <!-- <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                  <span class="mr-4">
                    <i
                      class="flaticon-confetti icon-2x text-muted font-weight-bold"
                    ></i>
                  </span>
                  <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm"
                      >Expenses</span
                    >
                    <span class="font-weight-bolder font-size-h5">
                      <span class="text-dark-50 font-weight-bold">$</span
                      >164,700</span
                    >
                  </div>
                </div> -->
                <!--end: Item-->
                <!--begin: Item-->
                <!-- <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                  <span class="mr-4">
                    <i
                      class="flaticon-pie-chart icon-2x text-muted font-weight-bold"
                    ></i>
                  </span>
                  <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm">Net</span>
                    <span class="font-weight-bolder font-size-h5">
                      <span class="text-dark-50 font-weight-bold">$</span
                      >782,300</span
                    >
                  </div>
                </div> -->
                <!--end: Item-->
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                  <span class="mr-4">
                    <i
                      class="flaticon-file-2 icon-2x text-muted font-weight-bold"
                    ></i>
                  </span>
                  <div class="d-flex flex-column flex-lg-fill">
                    <span class="text-dark-75 font-weight-bolder font-size-sm"
                      >{{ orders.total }} Orders</span
                    >
                    <!-- <a href="#" class="text-primary font-weight-bolder">View</a> -->
                  </div>
                </div>
                <!--end: Item-->
              </div>
              <!--begin: Items-->
            </div>
          </div>
          <!--end::Card-->

          <!--begin::Row-->
          <div class="row">
            <div class="col-lg-8">
              <!--begin::Advance Table Widget 3-->
              <div class="card card-custom card-stretch gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 py-5">
                  <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark"
                      >Order List</span
                    >
                    <span class="text-muted mt-3 font-weight-bold font-size-sm"
                      >Customer's orders</span
                    >
                  </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-0 pb-3">

                  <!--begin::Table-->
                  <div class="table-responsive">
                    <table
                      class="table table-head-custom table-vertical-center table-head-bg table-borderless"
                      id="kt_advance_table_widget_1"
                    >
                      <thead>
                        <tr class="text-left">
                          <th class="pr-0" style="width: 100px">Oder Id</th>
                          <th class="pr-0" style="width: 300px">Customer</th>
                          <th style="min-width: 150px">Total Item</th>
                          <th style="min-width: 150px">Total Cost</th>
                          <th style="min-width: 150px">Created By</th>
                          <th style="min-width: 150px">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(order, l) in orders.data" :key="l">
                          <td class="pr-2">
                            <span class="text-capitalize">
                              {{ order.order_reference }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ order.customer.name }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ order.total_orders }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ currencyFormatter(order.total_cost) }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ order.user.name }}
                            </span>
                          </td>
                          <td>
                            <span
                              :class="{
                                ' label-light-info ':
                                  order.order_status.id === 1,
                                ' label-light-primary ':
                                  order.order_status.id === 2,
                                ' label-light-success ':
                                  order.order_status.id === 3,
                                ' label-light-danger ':
                                  order.order_status.id === 4,
                              }"
                              class="label label-lg font-weight-bold text-capitalize label-inline"
                              >{{ order.order_status.name }}</span
                            >
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!--begin::Pagination-->
                    <Pagination class="mt-6" :links="orders.links" />
                    <!--end::Pagination-->
                  </div>
                  <!--end::Table-->
                </div>
                <!--end::Body-->
              </div>
              <!--end::Advance Table Widget 3-->
            </div>
            <div class="col-lg-4">
              <!--begin::Charts Widget 3-->
              <div class="card card-custom card-stretch gutter-b">
                <!--begin::Header-->
                <div class="card-header h-auto border-0">
                  <div class="card-title py-5">
                    <h3 class="card-label">
                      <span class="d-block text-dark font-weight-bolder"
                        >Recent Orders</span
                      >
                      <span class="d-block text-muted mt-2 font-size-sm"
                        >More than 500+ new orders</span
                      >
                    </h3>
                  </div>
                  <div class="card-toolbar">
                    <ul
                      class="nav nav-pills nav-pills-sm nav-dark-75"
                      role="tablist"
                    >
                      <li class="nav-item">
                        <a
                          class="nav-link py-2 px-4"
                          data-toggle="tab"
                          href="#kt_charts_widget_2_chart_tab_1"
                        >
                          <span class="nav-text font-size-sm">Month</span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a
                          class="nav-link py-2 px-4"
                          data-toggle="tab"
                          href="#kt_charts_widget_2_chart_tab_2"
                        >
                          <span class="nav-text font-size-sm">Week</span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a
                          class="nav-link py-2 px-4 active"
                          data-toggle="tab"
                          href="#kt_charts_widget_2_chart_tab_3"
                        >
                          <span class="nav-text font-size-sm">Day</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                  <div id="kt_charts_widget_3_chart"></div>
                </div>
                <!--end::Body-->
              </div>
              <!--end::Charts Widget 3-->
            </div>
          </div>
          <!--end::Row-->
        </div>
      </div>
    </div>
  </BasicLayout>
</template>
