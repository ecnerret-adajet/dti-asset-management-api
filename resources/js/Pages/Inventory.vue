<script setup>
import { ref, watch } from "vue";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { router, Link, useForm } from "@inertiajs/vue3";
// layouts
import BasicLayout from "../Layouts/BasicLayout.vue";
import Pagination from "../Components/Pagination.vue";
import StockOutModal from "../Pages/Assets/StockOutModal.vue";
import ReceivingCreateModal from "../Pages/Assets/ReceivingCreateModal.vue";
import InventoryAsideFilter from "../Components/InventoryAsideFilter.vue";
import InventoryAsideRecent from "../Components/InventoryAsideRecent.vue";
import SubHeader from "../Components/SubHeader.vue";

const baseUrl = window.location.origin;

const show = ref(false);
const selectedAsset = ref({});
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

const breadcrumbs = ref([{ id: 1, name: "Inventory", url: "/inventory" }]);

watch(
  () => form,
  throttle(() => {
    router.get("/inventory", pickBy(form), {
      preserveState: true,
    });
  }, 150),
  { deep: true }
);

const openModal = (item) => {
  selectedAsset.value = item;
  show.value = !show.value;
};
</script>
<template>
  <BasicLayout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
      <!-- sub header -->
      <SubHeader
        title="Asset Inventory"
        button_name="Add Record"
        button_link="/inventory/create"
        second_button_name="Add Order"
        second_button_link="/orders/create"
        :breadcrumbs="breadcrumbs"
      />
      <!-- end subheader -->
      <!--begin::Entry-->
      <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
          <!--begin::Teachers-->
          <div class="d-flex flex-row">
            <!-- aside position -->
            <div
              class="flex-column offcanvas-mobile w-300px w-xl-325px"
              id="kt_profile_aside"
            >
              <InventoryAsideFilter
                @onAssetTypes="asset_type = $event"
                @onLocations="location = $event"
              />

              <InventoryAsideRecent />
            </div>
            <!-- end aside position -->
            <!--begin::Content-->
            <div class="flex-row-fluid ml-lg-9">
              <!--begin::Card-->
              <div class="card card-custom">
                <!--begin::Body-->
                <div class="card-body">
                  <!--begin::Search Card-->
                  <div class="card card-custom gutter-b">
                    <div class="card-body rounded p-0 d-flex bg-light">
                      <div
                        class="d-flex flex-column flex-lg-row-auto w-auto w-lg-350px w-xl-450px w-xxl-650px py-10 py-md-14 px-10 px-md-20 pr-lg-0"
                      >
                        <h1 class="font-weight-bolder text-dark mb-0">
                          Search Items
                        </h1>
                        <div class="font-size-h4 mb-8">Find in an instant</div>
                        <!--begin::Form-->
                        <form
                          class="d-flex flex-center py-2 px-6 bg-white rounded"
                        >
                          <span class="svg-icon svg-icon-lg svg-icon-primary">
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
                          <input
                            type="text"
                            v-model="form.name"
                            class="form-control border-0 font-weight-bold pl-2"
                            placeholder="Search Asset"
                          />
                        </form>
                        <!--end::Form-->
                      </div>
                      <div
                        class="d-none d-md-flex flex-row-fluid bgi-no-repeat bgi-position-y-center bgi-position-x-left bgi-size-cover"
                        style="
                          background-image: url(assets/media/svg/illustrations/copy.svg);
                        "
                      ></div>
                    </div>
                  </div>
                  <!--End::Search Card-->

                  <!--begin::Table-->
                  <div class="table-responsive">
                    <table
                      class="table table-head-custom table-vertical-center"
                      id="kt_advance_table_widget_1"
                    >
                      <thead>
                        <tr class="text-left">
                          <th class="pr-0" colspan="2" style="width: 300px">
                            Asset
                          </th>
                          <th style="min-width: 50px">Qty</th>
                          <th style="min-width: 100px">Model</th>
                          <th style="min-width: 100px">Status</th>
                          <th style="min-width: 150px">Type</th>
                          <th class="pr-0 text-right" style="min-width: 150px">
                            action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(asset, a) in assets.data" :key="a">
                          <td width="8%">
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
                          <td class="pl-2">
                            <a
                              href="#"
                              class="text-capitalize text-dark-75 font-weight-bolder font-size-lg mb-0"
                              >{{ asset.name }}</a
                            >
                            <!-- <span
                              class="text-muted text-capitalize text-muted d-block"
                              >{{ asset.serial_number }}</span
                            > -->
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ asset.current_value }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ asset.model }}
                            </span>
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
                            <div class="dropdown dropdown-inline">
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
                                    <a
                                      href="javascript:;"
                                      @click="openModal(asset)"
                                      class="navi-link"
                                    >
                                      <span class="navi-icon"
                                        ><i class="la la-copy"></i
                                      ></span>
                                      <span class="navi-text"
                                        >Add to inventory</span
                                      >
                                    </a>
                                  </li>
                                  <li class="navi-item">
                                    <a href="#" class="navi-link">
                                      <span class="navi-icon"
                                        ><i class="la la-file-excel-o"></i
                                      ></span>
                                      <span class="navi-text"
                                        >Change Status</span
                                      >
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>

                            <Link
                              :href="`/inventory/${asset.id}`"
                              class="btn btn-sm btn-clean btn-icon mr-2"
                              title="Edit details"
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
                                      d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                      fill="#000000"
                                      fill-rule="nonzero"
                                      transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "
                                    ></path>
                                    <rect
                                      fill="#000000"
                                      opacity="0.3"
                                      x="5"
                                      y="20"
                                      width="15"
                                      height="2"
                                      rx="1"
                                    ></rect>
                                  </g>
                                </svg>
                              </span>
                            </Link>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!--end::Table-->

                  <!--begin::Pagination-->
                  <Pagination class="mt-6" :links="assets.links" />
                  <!--end::Pagination-->
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

    <receiving-create-modal
      unique_id="receivingsModal"
      title="Asset Request"
      :asset_id="selectedAsset.id"
      :asset="selectedAsset"
      :show="show"
      @onSuccess="selectedAsset = $event"
      @close="show = $event"
    />
  </BasicLayout>
</template>
