<script setup>
import { ref } from 'vue'
import AuthenticationLayout from "../../Layouts/AuthenticationLayout.vue";
import useAuth from '../../Services/useAuth';

const processing = ref(false);
const error = ref([]);
const auth = ref({
    email: '',
    password: ''
});
const { login } = useAuth();

const onLogin = async () => {
    processing.value = true;
    await axios.get(`/sanctum/csrf-cookie`);
    await axios.post(`/api/login`,this.auth)
}

</script>
<template>
<AuthenticationLayout>
<div
        class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden"
      >
        <!--begin: Aside Container-->
        <div
          class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35"
        >
          <!--begin::Logo-->
          <a href="#" class="text-center pt-2">
            <img src="assets/media/logos/dtilogo.png" class="max-h-75px" alt="" />
          </a>
          <strong class="text-center font-weight-bolder text-dark font-size-h2 font-size-h1-lg pt-3">Daelift Traiding Inc.</strong>
          <!--end::Logo-->
          <!--begin::Aside body-->
          <div class="d-flex flex-column-fluid flex-column flex-center">
            <!--begin::Signin-->
            <div class="login-form login-signin py-11">
              <!--begin::Form-->
              <form
                class="form"
                novalidate="novalidate"
                id="kt_login_signin_form"
              >
                <!--begin::Title-->
                <div class="text-center pb-8">
                  <h2
                    class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg"
                  >
                    Sign In
                  </h2>
                </div>
                <!--end::Title-->
                <!--begin::Form group-->
                <div class="form-group">
                  <label class="font-size-h6 font-weight-bolder text-dark"
                    >Email</label
                  >
                  <input
                    class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                    type="text"
                    name="username"
                    autocomplete="off"
                  />
                </div>
                <!--end::Form group-->
                <!--begin::Form group-->
                <div class="form-group">
                  <div class="d-flex justify-content-between mt-n5">
                    <label
                      class="font-size-h6 font-weight-bolder text-dark pt-5"
                      >Password</label
                    >
                  </div>
                  <input
                    class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                    type="password"
                    name="password"
                    autocomplete="off"
                  />
                </div>
                <!--end::Form group-->
                <!--begin::Action-->
                <div class="text-center pt-2">
                  <button
                    id="kt_login_signin_submit"
                    class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3"
                  >
                    Sign In
                  </button>
                </div>
                <!--end::Action-->
              </form>
              <!--end::Form-->
            </div>
            <!--end::Signin-->

          </div>
          <!--end::Aside body-->




        </div>
        <!--end: Aside Container-->
      </div>
</AuthenticationLayout>
</template>
