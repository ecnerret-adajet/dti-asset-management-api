<script setup>
import { computed } from 'vue'
import { Link, usePage } from "@inertiajs/vue3";
defineProps({
  title: String,
  breadcrumbs: Array,
  button_name: String,
  button_link: String,
  second_button_name: String,
  second_button_link: String,
});

const page = usePage();

const permissions = computed(() => page.props.auth.permissions);

</script>
<template>
  <div class="subheader pb-8 subheader-transparent" id="kt_subheader">
    <div
      class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
    >
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-1">
        <!--begin::Heading-->
        <div class="d-flex flex-column">
          <!--begin::Title-->
          <h2 class="text-white font-weight-bold my-2 mr-5">{{ title }}</h2>
          <!--end::Title-->
          <!--begin::Breadcrumb-->
          <div class="d-flex align-items-center font-weight-bold my-2">
            <!--begin::Item-->
            <Link href="/" class="opacity-75 hover-opacity-100">
              <i class="flaticon2-shelter text-white icon-1x"></i>
            </Link>
            <!--end::Item-->
            <!--begin::Item-->
            <template v-for="(breadcrumb, b) in breadcrumbs" :key="b">
              <span
                class="label label-dot label-sm bg-white opacity-75 mx-3"
              ></span>
              <Link
                :href="breadcrumb.url"
                class="text-white text-hover-white opacity-75 hover-opacity-100"
                >{{ breadcrumb.name }}</Link
              >
            </template>
            <!--end::Item-->
          </div>
          <!--end::Breadcrumb-->
        </div>
        <!--end::Heading-->
      </div>
      <!--end::Info-->

      <!--begin:: toolbar -->
      <div  class="d-flex align-items-center">
        <!--begin::Button-->
        <Link v-if="second_button_link && permissions.includes('create')"
          :href="second_button_link"
          class="btn btn-transparent-white font-weight-bold py-3 px-6 mr-2"
          >{{ second_button_name }}</Link
        >
        <Link v-if="button_link && permissions.includes('create')"
          :href="button_link"
          class="btn btn-primary font-weight-bold py-3 px-6 mr-2"
          >{{ button_name }}</Link
        >
        <!--end::Button-->
      </div>

      <!--end:: toolbar -->
    </div>
  </div>
</template>
