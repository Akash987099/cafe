<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon.png">
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <title>
        {{setting('web_name')->name}}
    </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/admin/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
    <script defer data-site="aryaai.cloud" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/message.js') }}"></script>
    <script src="{{ asset('assets/js/search.js') }}"></script>
    <script src="{{ asset('assets/js/delete.js') }}"></script>
    <script src="{{ asset('assets/js/common.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<style>
    #sidenav-main {
        height: calc(100vh - 2rem);
    }

    #sidenav-main .navbar-collapse {
        overflow-y: auto;
        max-height: calc(100vh - 120px);
        scrollbar-width: thin;
        /* Firefox */
    }

    /* Chrome / Edge scrollbar */
    #sidenav-main .navbar-collapse::-webkit-scrollbar {
        width: 6px;
    }

    #sidenav-main .navbar-collapse::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 10px;
    }

    .side-submenu .nav-link {
        padding-top: 0.35rem;
        padding-bottom: 0.35rem;
        margin-left: 2.5rem;
        padding-left: 1rem;
        font-size: 0.78rem;
    }

    .side-submenu .nav-link i {
        width: 16px;
        margin-right: 0.45rem;
        text-align: center;
    }
</style>


<body class="g-sidenav-show  bg-gray-100">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs overflow-hidden border-radius-xl my-3 fixed-start ms-3 border shadow-sm border-black"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html "
                target="_blank">
                <img src="{{ asset(setting('web_name')->image ?? '') }}" class="navbar-brand-img h-auto bg-black" alt="main_logo">
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse !min-[100vh] w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-gauge text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('category.*') || request()->routeIs('sub_category.*') || request()->routeIs('brand.*') || request()->routeIs('discount.*') || request()->routeIs('product.*') || request()->routeIs('store.*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#sidebarManagement" role="button"
                        aria-expanded="{{ request()->routeIs('users.*') || request()->routeIs('category.*') || request()->routeIs('sub_category.*') || request()->routeIs('brand.*') || request()->routeIs('discount.*') || request()->routeIs('product.*') || request()->routeIs('store.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarManagement">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-layer-group text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Management</span>
                    </a>
                    <div class="collapse {{ request()->routeIs('users.*') || request()->routeIs('category.*') || request()->routeIs('sub_category.*') || request()->routeIs('brand.*') || request()->routeIs('discount.*') || request()->routeIs('product.*') || request()->routeIs('store.*') ? 'show' : '' }}"
                        id="sidebarManagement">
                        <div class="side-submenu">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                href="{{ route('users.index') }}"><i class="fas fa-users"></i>Users</a>
                            <a class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}"
                                href="{{ route('category.index') }}"><i class="fas fa-list"></i>Category</a>
                            <a class="nav-link {{ request()->routeIs('sub_category.*') ? 'active' : '' }}"
                                href="{{ route('sub_category.index') }}"><i class="fas fa-list-ul"></i>Sub Category</a>
                            <a class="nav-link {{ request()->routeIs('brand.*') ? 'active' : '' }}"
                                href="{{ route('brand.index') }}"><i class="fas fa-tags"></i>Brands</a>
                            <a class="nav-link {{ request()->routeIs('discount.*') ? 'active' : '' }}"
                                href="{{ route('discount.index') }}"><i class="fas fa-percent"></i>Discount</a>
                            <a class="nav-link {{ request()->routeIs('product.*') ? 'active' : '' }}"
                                href="{{ route('product.index') }}"><i class="fas fa-box-open"></i>Product</a>
                            <a class="nav-link {{ request()->routeIs('store.*') ? 'active' : '' }}"
                                href="{{ route('store.index') }}"><i class="fas fa-store"></i>Store</a>
                            <a class="nav-link {{ request()->routeIs('attribute.*') ? 'active' : '' }}"
                                href="{{ route('attribute.index') }}"><i class="fas fa-store"></i>Attribute</a>
                            <a class="nav-link {{ request()->routeIs('attribute_value.*') ? 'active' : '' }}"
                                href="{{ route('attribute_value.index') }}"><i class="fas fa-store"></i>Attribute Value</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('status.*') || request()->routeIs('country.*') || request()->routeIs('state.*') || request()->routeIs('district.*') || request()->routeIs('tehsil.*') || request()->routeIs('block.*') || request()->routeIs('village.*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#sidebarMaster" role="button"
                        aria-expanded="{{ request()->routeIs('status.*') || request()->routeIs('country.*') || request()->routeIs('state.*') || request()->routeIs('district.*') || request()->routeIs('tehsil.*') || request()->routeIs('block.*') || request()->routeIs('village.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarMaster">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-sitemap text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Master</span>
                    </a>
                    <div class="collapse {{ request()->routeIs('status.*') || request()->routeIs('country.*') || request()->routeIs('state.*') || request()->routeIs('district.*') || request()->routeIs('tehsil.*') || request()->routeIs('block.*') || request()->routeIs('village.*') ? 'show' : '' }}"
                        id="sidebarMaster">
                        <div class="side-submenu">
                            <a class="nav-link {{ request()->routeIs('status.*') ? 'active' : '' }}"
                                href="{{ route('status.index') }}"><i class="fas fa-toggle-on"></i>Status</a>
                            <a class="nav-link {{ request()->routeIs('country.*') ? 'active' : '' }}"
                                href="{{ route('country.index') }}"><i class="fas fa-earth-asia"></i>Country</a>
                            <a class="nav-link {{ request()->routeIs('state.*') ? 'active' : '' }}"
                                href="{{ route('state.index') }}"><i class="fas fa-map"></i>State</a>
                            <a class="nav-link {{ request()->routeIs('district.*') ? 'active' : '' }}"
                                href="{{ route('district.index') }}"><i class="fas fa-location-dot"></i>District</a>
                            <a class="nav-link {{ request()->routeIs('tehsil.*') ? 'active' : '' }}"
                                href="{{ route('tehsil.index') }}"><i class="fas fa-map-pin"></i>Tehsil</a>
                            <a class="nav-link {{ request()->routeIs('block.*') ? 'active' : '' }}"
                                href="{{ route('block.index') }}"><i class="fas fa-vector-square"></i>Block</a>
                            <a class="nav-link {{ request()->routeIs('village.*') ? 'active' : '' }}"
                                href="{{ route('village.index') }}"><i class="fas fa-house"></i>Village</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('summer.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-sun text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Summer Section</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('supplier.*') || request()->is('buyer*') || request()->is('demand*') || request()->is('sell*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#sidebarTrading" role="button"
                        aria-expanded="{{ request()->routeIs('supplier.*') || request()->is('buyer*') || request()->is('demand*') || request()->is('sell*') ? 'true' : 'false' }}"
                        aria-controls="sidebarTrading">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Trading</span>
                    </a>
                    <div class="collapse {{ request()->routeIs('supplier.*') || request()->is('buyer*') || request()->is('demand*') || request()->is('sell*') ? 'show' : '' }}"
                        id="sidebarTrading">
                        <div class="side-submenu">
                            <a class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}"
                                href="{{ route('supplier.index') }}"><i class="fas fa-truck-field"></i>Supplier</a>
                            <a class="nav-link" href="{{ route('buyer.index') }}"><i class="fas fa-user-tie"></i>Buyer</a>
                            <a class="nav-link" href="#"><i class="fas fa-bullhorn"></i>Demand</a>
                            <a class="nav-link" href="#"><i class="fas fa-cart-shopping"></i>Sell</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('order.*') || request()->is('buyer*') || request()->is('demand*') || request()->is('sell*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#sidebarOrder" role="button"
                        aria-expanded="{{ request()->routeIs('order.*') || request()->is('buyer*') || request()->is('demand*') || request()->is('sell*') ? 'true' : 'false' }}"
                        aria-controls="sidebarOrder">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Order Management</span>
                    </a>
                    <div class="collapse {{ request()->routeIs('order.*') || request()->is('barcode*') || request()->is('demand*') || request()->is('sell*') ? 'show' : '' }}"
                        id="sidebarOrder">
                        <div class="side-submenu">
                            <a class="nav-link {{ request()->routeIs('order.*') ? 'active' : '' }}"
                                href="{{ route('order.index') }}"><i class="fas fa-truck-field"></i>Order</a>

                            <a class="nav-link {{ request()->routeIs('barcodes.*') ? 'active' : '' }}"
                                href="{{ route('order.barcodes') }}"><i class="fas fa-truck-field"></i>Barcode</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cafe.*') || request()->is('type*') || request()->is('category*') || request()->is('sell*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#sidebarCafe" role="button"
                        aria-expanded="{{ request()->routeIs('order.*') || request()->is('type*') || request()->is('category*') || request()->is('sell*') ? 'true' : 'false' }}"
                        aria-controls="sidebarCafe">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Cafe Management</span>
                    </a>
                    <div class="collapse {{ request()->routeIs('type.*') || request()->is('barcode*') || request()->is('demand*') || request()->is('sell*') ? 'show' : '' }}"
                        id="sidebarCafe">
                        <div class="side-submenu">
                            <a class="nav-link {{ request()->routeIs('cafe.type*') ? 'active' : '' }}"
                                href="{{ route('cafe.type.index') }}"><i class="fas fa-truck-field"></i>Type</a>

                            <a class="nav-link {{ request()->routeIs('cafe.category*') ? 'active' : '' }}"
                                href="{{ route('cafe.category.index') }}"><i class="fas fa-truck-field"></i>Category</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tax.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>office</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF"
                                        fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g id="office" transform="translate(153.000000, 2.000000)">
                                                <path class="color-background opacity-6"
                                                    d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">Taxes</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('slider.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>office</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF"
                                        fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g id="office" transform="translate(153.000000, 2.000000)">
                                                <path class="color-background opacity-6"
                                                    d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">Slider</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('promotional.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>office</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF"
                                        fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g id="office" transform="translate(153.000000, 2.000000)">
                                                <path class="color-background opacity-6"
                                                    d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">Promotional</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cms.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>office</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF"
                                        fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g id="office" transform="translate(153.000000, 2.000000)">
                                                <path class="color-background opacity-6"
                                                    d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">CMS</span>
                    </a>
                </li>

                <li class="nav-item mt-3">
                    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sidebarReports" role="button"
                        aria-expanded="false" aria-controls="sidebarReports">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-chart-line text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Reports</span>
                    </a>
                    <div class="collapse" id="sidebarReports">
                        <div class="side-submenu">
                            <a class="nav-link" href="{{ route('transaction') }}">
                                <i class="fas fa-receipt"></i>Transaction
                            </a>
                        </div>
                    </div>
                </li>

                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link  " href="{{ route('setting.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>Settings</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF"
                                        fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(1.000000, 0.000000)">
                                                <path class="color-background opacity-6"
                                                    d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">Settings</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  " href="{{ route('email_template.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>Settings</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF"
                                        fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(1.000000, 0.000000)">
                                                <path class="color-background opacity-6"
                                                    d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">Email Template</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/logout">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="14px" height="14px" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#344767" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">Sign Out</span>
                    </a>
                </li>

            </ul>
        </div>

    </aside>
