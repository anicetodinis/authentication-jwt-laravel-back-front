@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
        Dashboard
    </li>
@endsection

@section('content')
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-4">
            <!--begin::Card-->
            <div class="card card-flush h-md-100">
                <!--begin::Card header-->
                <div class="card-header pt-5">
                    <!--begin::Card title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $stats['total_users'] ?? 0 }}</span>
                        <!--end::Info-->
                        <!--begin::Subtitle-->
                        <span class="text-gray-400 pt-1 fw-semibold fs-6">Total de Utilizadores</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-md-4">
            <!--begin::Card-->
            <div class="card card-flush h-md-100">
                <!--begin::Card header-->
                <div class="card-header pt-5">
                    <!--begin::Card title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $stats['active_users'] ?? 0 }}</span>
                        <!--end::Info-->
                        <!--begin::Subtitle-->
                        <span class="text-gray-400 pt-1 fw-semibold fs-6">Utilizadores Ativos</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-md-4">
            <!--begin::Card-->
            <div class="card card-flush h-md-100">
                <!--begin::Card header-->
                <div class="card-header pt-5">
                    <!--begin::Card title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $stats['new_users_today'] ?? 0 }}</span>
                        <!--end::Info-->
                        <!--begin::Subtitle-->
                        <span class="text-gray-400 pt-1 fw-semibold fs-6">Novos Hoje</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row g-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-12">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Bem-vindo</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Sistema de Gestão</span>
                    </h3>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Content-->
                    <div class="d-flex flex-column">
                        <p class="text-gray-600 fs-6">Gerencie utilizadores, processos e muito mais através do menu lateral.</p>
                        <!--begin::Actions-->
                        <div class="d-flex flex-wrap">
                            <a href="#" class="btn btn-primary me-3">
                                <i class="ki-duotone ki-user-tick fs-2 me-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>
                                Gerir Utilizadores
                            </a>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
@endsection