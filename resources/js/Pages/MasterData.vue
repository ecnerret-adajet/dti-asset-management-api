<script setup>
import { Link } from "@inertiajs/vue3";
import BasicLayout from "../Layouts/BasicLayout.vue";

</script>
<template>
  <BasicLayout>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
      <!--begin::Entry-->
      <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
          <!--begin::Row-->
          <div class="row">
            <!--begin::Column-->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <!--begin::Card-->
              <div class="card card-custom gutter-b card-stretch">
                <!--begin::Body-->
                <div class="card-body text-center pt-4">
                  <!--begin::User-->
                  <div class="mt-20">
                    <div class="symbol symbol-circle symbol-lg-90">
                      <!-- <img src="/assets/media/project-logos/1.png" alt="image" /> -->
                      <span class="svg-icon svg-icon-primary svg-icon-4x"
                        ><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Map\Location-arrow.svg--><svg
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
                            <rect x="0" y="0" width="24" height="24" />
                            <path
                              d="M4.88230018,17.2353996 L13.2844582,0.431083506 C13.4820496,0.0359007077 13.9625881,-0.12427877 14.3577709,0.0733126292 C14.5125928,0.15072359 14.6381308,0.276261584 14.7155418,0.431083506 L23.1176998,17.2353996 C23.3152912,17.6305824 23.1551117,18.1111209 22.7599289,18.3087123 C22.5664522,18.4054506 22.3420471,18.4197165 22.1378777,18.3482572 L14,15.5 L5.86212227,18.3482572 C5.44509941,18.4942152 4.98871325,18.2744737 4.84275525,17.8574509 C4.77129597,17.6532815 4.78556182,17.4288764 4.88230018,17.2353996 Z"
                              fill="#000000"
                              fill-rule="nonzero"
                              transform="translate(14.000087, 9.191034) rotate(-315.000000) translate(-14.000087, -9.191034) "
                            />
                          </g></svg
                        ><!--end::Svg Icon--></span
                      >
                    </div>
                  </div>
                  <!--end::User-->
                  <!--begin::Name-->
                  <div class="my-4">
                    <Link
                      href="/master-data/locations"
                      class="text-dark font-weight-bold text-hover-primary font-size-h4"
                      >Location Listing</Link
                    >
                  </div>
                  <!--end::Name-->

                  <!--begin::Buttons-->
                  <div class="mt-9">
                    <Link
                      href="/master-data/locations"
                      class="btn btn-light-primary font-weight-bolder btn-sm py-3 px-6 text-uppercase"
                      >Visit</Link
                    >
                  </div>
                  <!--end::Buttons-->
                </div>
                <!--end::Body-->
              </div>
              <!--end::Card-->
            </div>
            <!--end::Column-->
            <!--begin::Column-->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <!--begin::Card-->
              <div class="card card-custom gutter-b card-stretch">
                <!--begin::Body-->
                <div class="card-body text-center pt-4">
                  <!--begin::User-->
                  <div class="mt-20">
                    <div class="symbol symbol-circle symbol-lg-90">
                      <!-- <img src="/assets/media/project-logos/1.png" alt="image" /> -->
                      <span class="svg-icon svg-icon-primary svg-icon-4x"
                        ><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Design\Component.svg--><svg
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
                            <rect x="0" y="0" width="24" height="24" />
                            <path
                              d="M12.7442084,3.27882877 L19.2473374,6.9949025 C19.7146999,7.26196679 20.003129,7.75898194 20.003129,8.29726722 L20.003129,15.7027328 C20.003129,16.2410181 19.7146999,16.7380332 19.2473374,17.0050975 L12.7442084,20.7211712 C12.2830594,20.9846849 11.7169406,20.9846849 11.2557916,20.7211712 L4.75266256,17.0050975 C4.28530007,16.7380332 3.99687097,16.2410181 3.99687097,15.7027328 L3.99687097,8.29726722 C3.99687097,7.75898194 4.28530007,7.26196679 4.75266256,6.9949025 L11.2557916,3.27882877 C11.7169406,3.01531506 12.2830594,3.01531506 12.7442084,3.27882877 Z M12,14.5 C13.3807119,14.5 14.5,13.3807119 14.5,12 C14.5,10.6192881 13.3807119,9.5 12,9.5 C10.6192881,9.5 9.5,10.6192881 9.5,12 C9.5,13.3807119 10.6192881,14.5 12,14.5 Z"
                              fill="#000000"
                            />
                          </g></svg
                        ><!--end::Svg Icon--></span
                      >
                    </div>
                  </div>
                  <!--end::User-->
                  <!--begin::Name-->
                  <div class="my-4">
                    <Link
                      href="/master-data/asset-types"
                      class="text-dark font-weight-bold text-hover-primary font-size-h4"
                      >Asset Types</Link
                    >
                  </div>
                  <!--end::Name-->

                  <!--begin::Buttons-->
                  <div class="mt-9">
                    <Link
                      href="/master-data/asset-types"
                      class="btn btn-light-primary font-weight-bolder btn-sm py-3 px-6 text-uppercase"
                      >Visit</Link
                    >
                  </div>
                  <!--end::Buttons-->
                </div>
                <!--end::Body-->
              </div>
              <!--end::Card-->
            </div>
            <!--end::Column-->
            <!--begin::Column-->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <!--begin::Card-->
              <div class="card card-custom gutter-b card-stretch">
                <!--begin::Body-->
                <div class="card-body text-center pt-4">
                  <!--begin::User-->
                  <div class="mt-20">
                    <div class="symbol symbol-circle symbol-lg-90">
                      <!-- <img src="/assets/media/project-logos/1.png" alt="image" /> -->
                      <span class="svg-icon svg-icon-primary svg-icon-4x"
                        ><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Shopping\Box2.svg--><svg
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
                            <rect x="0" y="0" width="24" height="24" />
                            <path
                              d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z"
                              fill="#000000"
                            />
                            <path
                              d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z"
                              fill="#000000"
                              opacity="0.3"
                            />
                          </g></svg
                        ><!--end::Svg Icon--></span
                      >
                    </div>
                  </div>
                  <!--end::User-->
                  <!--begin::Name-->
                  <div class="my-4">
                    <Link
                      href="/master-data/statuses"
                      class="text-dark font-weight-bold text-hover-primary font-size-h4"
                      >Status Listing</Link
                    >
                  </div>
                  <!--end::Name-->

                  <!--begin::Buttons-->
                  <div class="mt-9">
                    <Link
                      href="/master-data/statuses"
                      class="btn btn-light-primary font-weight-bolder btn-sm py-3 px-6 text-uppercase"
                      >Visit</Link
                    >
                  </div>
                  <!--end::Buttons-->
                </div>
                <!--end::Body-->
              </div>
              <!--end::Card-->
            </div>
            <!--end::Column-->
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::Entry-->
    </div>
    <!--end::Content-->
  </BasicLayout>
</template>
