<script setup>
import { ref } from "vue";

import SubHeader from "../Components/SubHeader.vue";
import HeaderMobile from "../Components/HeaderMobile.vue";
import TopMenu from "../Components/TopMenu.vue";
import ScrollTop from "../Components/ScrollTop.vue";
import UserPanel from "../Components/UserPanel.vue";
import QuckPanel from "../Components/QuickPanel.vue";
import AccountSideBar from "../Components/AccountSideBar.vue";

const breadcrumbs = ref([{ id: 1, name: "Accounts", url: "/accounts" }]);
</script>
<template>
  <div>
    <HeaderMobile />

    <div class="d-flex flex-column flex-root">
      <!--begin::Page-->
      <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
          <TopMenu />

          <!--begin::Content-->
          <div
            class="content d-flex flex-column flex-column-fluid"
            id="kt_content"
          >
            <!-- sub header -->
            <SubHeader
              title="Users Management"
              button_name="New User"
              button_link="/users/create"
              :breadcrumbs="breadcrumbs"
            />
            <!-- end subheader -->

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
                <!--begin::Profile Overview-->
                <div class="d-flex flex-row">
                  <AccountSideBar />
                  <!--begin::Content-->
                  <slot />
                  <!--end::Content-->
                </div>
                <!--begin::Profile Overview-->
              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Page-->
    </div>

    <QuckPanel />

    <UserPanel />

    <ScrollTop />
  </div>
</template>

