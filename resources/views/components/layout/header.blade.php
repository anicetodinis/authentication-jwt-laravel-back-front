<div id="kt_app_header" class="app-header " data-kt-sticky="true"
    data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
    data-kt-sticky-offset="{default: '200px', lg: '300px'}" data-kt-sticky-animation="false">

    <!--begin::Header container-->
    <div class="app-container  container-fluid d-flex align-items-stretch flex-stack "
        id="kt_app_header_container">
        <!--begin::Sidebar toggle-->
        <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
            <div class="btn btn-icon btn-color-gray-600 btn-active-color-primary w-35px h-35px me-1"
                id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2"><i class="path1"></i><i class="path2"></i></i>
            </div>

            <!--begin::Logo image-->
            <a href="{{ route('dashboard') }}">
                <img alt="Logo" src="{{ asset('assets/media/logos/default-dark.svg') }}" class="h-30px">
            </a>
            <!--end::Logo image-->
        </div>
        <!--end::Sidebar toggle-->

        <!--begin::Navbar-->
        <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
            <div class="app-navbar-item d-flex align-items-center flex-lg-grow-1 me-2 me-lg-0">
                <!-- Search placeholder -->
            </div>

            <!--begin::Actions-->
            <div class="d-flex align-self-center flex-center flex-shrink-0">
                <a href="#" class="btn btn-sm btn-warning d-flex flex-center ms-3 px-4 py-3"
                    data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                    <i class="ki-duotone ki-plus-square fs-2 text-gray-400"><i class="path1"></i><i
                            class="path2"></i><i class="path3"></i></i>
                    <span>Notificações</span>
                </a>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Navbar-->
    </div>
    <!--end::Header container-->
</div>