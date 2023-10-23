<script setup>
import InventoryLayout from "../../Layouts/InventoryLayout.vue";
import { useSweetAlert } from "../../Services/useSweetAlert";
import { router, useForm } from "@inertiajs/vue3";
import { ref, reactive, computed } from "vue";

const baseUrl = window.location.origin;

const sweetAlert = useSweetAlert();

const props = defineProps({
  role: Object,
  permissions: Array,
});

const form = useForm({
  name: props.role.name,
  level: props.role.level,
  description: props.role.description,
  permissions: props.role.permissions,
});

const current_permissions = reactive(
  props.permissions.map((item) =>
    props.role.permissions.map((role) => role.id).includes(item.id)
  )
);

const selectedPermissions = ref(props.role.permissions.map((item) => item.id));

const handlePermissionChange = (permissionId) => {
  if (selectedPermissions.value.includes(permissionId)) {
    // Permission already exists, remove it
    selectedPermissions.value = selectedPermissions.value.filter(
      (id) => id !== permissionId
    );
  } else {
    // Permission does not exist, add it
    selectedPermissions.value.push(permissionId);
  }

  // Perform synchronization logic here with your API or other data management system
};

const updateRole = () => {
  form
    .transform((data) => ({
      ...data,
      permissions: selectedPermissions.value,
    }))
    .patch(`/roles/${props.role.id}`, {
      onSuccess: () => {
        sweetAlert.basicAlert("Succesfully updated!", "Update Role", "success");
      },
    });
};
</script>
<template>
  <InventoryLayout>
    <!--begin::Card-->
    <div class="card card-custom card-stretch">
      <!--begin::Header-->
      <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
          <h3 class="card-label font-weight-bolder text-dark">Edit Role</h3>
          <span class="text-muted font-weight-bold font-size-sm mt-1"
            >Role management</span
          >
        </div>
        <div class="card-toolbar">
          <button
            type="submit"
            @click="updateRole()"
            :disabled="form.processing"
            class="btn btn-success mr-2"
          >
            Submit
          </button>
          <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
      </div>
      <!--end::Header-->
      <!--begin::Form-->
      <form class="form" @submit.prevent="storeAsset">
        <!--begin::Body-->
        <div class="card-body">
          <div class="row">
            <label class="col-xl-3"></label>
            <div class="col-lg-9 col-xl-6">
              <h5 class="font-weight-bold mb-6">General Information</h5>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Role Name</label>
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.name"
                placeholder="Input Email"
                class="form-control form-control-lg form-control-solid"
                type="text"
              />
              <div
                v-if="form.errors.name"
                class="fv-plugins-message-container text-danger mt-3"
              >
                <div class="fv-help-block">
                  {{ form.errors.name }}
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Role Name</label>
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.level"
                class="form-control form-control-lg form-control-solid"
                type="number"
              />
              <div
                v-if="form.errors.level"
                class="fv-plugins-message-container text-danger mt-3"
              >
                <div class="fv-help-block">
                  {{ form.errors.level }}
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Description</label>
            <div class="col-lg-9 col-xl-6">
              <textarea
                v-model="form.description"
                class="form-control form-control-lg form-control-solid"
                id="exampleTextarea"
                rows="4"
                type="text"
                placeholder="Type product description"
              ></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Permisions</label>
            <div class="col-lg-9 col-xl-6">
              <div class="checkbox-list">
                <template v-for="(permission, p) in permissions" :key="p">
                  <label class="checkbox" :for="'checkbox' + p">
                    <input
                      type="checkbox"
                      :checked="selectedPermissions.includes(permission.id)"
                      :value="permission.id"
                      @change="handlePermissionChange(permission.id)"
                      :id="'checkbox' + p"
                    />
                    <span></span>{{ permission.name }}</label
                  >
                </template>
              </div>
            </div>
          </div>
        </div>
        <!--end::Body-->
      </form>
      <!--end::Form-->
    </div>
    <!-- End::card -->
  </InventoryLayout>
</template>
