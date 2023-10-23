<script setup>
import AccountsLayout from "../../Layouts/AccountsLayout.vue";
import CreateModal from "./CreateModal.vue";
import EditModal from "./EditModal.vue";
import { router, Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";

const show = ref(false);
const show_edit = ref(false);
const selected_permission = ref({});

const props = defineProps({
  permissions: Object,
  filters: Object,
});

const form = useForm({
  name: props.filters.name,
});

watch(
  () => form,
  throttle(() => {
    router.get("/permissions", pickBy(form), {
      preserveState: true,
    });
  }, 150),
  { deep: true }
);

const openCreateModal = () => {
  show.value = !show.value;
};

const openEditModal = (item) => {
  show_edit.value = !show_edit.value;
  selected_permission.value = item;
};
</script>
<template>
  <AccountsLayout>
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
      <!--begin::Card-->
      <div class="card card-custom gutter-b">
        <!--begin::Header-->
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder font-size-h3 text-dark"
              >Permission Manamgement</span
            >
            <span class="text-muted mt-1 font-weight-bold font-size-sm"
              >System permissions</span
            >
          </h3>
          <div class="card-toolbar">
            <!--begin::Button-->

            <!--end::Button-->
          </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">
          <!--begin: Search Form-->
          <!--begin::Search Form-->
          <div class="mb-5">
            <div class="row align-items-center">
              <div class="col-lg-12 col-xl-12">
                <div class="row align-items-center">
                  <div class="col-md-12 my-2 my-md-0">
                    <div class="input-icon">
                      <input
                        type="text"
                        v-model="form.name"
                        class="form-control form-control-solid"
                        placeholder="Search name..."
                        id="kt_datatable_search_query"
                      />
                      <span>
                        <i class="flaticon2-search-1 text-muted"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--end::Search Form-->
          <!--end: Search Form-->
          <!--begin: Datatable-->
          <!--begin::Table-->
          <div class="table-responsive">
            <table
              class="table table-head-custom table-vertical-center"
              id="kt_advance_table_widget_1"
            >
              <thead>
                <tr class="text-left">
                  <th class="pr-0" style="width: 300px">Name</th>
                  <th style="min-width: 150px">Description</th>

                </tr>
              </thead>
              <tbody>
                <tr v-for="(permission, l) in permissions.data" :key="l">
                  <td class="pr-2">
                    <span class="text-capitalize">
                      {{ permission.name }}
                    </span>
                  </td>
                  <td>
                    <span class="text-capitalize">
                      {{ permission.description }}
                    </span>
                  </td>

                </tr>
              </tbody>
            </table>
          </div>
          <!--end::Table-->
          <!--end: Datatable-->
        </div>
        <!--end::Body-->
      </div>
      <!--end::Card-->
    </div>
    <!--end::Content-->
  </AccountsLayout>
</template>
