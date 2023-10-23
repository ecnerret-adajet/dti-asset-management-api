<script setup>
import BasicLayout from "../../Layouts/BasicLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import SubHeader from "../../Components/SubHeader.vue";
import { ref, watch, computed } from "vue";
import { router, Link, useForm } from "@inertiajs/vue3";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";

const props = defineProps({
  customers: Object,
  filters: Object,
});

const form = useForm({
  name: props.filters.name,
});

const breadcrumbs = ref([
  { id: 1, name: "Accounts", url: "/accounts" },
  { id: 2, name: "Customers", url: "/accounts/customers" },
]);

const columnsPerRow = ref(3);

const rows = computed(() => {
  const rowCount = Math.ceil(props.customers.data.length / columnsPerRow.value);
  return new Array(rowCount).fill([]);
});

const getItemsInRow = (rowIndex) => {
  const start = rowIndex * columnsPerRow.value;
  const end = start + columnsPerRow.value;
  return props.customers.data.slice(start, end);
};

watch(
  () => form,
  throttle(() => {
    router.get("/accounts/customers", pickBy(form), {
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
      <!-- sub header -->
      <SubHeader title="Customers" :breadcrumbs="breadcrumbs" />
      <!-- end subheader -->
      <!--begin::Entry-->
      <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
          <form class="d-flex position-relative mb-8">
            <div class="input-group">
              <!--begin::Icon-->
              <div class="input-group-prepend">
                <span class="input-group-text bg-white border-0">
                  <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
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
                          d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                          fill="#000000"
                          fill-rule="nonzero"
                          opacity="0.3"
                        ></path>
                        <path
                          d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                          fill="#000000"
                          fill-rule="nonzero"
                        ></path>
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                </span>
              </div>
              <!--end::Icon-->
              <!--begin::Input-->
              <input
                type="text"
                v-model="form.name"
                class="form-control h-auto border-0 py-4 px-1 font-size-h6"
                placeholder="Search a customer..."
              />
              <!--end::Input-->
            </div>
            <Link
              href="/accounts/customers/create"
              class="btn btn-primary btn-lg font-weight-bold ml-4 py-3 px-6"
              >Create</Link
            >
          </form>

          <!--begin::Row-->
          <div v-for="(row, rowIndex) in rows" :key="rowIndex" class="row">
            <div
              v-for="(item, colIndex) in getItemsInRow(rowIndex)"
              :key="colIndex"
              class="col-xl-4"
            >
              <!--begin::Card-->
              <div class="card card-custom gutter-b card-stretch">
                <!--begin::Body-->
                <div class="card-body">
                  <!--begin::Info-->
                  <div class="d-flex align-items-center">
                    <!--begin::Pic-->
                    <div
                      class="flex-shrink-0 mr-4 symbol symbol-60 symbol-circle"
                    >
                      <div class="symbol symbol-lg-75 symbol-primary">
                        <span
                          class="symbol-label font-size-h3 font-weight-boldest"
                          >{{ item.name[0] }}</span
                        >
                      </div>
                    </div>
                    <!--end::Pic-->
                    <!--begin::Info-->
                    <div class="d-flex flex-column mr-auto">
                      <!--begin: Title-->
                      <div class="d-flex flex-column mr-auto">
                        <Link
                          :href="`/accounts/customers/${item.id}`"
                          class="text-dark text-hover-primary font-size-h4 font-weight-bolder mb-1"
                          >{{ item.name }}</Link
                        >
                        <span class="text-muted font-weight-bold"
                          >Creates Limitless possibilities</span
                        >
                      </div>
                      <!--end::Title-->
                    </div>
                    <!--end::Info-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar mb-7">
                      <div
                        class="dropdown dropdown-inline"
                        data-toggle="tooltip"
                        title="Quick actions"
                        data-placement="left"
                      >
                        <a
                          href="#"
                          class="btn btn-clean btn-hover-light-primary btn-sm btn-icon"
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div
                          class="dropdown-menu dropdown-menu-sm dropdown-menu-right"
                        >
                          <!--begin::Navigation-->
                          <ul class="navi navi-hover">
                            <li class="navi-header pb-1">
                              <span
                                class="text-primary text-uppercase font-weight-bold font-size-sm"
                                >Add new:</span
                              >
                            </li>
                            <li class="navi-item">
                              <a href="#" class="navi-link">
                                <span class="navi-icon">
                                  <i class="flaticon2-shopping-cart-1"></i>
                                </span>
                                <span class="navi-text">Order</span>
                              </a>
                            </li>
                            <li class="navi-item">
                              <a href="#" class="navi-link">
                                <span class="navi-icon">
                                  <i class="flaticon2-calendar-8"></i>
                                </span>
                                <span class="navi-text">Event</span>
                              </a>
                            </li>
                            <li class="navi-item">
                              <a href="#" class="navi-link">
                                <span class="navi-icon">
                                  <i class="flaticon2-graph-1"></i>
                                </span>
                                <span class="navi-text">Report</span>
                              </a>
                            </li>
                            <li class="navi-item">
                              <a href="#" class="navi-link">
                                <span class="navi-icon">
                                  <i class="flaticon2-rocket-1"></i>
                                </span>
                                <span class="navi-text">Post</span>
                              </a>
                            </li>
                            <li class="navi-item">
                              <a href="#" class="navi-link">
                                <span class="navi-icon">
                                  <i class="flaticon2-writing"></i>
                                </span>
                                <span class="navi-text">File</span>
                              </a>
                            </li>
                          </ul>
                          <!--end::Navigation-->
                        </div>
                      </div>
                    </div>
                    <!--end::Toolbar-->
                  </div>
                  <!--end::Info-->
                  <!--begin::Description-->
                  <div class="mb-10 mt-5 font-weight-bold">
                    I distinguish three main text objectives.First, your
                    objective could be merely to inform people.A second be to
                    persuade people.
                  </div>
                  <!--end::Description-->

                  <!--end::Data-->
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer d-flex align-items-center">
                  <div class="d-flex">
                    <div class="d-flex align-items-center mr-7">
                      <span class="svg-icon svg-icon-gray-500">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Text/Bullet-list.svg-->
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
                              d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z"
                              fill="#000000"
                            />
                            <path
                              d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z"
                              fill="#000000"
                              opacity="0.3"
                            />
                          </g>
                        </svg>
                        <!--end::Svg Icon-->
                      </span>
                      <a href="#" class="font-weight-bolder text-primary ml-2"
                        >72 Orders</a
                      >
                    </div>
                  </div>
                </div>
                <!--end::Footer-->
              </div>
              <!--end:: Card-->
            </div>
          </div>
          <!--end::Row-->
          <!--begin::Pagination-->
          <Pagination class="mt-6" :links="customers.links" />
          <!--end::Pagination-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::Entry-->
    </div>
    <!--end::Content-->
  </BasicLayout>
</template>
