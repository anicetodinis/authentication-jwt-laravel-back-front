@php
    $title = $title ?? 'Dashboard';
    $breadcrumbs = $breadcrumbs ?? [];
@endphp

<div id="kt_app_toolbar" class="app-toolbar ">

    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container"
        class="container-fluid d-flex flex-lg-column py-3 py-lg-6 ">

        <!--begin::Page title-->
        <div class="page-title d-flex align-items-center gap-1 me-3" data-kt-swapper="true"
            data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
            data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}">
            <!--begin::Title-->
            <span class="text-gray-900 fw-bolder fs-2x">
                {{ $title }}
            </span>
            <!--end::Title-->

            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base ms-3">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 text-hover-primary">
                        <i class="ki-duotone ki-home fs-3 text-gray-400 ms-2"></i>
                    </a>
                </li>
                <!--end::Item-->

                @foreach($breadcrumbs as $breadcrumb)
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n2"></i>
                    </li>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <li class="breadcrumb-item {{ $loop->last ? 'text-gray-500' : 'text-gray-700 fw-bold lh-1' }}">
                        @if(!$loop->last && isset($breadcrumb['url']))
                            <a href="{{ $breadcrumb['url'] }}" class="text-gray-700 text-hover-primary">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @else
                            {{ $breadcrumb['label'] }}
                        @endif
                    </li>
                    <!--end::Item-->
                @endforeach
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar container-->
</div>