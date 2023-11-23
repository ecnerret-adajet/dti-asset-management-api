<script setup>
import { ref, onMounted } from "vue";

import AuditApi from '../Api/AuditApi';
const auditService = new AuditApi();

const audits = ref([]);
const loading = ref(false);
const errors = ref(null);

const fetchAudits = () => {
    loading.value = true
    auditService.list()
    .then(response => {
        audits.value = response
    })
    .catch(error => {
        errors.value = error
    })
};

const removeStrings = (text) => {
    let parts = text.split("\\");
    return parts[parts.length - 1];
}

onMounted(() => {
    fetchAudits();
});

</script>
<template>
  <!--begin::Quick Panel-->
  <div id="kt_quick_panel" class="offcanvas offcanvas-right pt-5 pb-10">
    <!--begin::Header-->
    <div
      class="offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5"
    >
      <ul
        class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-primary flex-grow-1 px-10"
        role="tablist"
      >
        <li class="nav-item">
          <a
            class="nav-link active"
            data-toggle="tab"
            href="#kt_quick_panel_logs"
            >Audit Logs</a
          >
        </li>
        <!-- <li class="nav-item">
          <a
            class="nav-link"
            data-toggle="tab"
            href="#kt_quick_panel_notifications"
            >Notifications</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#kt_quick_panel_settings"
            >Settings</a
          >
        </li> -->
      </ul>
      <div class="offcanvas-close mt-n1 pr-5">
        <a
          href="#"
          class="btn btn-xs btn-icon btn-light btn-hover-primary"
          id="kt_quick_panel_close"
        >
          <i class="ki ki-close icon-xs text-muted"></i>
        </a>
      </div>
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    <div class="offcanvas-content px-10">
      <div class="tab-content">
        <!--begin::Tabpane-->
        <div
          class="tab-pane fade show pt-3 pr-5 mr-n5 active"
          id="kt_quick_panel_logs"
          role="tabpanel"
        >
          <!--begin::Nav-->
          <div class="navi navi-icon-circle navi-spacer-x-0">
            <!--begin::Item-->
            <a v-for="(audit,a) in audits" :key="a" href="#" class="navi-item">
              <div class="navi-link rounded">
                <div class="symbol symbol-50 mr-3">
                  <div class="symbol-label">
                    <i class="flaticon-bell text-success icon-lg"></i>
                  </div>
                </div>
                <div class="navi-text">
                  <div class="font-weight-bold font-size-lg text-lowercase">
                    <span class="text-capitalize">{{ audit.event }}</span> a {{ removeStrings(audit.auditable_type) }} entry.
                  </div>
                  <div class="text-muted">By: {{ audit.user.name }}</div>
                </div>
              </div>
            </a>
            <!--end::Item-->
          </div>
          <!--end::Nav-->
        </div>
        <!--end::Tabpane-->

      </div>
    </div>
    <!--end::Content-->
  </div>
  <!--end::Quick Panel-->
  <!--begin::Chat Panel-->
</template>
