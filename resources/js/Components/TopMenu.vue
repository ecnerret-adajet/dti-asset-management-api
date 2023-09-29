<script setup>
import { Link } from '@inertiajs/vue3'
</script>
<template>
  <!--begin::Header-->
  <div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container d-flex align-items-stretch justify-content-between">
      <!--begin::Left-->
      <div class="d-flex align-items-stretch mr-3">
        <!--begin::Header Logo-->
        <div class="header-logo">
          <a href="index.html">
            <img
              alt="Logo"
              src="/assets/media/logos/dtilogo.png"
              class="logo-default max-h-40px"
            />
            <img
              alt="Logo"
              src="/assets/media/logos/dtilogo.png"
              class="logo-sticky max-h-40px"
            />
          </a>
        </div>
        <!--end::Header Logo-->
        <!--begin::Header Menu Wrapper-->
        <div
          class="header-menu-wrapper header-menu-wrapper-left"
          id="kt_header_menu_wrapper"
        >
          <!--begin::Header Menu-->
          <div
            id="kt_header_menu"
            class="header-menu header-menu-left header-menu-mobile header-menu-layout-default"
          >
            <!--begin::Header Nav-->
            <ul class="menu-nav">
              <li
                class="menu-item  menu-item-open menu-item-submenu menu-item-rel menu-item-open"
                :class="{ 'menu-item-here':$page.url === '/' }"
                data-menu-toggle="click"
                aria-haspopup="true"
              >
                <Link href="/" class="menu-link menu-toggle">
                  <span class="menu-text">Dashboard</span>
                  <i class="menu-arrow"></i>
                </Link>
              </li>
              <li
                class="menu-item menu-item-submenu menu-item-rel"
                :class="{ 'menu-item-here': $page.url.startsWith('/inventory') }"
                data-menu-toggle="click"
                aria-haspopup="true"
              >
                <Link href="/inventory"  class="menu-link menu-toggle">
                  <span class="menu-text">Inventory</span>
                  <span class="menu-desc"></span>
                  <i class="menu-arrow"></i>
                </Link>
              </li>
              <li
                class="menu-item menu-item-submenu menu-item-rel"
                :class="{ 'menu-item-here': $page.url.startsWith('/master-data') }"
                data-menu-toggle="click"
                aria-haspopup="true"
              >
                <Link href="/master-data"  class="menu-link menu-toggle">
                  <span class="menu-text">Master Data</span>
                  <span class="menu-desc"></span>
                  <i class="menu-arrow"></i>
                </Link>
              </li>
              <li
                class="menu-item menu-item-submenu menu-item-rel"
                :class="{ 'menu-item-here':$page.url === '/accounts' }"
                data-menu-toggle="click"
                aria-haspopup="true"
              >
                <Link href="/accounts"  class="menu-link menu-toggle">
                  <span class="menu-text">Accounts</span>
                  <span class="menu-desc"></span>
                  <i class="menu-arrow"></i>
                </Link>
              </li>
              <li
                class="menu-item menu-item-submenu"
                data-menu-toggle="click"
                aria-haspopup="true"
              >
                <a href="javascript:;" class="menu-link menu-toggle">
                  <span class="menu-text">Reports</span>
                  <span class="menu-desc"></span>
                  <i class="menu-arrow"></i>
                </a>
                <div
                  class="menu-submenu menu-submenu-fixed menu-submenu-center"
                  style="width: 1150px"
                >
                  <div class="menu-subnav">
                    <ul class="menu-content">
                      <li class="menu-item">
                        <h3 class="menu-heading menu-toggle">
                          <span class="menu-text">Pricing Tables</span>
                          <i class="menu-arrow"></i>
                        </h3>
                        <ul class="menu-inner">
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/pricing/pricing-1.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Pricing Tables 1</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/pricing/pricing-2.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Pricing Tables 2</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/pricing/pricing-3.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Pricing Tables 3</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/pricing/pricing-4.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Pricing Tables 4</span>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="menu-item">
                        <h3 class="menu-heading menu-toggle">
                          <span class="menu-text">Wizards</span>
                          <i class="menu-arrow"></i>
                        </h3>
                        <ul class="menu-inner">
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/wizard/wizard-1.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Wizard 1</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/wizard/wizard-2.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Wizard 2</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/wizard/wizard-3.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Wizard 3</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/wizard/wizard-4.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Wizard 4</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/wizard/wizard-5.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Wizard 5</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/wizard/wizard-6.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Wizard 6</span>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="menu-item">
                        <h3 class="menu-heading menu-toggle">
                          <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                          </i>
                          <span class="menu-text">Invoices</span>
                          <i class="menu-arrow"></i>
                        </h3>
                        <ul class="menu-inner">
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/invoices/invoice-1.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Invoice 1</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/invoices/invoice-2.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Invoice 2</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/invoices/invoice-3.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Invoice 3</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/invoices/invoice-4.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Invoice 4</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/invoices/invoice-5.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Invoice 5</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/invoices/invoice-6.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Invoice 6</span>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="menu-item">
                        <h3 class="menu-heading menu-toggle">
                          <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                          </i>
                          <span class="menu-text">Login</span>
                          <i class="menu-arrow"></i>
                        </h3>
                        <ul class="menu-inner">
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/login-1.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 1</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/login-2.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 2</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/login-3/signup.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 3</span>
                              <span class="menu-label">
                                <span class="label label-inline label-info"
                                  >Wizard</span
                                >
                              </span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/login-4/signup.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 4</span>
                              <span class="menu-label">
                                <span class="label label-inline label-info"
                                  >Wizard</span
                                >
                              </span>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="menu-item">
                        <h3 class="menu-heading menu-toggle">
                          <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                          </i>
                          <span class="menu-text">Classic Login</span>
                          <i class="menu-arrow"></i>
                        </h3>
                        <ul class="menu-inner">
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/classic/login-1.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 1</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/classic/login-2.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 2</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/classic/login-3.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 3</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/classic/login-4.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 4</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/classic/login-5.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 5</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/login/classic/login-6.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Login 6</span>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="menu-item">
                        <h3 class="menu-heading menu-toggle">
                          <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                          </i>
                          <span class="menu-text">Error Pages</span>
                          <i class="menu-arrow"></i>
                        </h3>
                        <ul class="menu-inner">
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/error/error-1.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Error 1</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/error/error-2.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Error 2</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/error/error-3.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Error 3</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/error/error-4.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Error 4</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/error/error-5.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Error 5</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true">
                            <a
                              href="custom/pages/error/error-6.html"
                              class="menu-link"
                            >
                              <i class="menu-bullet menu-bullet-line">
                                <span></span>
                              </i>
                              <span class="menu-text">Error 6</span>
                            </a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
            </ul>
            <!--end::Header Nav-->
          </div>
          <!--end::Header Menu-->
        </div>
        <!--end::Header Menu Wrapper-->
      </div>
      <!--end::Left-->
      <!--begin::Topbar-->
      <div class="topbar">
        <!--begin::Search-->
        <div class="dropdown">
          <!--begin::Toggle-->
          <div
            class="topbar-item"
            data-toggle="dropdown"
            data-offset="10px,0px"
          >
            <div
              class="btn btn-icon btn-hover-transparent-white btn-lg btn-dropdown mr-1"
            >
              <span class="svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
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
                    <rect x="0" y="0" width="24" height="24" />
                    <path
                      d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                      fill="#000000"
                      fill-rule="nonzero"
                      opacity="0.3"
                    />
                    <path
                      d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                      fill="#000000"
                      fill-rule="nonzero"
                    />
                  </g>
                </svg>
                <!--end::Svg Icon-->
              </span>
            </div>
          </div>
          <!--end::Toggle-->
          <!--begin::Dropdown-->
          <div
            class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg"
          >
            <div
              class="quick-search quick-search-dropdown"
              id="kt_quick_search_dropdown"
            >
              <!--begin:Form-->
              <form method="get" class="quick-search-form">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <span class="svg-icon svg-icon-lg">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
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
                            <rect x="0" y="0" width="24" height="24" />
                            <path
                              d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                              fill="#000000"
                              fill-rule="nonzero"
                              opacity="0.3"
                            />
                            <path
                              d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                              fill="#000000"
                              fill-rule="nonzero"
                            />
                          </g>
                        </svg>
                        <!--end::Svg Icon-->
                      </span>
                    </span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search..."
                  />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i
                        class="quick-search-close ki ki-close icon-sm text-muted"
                      ></i>
                    </span>
                  </div>
                </div>
              </form>
              <!--end::Form-->
              <!--begin::Scroll-->
              <div
                class="quick-search-wrapper scroll"
                data-scroll="true"
                data-height="325"
                data-mobile-height="200"
              ></div>
              <!--end::Scroll-->
            </div>
          </div>
          <!--end::Dropdown-->
        </div>
        <!--end::Search-->

        <!--begin::Quick panel-->
        <div class="topbar-item">
          <div
            class="btn btn-icon btn-hover-transparent-white btn-lg mr-1"
            id="kt_quick_panel_toggle"
          >
            <span class="svg-icon svg-icon-xl">
              <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
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
                  <rect x="0" y="0" width="24" height="24" />
                  <rect
                    fill="#000000"
                    x="4"
                    y="4"
                    width="7"
                    height="7"
                    rx="1.5"
                  />
                  <path
                    d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                    fill="#000000"
                    opacity="0.3"
                  />
                </g>
              </svg>
              <!--end::Svg Icon-->
            </span>
          </div>
        </div>
        <!--end::Quick panel-->

        <!--begin::User-->
        <div class="dropdown">
          <!--begin::Toggle-->
          <div class="topbar-item">
            <div
              class="btn btn-icon btn-hover-transparent-white d-flex align-items-center btn-lg px-md-2 w-md-auto"
              id="kt_quick_user_toggle"
            >
              <span
                class="text-white opacity-70 font-weight-bold font-size-base d-none d-md-inline mr-1"
                >Hi,</span
              >
              <span
                class="text-white opacity-90 font-weight-bolder font-size-base d-none d-md-inline mr-4"
                >{{ $page.props.auth.user.name }}</span
              >
              <span class="symbol symbol-35">
                <span
                  class="symbol-label text-white font-size-h5 font-weight-bold bg-white-o-30"
                  >{{ $page.props.auth.user.name[0] }}</span
                >
              </span>
            </div>
          </div>
          <!--end::Toggle-->
        </div>
        <!--end::User-->
      </div>
      <!--end::Topbar-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Header-->
</template>
