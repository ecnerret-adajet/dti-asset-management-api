<script setup>
import { ref, onMounted } from "vue";
import InventoryApi from "../Api/InventoryApi";

const inventoryService = new InventoryApi();

const recents = ref([]);
const error = ref(null);

const fetchRecentAssets = () => {
  return inventoryService
    .recent()
    .then((response) => {
      recents.value = response;
    })
    .catch((error) => {
      error.value = error;
    });
};

onMounted(() => {
    fetchRecentAssets();
});

</script>
<template>
  <!--begin::List Widget 21-->
  <div class="card card-custom gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
      <h3 class="card-title align-items-start flex-column mb-5">
        <span class="card-label font-weight-bolder text-dark mb-1"
          >Recent Products</span
        >
        <span class="text-muted mt-2 font-weight-bold font-size-sm"
          >New Arrivals</span
        >
      </h3>
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
          <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
            <!--begin::Navigation-->
            <ul class="navi navi-hover">
              <li class="navi-header font-weight-bold py-4">
                <span class="font-size-lg">Choose Label:</span>
                <i
                  class="flaticon2-information icon-md text-muted"
                  data-toggle="tooltip"
                  data-placement="right"
                  title=""
                  data-original-title="Click to learn more..."
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
                    <span class="label label-xl label-inline label-light-danger"
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
                    <span class="label label-xl label-inline label-light-dark"
                      >Staff</span
                    >
                  </span>
                </a>
              </li>
              <li class="navi-separator mt-3 opacity-70"></li>
              <li class="navi-footer py-4">
                <a class="btn btn-clean font-weight-bold btn-sm" href="#">
                  <i class="ki ki-plus icon-sm"></i>Add new</a
                >
              </li>
            </ul>
            <!--end::Navigation-->
          </div>
        </div>
      </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-2">
      <!--begin::Item-->
      <div class="d-flex mb-8">
        <!--begin::Symbol-->
        <div class="symbol symbol-50 symbol-2by3 flex-shrink-0 mr-4">
          <div class="d-flex flex-column">
            <div
              class="symbol-label mb-3"
              style="
                background-image: url('assets/media/stock-600x400/img-23.jpg');
              "
            ></div>
            <a
              href="#"
              class="btn btn-light-primary font-weight-bolder py-2 font-size-sm"
              >Edit</a
            >
          </div>
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
          <a
            href="#"
            class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg mb-2"
            >Darius the Great</a
          >
          <span class="text-muted font-weight-bold font-size-sm mb-3"
            >All it takes tank credibility is one glaring error</span
          >
          <span class="text-muted font-weight-bold font-size-lg"
            >Price:
            <span class="text-dark-75 font-weight-bolder">99.00$</span></span
          >
        </div>
        <!--end::Title-->
      </div>
      <!--end::Item-->
      <!--begin::Item-->
      <div class="d-flex">
        <!--begin::Symbol-->
        <div class="symbol symbol-50 symbol-2by3 flex-shrink-0 mr-4">
          <div class="d-flex flex-column">
            <div
              class="symbol-label mb-3"
              style="
                background-image: url('assets/media/stock-600x400/img-25.jpg');
              "
            ></div>
            <a
              href="#"
              class="btn btn-light-primary font-weight-bolder py-2 font-size-sm"
              >Edit</a
            >
          </div>
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
          <a
            href="#"
            class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg mb-2"
            >Nike Airmax</a
          >
          <span class="text-muted font-weight-bold font-size-sm mb-3"
            >All it takes tank credibility is one glaring error</span
          >
          <span class="text-muted font-weight-bold font-size-lg"
            >Price:
            <span class="text-dark-75 font-weight-bolder">99.00$</span></span
          >
        </div>
        <!--end::Title-->
      </div>
      <!--end::Item-->
    </div>
    <!--end::Body-->
  </div>
  <!--end::List Widget 21-->
</template>
