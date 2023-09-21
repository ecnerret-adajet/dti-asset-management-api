<template>
  <div>
    <HeaderMobile />

    <div class="d-flex flex-column flex-root">
      <!--begin::Page-->
      <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

          <TopMenu />

          <slot />

        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Page-->
    </div>


    <QuckPanel/>

    <UserPanel/>

    <ScrollTop />

  </div>
</template>
<script setup>
import HeaderMobile from "../Components/HeaderMobile.vue";
import TopMenu from "../Components/TopMenu.vue";
import ScrollTop from '../Components/ScrollTop.vue'
import UserPanel from '../Components/UserPanel.vue'
import QuckPanel from '../Components/QuickPanel.vue'
</script>
