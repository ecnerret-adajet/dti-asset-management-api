<script setup>
import { ref, watch, computed } from "vue";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { router, Link, useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import axios from "axios";
// layouts
import BasicLayout from "../Layouts/BasicLayout.vue";
import Pagination from "../Components/Pagination.vue";
import StockOutModal from "../Pages/Assets/StockOutModal.vue";
import ChangeLocationModal from '../Pages/Assets/ChangeLocationModal.vue'
import ReceivingCreateModal from "../Pages/Assets/ReceivingCreateModal.vue";
import AssetDetailsModal from "../Pages/Assets/AssetDetailsModal.vue";
import InventoryAsideFilter from "../Components/InventoryAsideFilter.vue";
import InventoryAsideRecent from "../Components/InventoryAsideRecent.vue";
import SubHeader from "../Components/SubHeader.vue";

const page = usePage();

const permissions = computed(() => page.props.auth.permissions);

const baseUrl = window.location.origin;

const show = ref(false);
const show_changeloc = ref(false);
const showAssetDetails = ref(false);
const isDeleting = ref(false);
const showImageModal = ref(false);
const zoomLevel = ref(1);
const selectedImagePath = ref('');
const isDragging = ref(false);
const startX = ref(0);
const startY = ref(0);
const translateX = ref(0);
const translateY = ref(0);

const selectedAsset = ref({});
const showImagePreview = ref(null);
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
  sort: props.filters.sort || '',
  direction: props.filters.direction || 'asc',
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

const openChangeLocModal = (item) => {
  selectedAsset.value = item;
  show_changeloc.value = !show_changeloc.value;
};

const openAssetDetailsModal = (item) => {
  selectedAsset.value = item;
  showAssetDetails.value = true;
};

const closeAssetDetailsModal = () => {
  showAssetDetails.value = false;
};

// Sorting functionality
const sort = (column) => {
  if (form.sort === column) {
    form.direction = form.direction === 'asc' ? 'desc' : 'asc';
  } else {
    form.sort = column;
    form.direction = 'asc';
  }
  
  router.get('/inventory', pickBy(form), {
    preserveState: true,
  });
};

// Helper function to determine sort icon class
const sortIconClass = (column) => {
  if (form.sort !== column) {
    return 'fa fa-sort text-muted';
  }
  
  return form.direction === 'asc' 
    ? 'fa fa-sort-up text-primary' 
    : 'fa fa-sort-down text-primary';
};

// Delete asset functionality
const confirmDelete = (asset) => {
  // Don't allow delete action if already deleting
  if (isDeleting.value) return;
  
  selectedAsset.value = asset;
  
  Swal.fire({
    title: 'Are you sure?',
    text: `Do you want to delete ${asset.name}?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      deleteAsset(asset);
    } else {
      // Reset selected asset if canceled
      selectedAsset.value = {};
    }
  });
};

const deleteAsset = (asset) => {
  isDeleting.value = true;
  
  // Use axios directly instead of Inertia router to have more control over the response
  axios.delete(`/inventory/${asset.id}`)
    .then(response => {
      isDeleting.value = false;
      
      // Show success message with SweetAlert
      Swal.fire({
        title: 'Deleted!',
        text: 'Asset has been deleted successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        // Refresh the page to update the asset list
        router.visit('/inventory', {
          only: ['assets'],
          preserveState: true,
          preserveScroll: true
        });
      });
    })
    .catch(error => {
      isDeleting.value = false;
      let errorMessage = 'There was a problem deleting the asset.';
      
      // Check for specific error messages from the backend
      const errors = error.response?.data;
      if (errors && errors.message) {
        errorMessage = errors.message;
      } else if (errors && errors.error) {
        errorMessage = errors.error;
      } else if (errors && typeof errors === 'object') {
        // Try to extract any error message from the errors object
        const firstError = Object.values(errors)[0];
        if (Array.isArray(firstError) && firstError.length > 0) {
          errorMessage = firstError[0];
        }
      }
      
      Swal.fire({
        title: 'Error!',
        text: errorMessage,
        icon: 'error',
        confirmButtonText: 'OK'
      });
      console.error('Delete asset error:', error);
    });
};

// Image modal functions
const openImageModal = (imagePath) => {
  selectedImagePath.value = imagePath;
  showImageModal.value = true;
  zoomLevel.value = 1; // Reset zoom level when opening modal
  translateX.value = 0; // Reset position
  translateY.value = 0;
  
  // Add keyboard event listener when modal opens
  setTimeout(() => {
    window.addEventListener('keydown', handleKeyDown);
  }, 100);
};

const closeImageModal = () => {
  showImageModal.value = false;
  selectedImagePath.value = '';
  // Remove keyboard event listener when modal closes
  window.removeEventListener('keydown', handleKeyDown);
};

const zoomIn = () => {
  if (zoomLevel.value < 3) { // Limit max zoom
    zoomLevel.value += 0.25;
  }
};

const zoomOut = () => {
  if (zoomLevel.value > 0.5) { // Limit min zoom
    zoomLevel.value -= 0.25;
  }
};

const resetZoom = () => {
  zoomLevel.value = 1;
  translateX.value = 0;
  translateY.value = 0;
};

// Handle keyboard shortcuts
const handleKeyDown = (event) => {
  if (!showImageModal.value) return;
  
  switch(event.key) {
    case '+': // Plus key
    case '=': // Equal key (usually same as plus without shift)
      zoomIn();
      event.preventDefault();
      break;
    case '-': // Minus key
      zoomOut();
      event.preventDefault();
      break;
    case '0': // Zero key
      resetZoom();
      event.preventDefault();
      break;
    case 'Escape': // Escape key
      closeImageModal();
      event.preventDefault();
      break;
    case 'ArrowUp': // Up arrow
      translateY.value += 20;
      event.preventDefault();
      break;
    case 'ArrowDown': // Down arrow
      translateY.value -= 20;
      event.preventDefault();
      break;
    case 'ArrowLeft': // Left arrow
      translateX.value += 20;
      event.preventDefault();
      break;
    case 'ArrowRight': // Right arrow
      translateX.value -= 20;
      event.preventDefault();
      break;
  }
};

// Mouse drag handlers for panning
const startDrag = (event) => {
  if (zoomLevel.value <= 1) return; // Only allow panning when zoomed in
  
  isDragging.value = true;
  startX.value = event.clientX;
  startY.value = event.clientY;
  event.preventDefault();
};

const doDrag = (event) => {
  if (!isDragging.value) return;
  
  const dx = event.clientX - startX.value;
  const dy = event.clientY - startY.value;
  
  translateX.value += dx;
  translateY.value += dy;
  
  startX.value = event.clientX;
  startY.value = event.clientY;
};

const endDrag = () => {
  isDragging.value = false;
};

// Handle mouse wheel for zooming
const handleWheel = (event) => {
  if (!showImageModal.value) return;
  
  // Prevent default scrolling behavior
  event.preventDefault();
  
  // Zoom in or out based on wheel direction
  if (event.deltaY < 0) {
    zoomIn();
  } else {
    zoomOut();
  }
};


</script>
<template>
  <BasicLayout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
      <!-- sub header -->
      <SubHeader
        title="Asset Inventory"
        button_name="New Asset"
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
                          <th class="pr-0" colspan="2" style="width: 300px; cursor: pointer;" @click="sort('name')">
                            Asset <i :class="sortIconClass('name')"></i>
                          </th>
                          <th style="cursor: pointer;" class="min-w-100px" @click="sort('current_value')">
                            Qty
                          </th>
                          <th class="min-w-150px cursor-pointer" @click="sort('location')">
                            Location <i :class="sortIconClass('location')"></i>
                          </th>
                          <th class="min-w-250px cursor-pointer" @click="sort('model')">
                            Model <i :class="sortIconClass('model')"></i>
                          </th> 
                          <th class="min-w-250px cursor-pointer" @click="sort('serial_number')">
                            Serial No. <i :class="sortIconClass('serial_number')"></i>
                          </th>
                          <th class="min-w-150px cursor-pointer" @click="sort('part_number')">
                            Part Number <i :class="sortIconClass('part_number')"></i>
                          </th>
                          <th class="min-w-150px cursor-pointer" @click="sort('status')">
                            Status 
                          </th>
                          <th class="min-w-150px cursor-pointer" @click="sort('asset_type')">
                            Type 
                          </th>
                          <th class="pr-0 text-right" style="min-width: 150px">
                            action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(asset, a) in assets.data" :key="a">
                          <td width="8%">
                            <div class="symbol symbol-50 symbol-light mt-1 position-relative">
                              <span class="symbol-label d-flex align-items-center justify-content-center">
                                <img
                                  :src="`${baseUrl}/${asset.image_path}`"
                                  class="h-75 w-75 object-fit-contain cursor-pointer"
                                  alt=""
                                  @mouseover="showImagePreview = asset.id"
                                  @mouseleave="showImagePreview = null"
                                  @click="openImageModal(asset.image_path)"
                                />
                              </span>
                              <!-- Image Preview on Hover -->
                              <div 
                                v-if="showImagePreview === asset.id" 
                                class="image-preview-popup"
                                @mouseover="showImagePreview = asset.id"
                                @mouseleave="showImagePreview = null"
                              >
                                <img 
                                  :src="`${baseUrl}/${asset.image_path}`" 
                                  alt="" 
                                  class="preview-image"
                                />
                              </div>
                            </div>
                          </td>
                          <td class="pl-2">
                            <a
                              href="javascript:void(0)"
                              class="text-capitalize font-size-lg mb-0 text-primary"
                              style="cursor: pointer;"
                              @click="openAssetDetailsModal(asset)"
                              >{{ asset.name }}
                            </a>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ asset.current_value }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ asset?.location.name }} / {{ asset.storage_location }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ asset.model }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ asset.serial_number }}
                            </span>
                          </td>
                          <td>
                            <span class="text-capitalize">
                              {{ asset.part_number ?? 'N/A' }}
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
                            <div v-if="permissions.includes('delete')" class="dropdown dropdown-inline">
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
                                    <a href="javascript:;" @click="openChangeLocModal(asset)" class="navi-link">
                                      <span class="navi-icon"
                                        ><i class="la la-file-excel-o"></i
                                      ></span>
                                      <span class="navi-text"
                                        >Update Location</span
                                      >
                                    </a>
                                  </li>
                                  <li class="navi-item">
                                    <a href="javascript:;" @click="confirmDelete(asset)" class="navi-link" :class="{ 'disabled': isDeleting }">
                                      <span class="navi-icon">
                                        <i v-if="isDeleting && selectedAsset.id === asset.id" class="la la-spinner fa-spin"></i>
                                        <i v-else class="la la-trash"></i>
                                      </span>
                                      <span class="navi-text text-danger">
                                        {{ isDeleting && selectedAsset.id === asset.id ? 'Deleting...' : 'Delete Asset' }}
                                      </span>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>

                            <Link v-if="permissions.includes('update')"
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

                            <Link
                              :href="`/inventory/${asset.id}/show`"
                              class="btn btn-sm btn-clean btn-icon mr-2"
                              title="View details"
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
                                      d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                      fill="#000000"
                                    ></path>
                                    <path
                                      d="M21.8182454,12.5337868 C21.9372347,12.4389891 22,12.3074878 22,12.1063301 C22,11.9051724 21.9372347,11.7736711 21.8182454,11.6788734 C20.3261282,10.4346733 16.4513941,7 12,7 C7.54860591,7 3.67387183,10.4346733 2.18175463,11.6788734 C2.06276526,11.7736711 2,11.9051724 2,12.1063301 C2,12.3074878 2.06276526,12.4389891 2.18175463,12.5337868 C3.67387183,13.7779869 7.54860591,17.2126602 12,17.2126602 C16.4513941,17.2126602 20.3261282,13.7779869 21.8182454,12.5337868 Z"
                                      fill="#000000"
                                      opacity="0.3"
                                    ></path>
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

    <change-location-modal
      unique_id="changeLocationModal"
      title="Change Location"
      :asset_id="selectedAsset.id"
      :asset="selectedAsset"
      :show="show_changeloc"
      :locations="locations"
      @onSuccess="selectedAsset = $event"
      @close="show_changeloc = $event"
    />
    
    <asset-details-modal
      :show="showAssetDetails"
      :asset="selectedAsset"
      @close="closeAssetDetailsModal"
      @openImageModal="openImageModal"
    />

    <!-- Image Modal -->
    <div v-if="showImageModal" class="image-modal-overlay" @click="closeImageModal">
      <div class="image-modal-content" @click.stop>
        <div class="image-modal-header">
          <div class="zoom-controls">
            <button @click="zoomOut" class="zoom-btn" title="Zoom Out">
              <i class="fa fa-search-minus"></i>
            </button>
            <button @click="resetZoom" class="zoom-btn" title="Reset Zoom">
              <i class="fa fa-undo"></i>
            </button>
            <button @click="zoomIn" class="zoom-btn" title="Zoom In">
              <i class="fa fa-search-plus"></i>
            </button>
          </div>
          <button @click="closeImageModal" class="close-btn">&times;</button>
        </div>
        <div class="image-modal-body" @wheel="handleWheel">
          <div 
            class="image-container"
            :style="{ transform: `translate(${translateX}px, ${translateY}px)` }"
            @mousedown="startDrag"
            @mousemove="doDrag"
            @mouseup="endDrag"
            @mouseleave="endDrag"
          >
            <img 
              :src="`${baseUrl}/${selectedImagePath}`" 
              :style="{ transform: `scale(${zoomLevel})` }" 
              class="modal-image"
              alt="Asset Image"
              draggable="false"
            />
          </div>
        </div>
      </div>
    </div>

  </BasicLayout>
</template>

<style scoped>
/* Image preview popup styling */
.position-relative {
  position: relative;
}

.object-fit-contain {
  object-fit: contain;
}

.cursor-pointer {
  cursor: pointer;
}

.image-preview-popup {
  cursor: pointer;
  position: absolute;
  top: -10px;
  left: 60px;
  z-index: 100;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  padding: 5px;
  transform: translateY(-50%);
}

.preview-image {
  width: 200px;
  height: 200px;
  object-fit: contain;
}

/* Sorting styles */
th i {
  margin-left: 5px;
}

.cursor-pointer {
  cursor: pointer;
}
</style>

<style>
/* Fix SweetAlert icon alignment */
.swal2-icon {
  margin: 1.25em auto 1.875em !important;
  justify-content: center !important;
  display: flex !important;
  align-items: center !important;
}

.swal2-icon .swal2-icon-content {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  width: 100% !important;
  height: 100% !important;
}

/* Ensure the success checkmark is centered */
.swal2-success-circular-line-left,
.swal2-success-circular-line-right,
.swal2-success-fix {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

/* Center the warning icon exclamation mark */
.swal2-icon.swal2-warning .swal2-icon-content,
.swal2-icon.swal2-error .swal2-icon-content,
.swal2-icon.swal2-info .swal2-icon-content,
.swal2-icon.swal2-question .swal2-icon-content {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  font-size: 3.75em !important;
}

/* Image Modal Styles */
.image-modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.image-modal-content {
  background-color: white;
  border-radius: 8px;
  width: 90%;
  max-width: 900px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.image-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #eee;
}

.zoom-controls {
  display: flex;
  gap: 10px;
}

.zoom-btn {
  background-color: #f8f9fa;
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px 10px;
  cursor: pointer;
  transition: all 0.2s;
}

.zoom-btn:hover {
  background-color: #e9ecef;
}

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #555;
}

.image-modal-body {
  padding: 20px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 70vh;
  position: relative;
}

.image-container {
  position: relative;
  transition: transform 0.1s ease;
}

.modal-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
  transition: transform 0.3s ease;
  user-select: none;
}
</style>
