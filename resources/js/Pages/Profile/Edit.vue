<template>
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
      <div class="container">
        <div class="card card-custom gutter-b">
          <div class="card-header">
            <div class="card-title">
              <h3 class="card-label">Update Profile</h3>
            </div>
          </div>
          <div class="card-body">
            <div v-if="$page.props.flash.success" class="alert alert-success">
              {{ $page.props.flash.success }}
            </div>
            <div class="row">
              <div class="col-md-6">
                <form @submit.prevent="updateProfile">
                  <div class="form-group mb-4">
                    <label class="form-label">Profile Image</label>
                    <div class="d-flex align-items-center mb-3">
                      <div class="symbol symbol-100 mr-5">
                        <div
                          class="symbol-label"
                          :style="{ backgroundImage: `url('${profileImageUrl}')` }"
                        ></div>
                      </div>
                      <div>
                        <input
                          type="file"
                          ref="imageInput"
                          @change="handleImageChange"
                          accept="image/png, image/jpeg, image/jpg"
                          class="d-none"
                        />
                        <button
                          type="button"
                          @click="$refs.imageInput.click()"
                          class="btn btn-light-primary font-weight-bold btn-sm"
                        >
                          Change Image
                        </button>
                        <div class="text-muted mt-2">Allowed file types: png, jpg, jpeg.</div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group mb-4">
                    <label class="form-label">First Name</label>
                    <input
                      v-model="form.first_name"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.first_name }"
                    />
                    <div v-if="form.errors.first_name" class="invalid-feedback">
                      {{ form.errors.first_name }}
                    </div>
                  </div>
                  <div class="form-group mb-4">
                    <label class="form-label">Last Name</label>
                    <input
                      v-model="form.last_name"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.last_name }"
                    />
                    <div v-if="form.errors.last_name" class="invalid-feedback">
                      {{ form.errors.last_name }}
                    </div>
                  </div>
                  <div class="form-group mb-4">
                    <label class="form-label">Email</label>
                    <input
                      v-model="form.email"
                      type="email"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.email }"
                    />
                    <div v-if="form.errors.email" class="invalid-feedback">
                      {{ form.errors.email }}
                    </div>
                  </div>
                  <div class="form-group mb-4">
                    <label class="form-label">Contact Number</label>
                    <input
                      v-model="form.contact_number"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.contact_number }"
                    />
                    <div v-if="form.errors.contact_number" class="invalid-feedback">
                      {{ form.errors.contact_number }}
                    </div>
                    <div class="text-muted mt-2">Enter valid Philippine phone number.</div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary" :disabled="form.processing">
                      Update Profile
                    </button>
                  </div>
                </form>
              </div>
              <div class="col-md-6">
                <div class="card card-custom">
                  <div class="card-header">
                    <div class="card-title">
                      <h3 class="card-label">Change Password</h3>
                    </div>
                  </div>
                  <div class="card-body">
                    <form @submit.prevent="updatePassword">
                      <div class="form-group mb-4">
                        <label class="form-label">Current Password</label>
                        <input
                          v-model="passwordForm.current_password"
                          type="password"
                          class="form-control"
                          :class="{ 'is-invalid': passwordForm.errors.current_password }"
                        />
                        <div v-if="passwordForm.errors.current_password" class="invalid-feedback">
                          {{ passwordForm.errors.current_password }}
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label class="form-label">New Password</label>
                        <input
                          v-model="passwordForm.password"
                          type="password"
                          class="form-control"
                          :class="{ 'is-invalid': passwordForm.errors.password }"
                        />
                        <div v-if="passwordForm.errors.password" class="invalid-feedback">
                          {{ passwordForm.errors.password }}
                        </div>
                        <div class="text-muted mt-2">
                          Password must be at least 8 characters and include uppercase, lowercase, numbers, and symbols.
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <input
                          v-model="passwordForm.password_confirmation"
                          type="password"
                          class="form-control"
                        />
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary" :disabled="passwordForm.processing">
                          Update Password
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  user: Object,
});

const imageInput = ref(null);
const selectedImage = ref(null);

// Form for profile update
const form = useForm({
  first_name: props.user.first_name,
  last_name: props.user.last_name,
  email: props.user.email,
  contact_number: props.user.contact_number || '',
  image_path: null,
});

// Form for password update
const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});

const profileImageUrl = computed(() => {
  if (selectedImage.value) {
    return URL.createObjectURL(selectedImage.value);
  }
  
  if (props.user.image_path) {
    return props.user.image_path.startsWith('http') 
      ? props.user.image_path 
      : `/storage/${props.user.image_path}`;
  }
  
  return 'assets/media/users/default.jpg';
});

const handleImageChange = (e) => {
  if (e.target.files.length > 0) {
    selectedImage.value = e.target.files[0];
    form.image_path = e.target.files[0];
  }
};

const updateProfile = () => {
  form.post(route('profile-update'), {
    preserveScroll: true,
    onSuccess: () => {
      selectedImage.value = null;
    },
  });
};

const updatePassword = () => {
  passwordForm.post(route('profile-change-password'), {
    preserveScroll: true,
    onSuccess: () => {
      passwordForm.reset();
    },
  });
};
</script>
