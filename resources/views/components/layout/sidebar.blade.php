<?php
function getInitials(string $name = ''): string
{
    // 1. O equivalente a `if (!name) return '...';`
    if (empty($name)) {
        return '...';
    }
    // 2. Separa a string por espaços (`.split(' ')` em JS)
    $words = explode(' ', $name);
    $initials = '';
    // 3. Itera sobre cada palavra (`.map(word => word[0])` em JS)
    foreach ($words as $word) {
        // Pega apenas a primeira letra de cada palavra
        if (!empty($word)) {
            // Em PHP, para caracteres multi-byte (como acentos), usamos mb_substr
            $initials .= mb_substr($word, 0, 1);
        }
    }
    // 4. Junta as letras (implode), converte para maiúsculas e limita a 2 caracteres
    //    (.join('').toUpperCase().slice(0, 2) em JS)
    return mb_strtoupper(mb_substr($initials, 0, 2));
}

?>


<div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="300px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <!--begin::Header-->
    <div class="app-sidebar-header flex-column mx-10 pt-8" id="kt_app_sidebar_header">
        <!--begin::Brand-->
        <div class="d-flex flex-stack d-none d-lg-flex mb-13">
            <!--begin::Logo-->
            <a href="{{ route('dashboard') }}" class="app-sidebar-logo">
                <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" height="128"
                    class="app-sidebar-logo-default">
            </a>
            <!--end::Logo-->
        </div>
        <!--end::Brand-->

        <!--begin::User-->
        <div class="d-flex  btn btn-outline btn-custom align-items-center w-100 mb-2"
            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-start">
            <!--begin::User-->
            <div class="cursor-pointer symbol symbol-35px symbol-lg-40px me-3 ms-n2">
                <div class="symbol-label bg-light-primary text-primary fs-5 fw-bold" id="sidebar-user-initials">{{getInitials($user->name ?? '')}}
                </div>
            </div>
            <!--end::User-->

            <!--begin:Info-->
            <div class="d-flex flex-column align-items-start flex-grow-1">
                <a href="#" class="btn-title fs-6 fw-bold"
                    id="sidebar-user-name">{{ auth('web')->user()?->name }}</a>
                <a href="#" class="btn-desc fs-7 fw-bold d-block" id="sidebar-user-email">{{ $user->email }}</a>
            </div>
            <!--end:Info-->

            <i class="ki-duotone ki-icons/duotune/general/gen033.svg  btn-icon fs-2 me-n2"></i>
        </div>
        <!--end::User-->
        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        <div class="symbol-label bg-light-primary text-primary fs-3 fw-bold"
                            id="sidebar-menu-user-initials"> {{getInitials($user->name ?? '')}} </div>
                    </div>
                    <!--end::Avatar-->

                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5" id="sidebar-menu-user-name">
                            {{ $user->name }}
                        </div>

                        <a href="#" class="fw-semibold text-muted text-hover-primary fs-7"
                            id="sidebar-menu-user-email">
                            {{ $user->getRoleNames()->first() }}
                        </a>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="#" class="menu-link px-5">
                    Perfil
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->

            <!--begin::Menu item-->
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title position-relative">
                        Modo

                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                            <i class="ki-duotone ki-night-day theme-light-show fs-2"><i class="path1"></i><i
                                    class="path2"></i><i class="path3"></i><i class="path4"></i><i
                                    class="path5"></i><i class="path6"></i><i class="path7"></i><i
                                    class="path8"></i><i class="path9"></i><i class="path10"></i></i> <i
                                class="ki-duotone ki-moon theme-dark-show fs-2"><i class="path1"></i><i
                                    class="path2"></i></i> </span>
                    </span>
                </a>

                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-night-day fs-2"><i class="path1"></i><i class="path2"></i><i
                                        class="path3"></i><i class="path4"></i><i class="path5"></i><i
                                        class="path6"></i><i class="path7"></i><i class="path8"></i><i
                                        class="path9"></i><i class="path10"></i></i> </span>
                            <span class="menu-title">
                                Claro
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-moon fs-2"><i class="path1"></i><i class="path2"></i></i>
                            </span>
                            <span class="menu-title">
                                Escuro
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-screen fs-2"><i class="path1"></i><i class="path2"></i><i
                                        class="path3"></i><i class="path4"></i></i>
                            </span>
                            <span class="menu-title">
                                Sistema
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->

            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-5 my-1">
                <a href="#" class="menu-link px-5">
                    Definições da Conta
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="#" onclick="logout()" class="menu-link px-5">
                    Sair
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->
    </div>
    <!--end::Header-->

    <!--begin::Navs-->
    <div class="app-sidebar-navs flex-column-fluid pb-6" id="kt_app_sidebar_navs">
        <div id="kt_app_sidebar_navs_wrappers" class="hover-scroll-y my-2" data-kt-scroll="true"
            data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_header" data-kt-scroll-wrappers="#kt_app_sidebar_navs"
            data-kt-scroll-offset="5px">

            <!--begin::Sidebar menu-->
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                class="menu menu-column menu-rounded menu-sub-indention menu-active-bg mb-7">

                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-5">Painel</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-element-11 fs-1">
                                <i class="path1"></i><i class="path2"></i><i class="path3"></i><i
                                    class="path4"></i>
                            </i>
                        </span>
                        <span class="menu-title">Principal</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <div class="menu-item pt-7">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-5">Paginas</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                @if ($user->hasRole(['super-admin', 'admin']))
                    <!-- Gestão de Utilizadores -->
                    <div data-kt-menu-trigger="click"
                        class="menu-item {{ request()->is('users*') ? 'here show' : '' }} menu-accordion">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-profile-user">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">Gestão de Utilizadores</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->

                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click"
                                class="menu-item {{ request()->is('users*') ? 'here show' : '' }} menu-accordion mb-1">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Utilizadores</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->

                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                            href="{{ route('users.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Lista</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click"
                                class="menu-item {{ request()->is('users*') ? 'here show' : '' }} menu-accordion mb-1">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Settings</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->

                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    @if ($user->hasAnyPermission(['manage roles']))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->routeIs('settings.roles') ? 'active' : '' }}"
                                                href="{{ route('settings.roles') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Roles</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif

                                    @if ($user->hasAnyPermission(['manage permissions']))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->routeIs('settings.permissions') ? 'active' : '' }}"
                                                href="{{ route('settings.permissions') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Permissões</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                <!--end:Menu item-->
                @endif
            </div>
            <!--end::Sidebar menu-->
        </div>
    </div>
    <!--end::Navs-->
</div>
