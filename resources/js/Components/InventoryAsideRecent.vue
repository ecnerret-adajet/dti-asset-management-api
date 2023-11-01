<script setup>
import { ref, onMounted } from "vue";
import InventoryApi from "../Api/InventoryApi";
import { Link } from "@inertiajs/vue3";

const inventoryService = new InventoryApi();

const recents = ref([]);
const error = ref(null);

const currencyFormatter = (amount) => {
  const currencyAmount = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "PHP", // Change to your desired currency code (e.g., 'EUR' for Euro)
  });
  return currencyAmount.format(amount);
};

const baseUrl = window.location.origin;

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
          >Newly Created</span
        >
      </h3>

    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-2">
      <!--begin::Item-->
      <div v-for="(recent, r) in recents" :key="r" class="d-flex mb-8">
        <!--begin::Symbol-->
        <div class="symbol symbol-50 symbol-2by3 flex-shrink-0 mr-4">
          <div class="d-flex flex-column">
            <div
              class="symbol-label mb-3"
              :style="`
                background-image: url(${baseUrl}/${recent.image_path});
              `"
            ></div>
          </div>
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
          <Link
            :href="`/inventory/${recent.id}`"
            class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg mb-2"
            >{{ recent.name }}</Link
          >
          <span class="text-muted font-weight-bold font-size-sm mb-3"
            >{{ recent.description }}</span
          >
          <span class="text-muted font-weight-bold font-size-lg"
            >Unit Price:
            <span class="text-dark-75 font-weight-bolder">{{ currencyFormatter(recent.unit_price) }}</span></span
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
