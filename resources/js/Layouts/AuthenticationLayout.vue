<script setup>
</script>
<template>
  <!--begin::Main-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div
      class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white"
      id="kt_login"
    >

      <!--begin::Aside-->
      <slot/>
      <!--begin::Aside-->

      <!--begin::Content-->
      <div
        class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0"
        style="background-color: #b1dced"
      >
        <!--begin::Title-->
        <div
          class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7"
        >
          <h3
            class="display4 font-weight-bolder my-7 text-dark"
            style="color: #986923"
          >
            Amazing Wireframes
          </h3>
          <p
            class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70"
          >
            User Experience &amp; Interface Design, Product Strategy <br />Web
            Application SaaS Solutions
          </p>
        </div>
        <!--end::Title-->
        <!--begin::Image-->
        <div
          class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"
          style="
            background-image: url(assets/media/svg/illustrations/login-visual-2.svg);
          "
        ></div>
        <!--end::Image-->
      </div>
      <!--end::Content-->

    </div>
    <!--end::Login-->
  </div>
  <!--end::Main-->
</template>
