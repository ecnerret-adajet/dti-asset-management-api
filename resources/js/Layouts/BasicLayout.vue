<script setup>
import { ref, watch } from 'vue';
import HeaderMobile from "../Components/HeaderMobile.vue";
import TopMenu from "../Components/TopMenu.vue";
import ScrollTop from '../Components/ScrollTop.vue'
import UserPanel from '../Components/UserPanel.vue'
import QuickPanel from '../Components/QuickPanel.vue'

// Define reactive state first
const userPanelOpen = ref(false);

// Then watch it after it's defined
watch(userPanelOpen, (val) => console.log('UserPanel open:', val));
</script>
<template>
  <div>
    <HeaderMobile />

    <div class="d-flex flex-column flex-root">
      <!--begin::Page-->
      <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

          <TopMenu @toggle-user-panel="userPanelOpen = !userPanelOpen" />

          <slot />

        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Page-->
    </div>

    <QuickPanel/>

    <button @click="userPanelOpen = !userPanelOpen" style="position:fixed;top:10px;right:10px;z-index:9999;">Toggle UserPanel (Debug)</button>

    <UserPanel :open="userPanelOpen" @close="userPanelOpen = false" />

    <ScrollTop />
  </div>
</template>
