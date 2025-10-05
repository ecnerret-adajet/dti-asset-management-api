<script setup>
import BasicLayout from "../../Layouts/BasicLayout.vue";
import SubHeader from "../../Components/SubHeader.vue";
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
  supplier: Object,
});

const form = useForm({
  name: props.supplier.name,
  email: props.supplier.email,
  phone_number: props.supplier.phone_number,
  address: props.supplier.address || '',
  representative_name: props.supplier.representative_name || '',
});

const breadcrumbs = ref([
  { id: 1, name: "Accounts", url: "/accounts" },
  { id: 2, name: "Suppliers", url: "/accounts/suppliers" },
  { id: 3, name: "Edit Supplier", url: `/accounts/suppliers/${props.supplier.id}/edit` },
]);

const updateSupplier = () => {
  form.patch(`/suppliers/${props.supplier.id}`, {
    onSuccess: () => {
      router.visit('/accounts/suppliers');
    },
  });
};
</script>

<template>
  <BasicLayout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
      <!-- sub header -->
      <SubHeader title="Edit Supplier" :breadcrumbs="breadcrumbs" />
      <!-- end subheader -->
      <!--begin::Entry-->
      <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
          <!--begin::Card-->
          <div class="card card-custom">
            <!--begin::Card header-->
            <div class="card-header">
              <h3 class="card-title">Edit Supplier Details</h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
              <form @submit.prevent="updateSupplier">
                <div class="form-group row">
                  <div class="col-lg-6">
                    <label>Name:</label>
                    <input 
                      type="text" 
                      v-model="form.name" 
                      class="form-control" 
                      :class="{ 'is-invalid': form.errors.name }" 
                      placeholder="Enter supplier name"
                    />
                    <div v-if="form.errors.name" class="invalid-feedback">
                      {{ form.errors.name }}
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label>Email:</label>
                    <input 
                      type="email" 
                      v-model="form.email" 
                      class="form-control" 
                      :class="{ 'is-invalid': form.errors.email }" 
                      placeholder="Enter supplier email"
                    />
                    <div v-if="form.errors.email" class="invalid-feedback">
                      {{ form.errors.email }}
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-6">
                    <label>Phone Number:</label>
                    <input 
                      type="text" 
                      v-model="form.phone_number" 
                      class="form-control" 
                      :class="{ 'is-invalid': form.errors.phone_number }" 
                      placeholder="Enter phone number"
                    />
                    <div v-if="form.errors.phone_number" class="invalid-feedback">
                      {{ form.errors.phone_number }}
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label>Representative Name:</label>
                    <input 
                      type="text" 
                      v-model="form.representative_name" 
                      class="form-control" 
                      placeholder="Enter representative name"
                    />
                  </div>
                </div>
                <div class="form-group">
                  <label>Address:</label>
                  <textarea 
                    v-model="form.address" 
                    class="form-control" 
                    rows="3" 
                    placeholder="Enter supplier address"
                  ></textarea>
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-lg-6">
                      <button 
                        type="button" 
                        class="btn btn-secondary" 
                        @click="router.visit('/accounts/suppliers')"
                      >
                        Cancel
                      </button>
                    </div>
                    <div class="col-lg-6 text-right">
                      <button 
                        type="submit" 
                        class="btn btn-primary" 
                        :disabled="form.processing"
                      >
                        <span v-if="form.processing">Saving...</span>
                        <span v-else>Save Changes</span>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!--end::Card body-->
          </div>
          <!--end::Card-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::Entry-->
    </div>
    <!--end::Content-->
  </BasicLayout>
</template>
