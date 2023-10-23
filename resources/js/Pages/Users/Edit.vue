<script setup>
import InventoryLayout from "../../Layouts/InventoryLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

import { useSweetAlert } from "../../Services/useSweetAlert";
const sweetAlert = useSweetAlert();

const baseUrl = window.location.origin;

const props = defineProps({
  user: Object,
  roles: Array,
});

const form = useForm({
  first_name: props.user.first_name,
  last_name: props.user.last_name,
  image_path: props.user.image_path,
  email: props.user.email,
  role_id: props.user.roles ? props.user.roles[0].id : null,
  contact_number: props.user.contact_number,
});


const previewImage = ref(`${baseUrl}/${props.user.image_path}`);

const previewFile = (event) => {
  const file = event.target.files[0];

  if (file) {
    const reader = new FileReader();

    reader.onload = (e) => {
      previewImage.value = e.target.result;
    };

    reader.readAsDataURL(file);
  } else {
    previewImage.value = null;
  }
};

const updateUser = () => {
  form.patch(`/users/${props.user.id}`);
};
</script>
<template>
  <InventoryLayout>
    <!--begin::Card-->
    <div class="card card-custom card-stretch">
      <!--begin::Header-->
      <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
          <h3 class="card-label font-weight-bolder text-dark">Update User</h3>
          <span class="text-muted font-weight-bold font-size-sm mt-1"
            >User management</span
          >
        </div>
        <div class="card-toolbar">
          <button
            type="submit"
            @click="updateUser()"
            :disabled="form.processing"
            class="btn btn-success mr-2"
          >
            Submit
          </button>
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
            <label class="col-xl-3 col-lg-3 col-form-label">Image</label>
            <div class="col-lg-9 col-xl-6">
              <div
                class="image-input image-input-outline"
                id="kt_profile_avatar"
                style="
                  background-image: url(/assets/media/users/image-asset.jpeg);
                "
              >
                <div
                  class="image-input-wrapper"
                  :style="`background-image: url(${previewImage})`"
                ></div>
                <label
                  class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                  data-action="change"
                  data-toggle="tooltip"
                  title=""
                  data-original-title="Upload image"
                >
                  <i class="fa fa-pen icon-sm text-muted"></i>
                  <input
                    type="file"
                    name="profile_avatar"
                    @change="previewFile"
                    @input="form.image_path = $event.target.files[0]"
                    accept=".png, .jpg, .jpeg"
                  />
                  <input type="hidden" name="profile_avatar_remove" />
                </label>
                <span
                  class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                  data-action="cancel"
                  data-toggle="tooltip"
                  title="Cancel avatar"
                >
                  <i class="ki ki-bold-close icon-xs text-muted"></i>
                </span>
                <span
                  class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                  data-action="remove"
                  data-toggle="tooltip"
                  title="Remove avatar"
                >
                  <i class="ki ki-bold-close icon-xs text-muted"></i>
                </span>
              </div>
              <span class="form-text text-muted"
                >Allowed file types: png, jpg, jpeg.</span
              >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Role</label>
            <div class="col-lg-9 col-xl-6">
              <select
                v-model="form.role_id"
                class="form-control form-control-lg form-control-solid"
              >
                <option value="">Select</option>
                <option v-for="(role, l) in roles" :key="l" :value="role.id">
                  {{ role.name }}
                </option>
              </select>
              <div class="fv-plugins-message-container"></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Email</label>
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.email"
                placeholder="Input Email"
                class="form-control form-control-lg form-control-solid"
                type="email"
              />
              <div
                v-if="form.errors.email"
                class="fv-plugins-message-container text-danger mt-3"
              >
                <div class="fv-help-block">
                  {{ form.errors.email }}
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.first_name"
                placeholder="Input First Name"
                class="form-control form-control-lg form-control-solid"
                type="text"
              />
              <div
                v-if="form.errors.first_name"
                class="fv-plugins-message-container text-danger mt-3"
              >
                <div class="fv-help-block">
                  {{ form.errors.first_name }}
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
            <div class="col-lg-9 col-xl-6">
              <input
                v-model="form.last_name"
                placeholder="Input Last Name"
                class="form-control form-control-lg form-control-solid"
                type="text"
              />
              <div
                v-if="form.errors.last_name"
                class="fv-plugins-message-container text-danger mt-3"
              >
                <div class="fv-help-block">
                  {{ form.errors.last_name }}
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label"
              >Contact Phone</label
            >
            <div class="col-lg-9 col-xl-6">
              <div class="input-group input-group-solid input-group-lg">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="la la-phone"></i>
                  </span>
                </div>
                <input
                  type="text"
                  v-model="form.contact_number"
                  class="form-control form-control-solid form-control-lg"
                  name="phone"
                  placeholder="Phone"
                />
              </div>
              <span class="form-text text-muted"
                >Enter valid Philippine phone number.</span
              >
              <div class="fv-plugins-message-container"></div>
            </div>
          </div>


        </div>
        <!--end::Body-->
      </form>
      <!--end::Form-->
    </div>
  </InventoryLayout>
</template>
