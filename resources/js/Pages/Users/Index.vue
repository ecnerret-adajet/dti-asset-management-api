<script setup>
import AccountsLayout from "../../Layouts/AccountsLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import ChangePasswordModal from "./ChangePasswordModal.vue";
import { ref, watch, computed } from "vue";
import { router, Link, useForm } from "@inertiajs/vue3";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";

const baseUrl = window.location.origin;

const show = ref(false);
const show_edit = ref(false);
const selected_user = ref({});

const props = defineProps({
  users: Object,
  filters: Object,
});

const form = useForm({
  name: props.filters.name,
});

watch(
  () => form,
  throttle(() => {
    router.get("/users", pickBy(form), {
      preserveState: true,
    });
  }, 150),
  { deep: true }
);

const openChangePasswordModal = (item) => {
  show.value = !show.value;
  selected_user.value = item;
};

const confirmDeactivateUser = (user) => {
  Swal.fire({
    title: "Are you want to proceed this action?",
    text: "Deactivating a user",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Proceed",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Processing...",
        allowEscapeKey: false,
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        onOpen: () => {
          Swal.showLoading();
        },
      });
      axios
        .delete(`/users/${user.id}`)
        .then((response) => {
          Swal.close();
          if (response.status === 200 || response.status === 201) {
            Swal.fire("Success", "Request completed successfully!", "success");
            const new_users = props.users.data.map(item => {
                if(item.id === response.data.id) {
                    return {
                        ...item,
                        deleted_at: response.data.deleted_at
                    }
                }
                return item;
            });
            props.users.data = new_users;
          } else {
            Swal.fire("Error", "An error occurred.", "error");
          }
        })
        .catch((error) => {
          Swal.close();
          Swal.fire("Error", `${error.message}`, "error");
        });
    }
  });
};
</script>
<template>
  <AccountsLayout>
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
      <!--begin::Advance Table: Widget 7-->
      <div class="card card-custom gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark"
              >User List</span
            >
            <span class="text-muted mt-3 font-weight-bold font-size-sm"
              >List of system users</span
            >
          </h3>
          <div class="card-toolbar">
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
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-10 pb-0 mt-n3">
          <!--begin::Table-->
          <div class="table-responsive">
            <table class="table table-borderless table-vertical-center">
              <thead>
                <tr class="text-left">
                  <th class="pr-0 pl-2" colspan="2" style="width: 300px">
                    Name
                  </th>
                  <th style="min-width: 150px">Role</th>
                  <th style="min-width: 150px">Contact</th>
                  <th style="min-width: 100px">Status</th>
                  <th class="pr-0 text-right" style="min-width: 150px">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, u) in users.data" :key="u">
                  <td class="p-0 py-4">
                    <span
                      v-if="
                        user.image_path === null ||
                        user.image_path === 'default.png'
                      "
                      class="symbol symbol-50 mr-5"
                    >
                      <span
                        class="symbol-label text-white font-size-h5 font-weight-bold bg-dark-o-70"
                        >{{ user.name[0] }}</span
                      >
                    </span>

                    <div v-else class="symbol symbol-50 symbol-light mt-1">
                      <span class="symbol-label">
                        <img
                          :src="`${baseUrl}/${user.image_path}`"
                          class="h-100 align-self-end"
                          alt=""
                        />
                      </span>
                    </div>

                    <!-- <div class="symbol symbol-50 symbol-light mr-5">
                      <span class="symbol-label">
                        <img
                          src="assets/media/svg/misc/005-bebo.svg"
                          class="h-50 align-self-center"
                          alt=""
                        />
                      </span>
                    </div> -->
                  </td>
                  <td class="pl-0">
                    <a
                      href="#"
                      class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg"
                      >{{ user.name }}</a
                    >
                    <span class="text-muted font-weight-bold d-block">{{
                      user.email
                    }}</span>
                  </td>
                  <td class="text-left pr-0">
                    <span
                      v-for="(role, r) in user.roles"
                      :key="`role_${r}`"
                      class="text-dark-75 font-weight-bolder d-block font-size-lg"
                      >{{ role.name }}</span
                    >
                  </td>
                  <td class="text-left">
                    <span class="text-muted font-weight-bold">{{
                      user.contact_number
                    }}</span>
                  </td>
                  <td class="text-left">
                    <span
                      v-if="user.deleted_at === null"
                      class="label label-lg label-light-success font-weight-bold text-capitalize label-inline"
                    >
                      Active
                    </span>
                    <span
                      v-else
                      class="label label-lg label-light-danger font-weight-bold text-capitalize label-inline"
                    >
                      Deactivated
                    </span>
                  </td>
                  <td class="pr-0 text-right">
                    <div class="dropdown dropdown-inline">
                      <a
                        href="javascript::void(0)"
                        class="btn btn-sm btn-clean btn-icon mr-2"
                        data-toggle="dropdown"
                      >
                        <span class="svg-icon svg-icon-md">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px"
                            height="24px"
                            viewBox="0 0 24 24"
                            version="1.1"
                          >
                            <g
                              stroke="none"
                              stroke-width="1"
                              fill="none"
                              fill-rule="evenodd"
                            >
                              <rect x="0" y="0" width="24" height="24"></rect>
                              <path
                                d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                fill="#000000"
                              ></path>
                            </g>
                          </svg>
                        </span>
                      </a>
                      <div
                        class="dropdown-menu dropdown-menu-sm dropdown-menu-right"
                      >
                        <ul class="navi flex-column navi-hover py-2">
                          <li
                            class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2"
                          >
                            Choose an action:
                          </li>
                          <li class="navi-item">
                            <Link :href="`/users/${user.id}`" class="navi-link">
                              <span class="navi-icon"
                                ><i class="la la-copy"></i
                              ></span>
                              <span class="navi-text">Update User</span>
                            </Link>
                          </li>
                          <li class="navi-item">
                            <a
                              @click="openChangePasswordModal(user)"
                              href="javascript:;"
                              class="navi-link"
                            >
                              <span class="navi-icon"
                                ><i class="la la-file-excel-o"></i
                              ></span>
                              <span class="navi-text">Change Password</span>
                            </a>
                          </li>
                          <li class="navi-item text-danger">
                            <a href="#" class="navi-link">
                              <span class="navi-icon"
                                ><i class="la la-file-excel-o"></i
                              ></span>
                              <span class="navi-text">Deactivate user</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!--end::Table-->

          <!--begin::Pagination-->
          <Pagination class="mt-6" :links="users.links" />
          <!--end::Pagination-->
        </div>
        <!--end::Body-->
      </div>
      <!--end::Advance Table Widget 7-->
    </div>
    <!--end::Content-->

    <change-password-modal
      unique_id="changePasswordModal"
      title="Change user password"
      :user="selected_user"
      :show="show_edit"
      @close="show_edit = $event"
    />

  </AccountsLayout>
</template>
