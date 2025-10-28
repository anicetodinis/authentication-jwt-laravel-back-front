@extends('layouts.app')

@section('title', 'Gestão de Permissões (Roles)')

@section('content')

    <!--begin::Card-->
    <div class="card card-flush ">
        <!--begin::Card header-->
        <div class="card-header mt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1 me-5">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><i class="path1"></i><i
                            class="path2"></i></i> <input type="text" data-kt-permissions-table-filter="search"
                        class="form-control form-control-solid w-250px ps-15" placeholder="Pesquisar Permissão" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Button-->
                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_add_permission">
                    <i class="ki-duotone ki-plus-square fs-3"><i class="path1"></i><i class="path2"></i><i
                            class="path3"></i></i> Adicionar Permissão
                </button>
                <!--end::Button-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Nome</th>
                        <th class="min-w-250px">Autenticação em</th>
                        <th class="min-w-125px">Criado</th>
                        <th class="text-end min-w-100px">Acções</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->

                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                    <tr class="align-middle placeholder-glow">
                        <td><span class="placeholder col-4"></span></td>
                        <td><span class="placeholder col-4"></span></td>
                        <td><span class="placeholder col-12"></span></td>
                        <td><span class="placeholder col-4"></span></td>
                    </tr>
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->




    <div class="modal fade" id="kt_modal_add_permission" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Adicionar Permissão</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-permissions-modal-action="close">
                        <i class="ki-duotone ki-cross fs-1"><i class="path1"></i><i class="path2"></i></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_permission_form" class="form" action="#">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">
                                <span class="required">Permission Name</span>

                                <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true"
                                    data-bs-content="Permission names is required to be unique.">
                                </span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="Enter a permission name"
                                name="permission_name">
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid me-9">
                                <input class="form-check-input" type="checkbox" value="" name="permissions_core"
                                    id="kt_permissions_core">
                                <span class="form-check-label" for="kt_permissions_core">
                                    Set as core permission
                                </span>
                            </label>
                            <!--end::Checkbox-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Disclaimer-->
                        <div class="text-gray-600">Permission set as a <strong class="me-1">Core Permission</strong> will
                            be locked and
                            <strong class="me-1">not editable</strong> in future
                        </div>
                        <!--end::Disclaimer-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">
                                Fechar
                            </button>

                            <button type="submit" class="btn btn-primary" data-kt-permissions-modal-action="submit">
                                <span class="indicator-label">
                                    Submeter
                                </span>
                                <span class="indicator-progress">
                                    Aguarde... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection

@push('scripts')
<script type="module">
    // Função para criar uma linha da tabela de permissões
    function createPermissionRow(permission) {
        return `
            <tr>
                <!--begin::Name--->
                <td>${permission.name}</td>
                <!--end::Name--->

                <!--begin::Assigned to--->
                <td>
                    <span class="badge badge-light-primary fs-7 m-1">${permission.guard_name}</span>
                </td>
                <!--end::Assigned to--->

                <!--begin::Created Date-->
                <td>${permission.created_at}</td>
                <!--end::Created Date-->

                <!--begin::Action--->
                <td class="text-end">
                    <!--begin::Update-->
                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" 
                            data-bs-toggle="modal"
                            data-bs-target="#kt_modal_update_permission"
                            onclick="editPermission(${permission.id})">
                        <i class="ki-duotone ki-setting-3 fs-3">
                            <i class="path1"></i>
                            <i class="path2"></i>
                            <i class="path3"></i>
                        </i>
                    </button>
                    <!--end::Update-->

                    <!--begin::Delete-->
                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px"
                            onclick="deletePermission(${permission.id})">
                        <i class="ki-duotone ki-trush fs-3"></i>
                    </button>
                    <!--end::Delete-->
                </td>
                <!--end::Action--->
            </tr>
        `;
    }

    // Função para carregar a lista de permissões
    async function loadPermissions() {
        try {
            const response = await api.get('/permissions');
            const permissions = response.data.data;

            const tbody = document.querySelector('#kt_permissions_table tbody');
            tbody.innerHTML = ''; // Limpa a tabela

            permissions.forEach(permission => {
                tbody.insertAdjacentHTML('beforeend', createPermissionRow(permission));
            });

            // Inicializa a busca na tabela
            initSearch();

        } catch (error) {
            console.error('Erro ao carregar permissões:', error);
            toastr.error('Não foi possível carregar a lista de permissões.');
        }
    }

    // Função para inicializar a busca
    function initSearch() {
        const searchInput = document.querySelector('[data-kt-permissions-table-filter="search"]');
        searchInput.addEventListener('keyup', function(e) {
            const searchText = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#kt_permissions_table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    }

    // Função para criar nova permissão
    async function handleAddPermission(event) {
        event.preventDefault();
        
        const form = document.getElementById('kt_modal_add_permission_form');
        const submitButton = form.querySelector('[data-kt-permissions-modal-action="submit"]');
        const formData = new FormData(form);
        
        try {
            submitButton.setAttribute('data-kt-indicator', 'on');
            submitButton.disabled = true;
            
            const response = await api.post('/permissions', {
                name: formData.get('permission_name'),
                guard_name: 'api', // Valor padrão
                core: formData.get('permissions_core') === 'on'
            });
            
            // Fechar modal
            const modal = document.getElementById('kt_modal_add_permission');
            const bsModal = bootstrap.Modal.getInstance(modal);
            bsModal.hide();
            
            // Recarregar lista
            await loadPermissions();
            
            // Resetar formulário
            form.reset();
            
            toastr.success('Permissão criada com sucesso!');
            
        } catch (error) {
            console.error('Erro ao criar permissão:', error);
            let errorMessage = 'Não foi possível criar a permissão.';
            
            if (error.response?.data?.message) {
                errorMessage = error.response.data.message;
            }
            
            toastr.error(errorMessage);
            
        } finally {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
        }
    }

    // Função para deletar permissão
    window.deletePermission = async function(id) {
        if (confirm('Tem certeza que deseja excluir esta permissão?')) {
            try {
                await api.delete(`/permissions/${id}`);
                await loadPermissions();
                toastr.success('Permissão excluída com sucesso!');
            } catch (error) {
                console.error('Erro ao excluir permissão:', error);
                toastr.error('Não foi possível excluir a permissão.');
            }
        }
    };

    // Inicialização
    document.addEventListener('DOMContentLoaded', function() {
        // Carregar permissões
        loadPermissions();
        
        // Setup form submission
        const addPermissionForm = document.getElementById('kt_modal_add_permission_form');
        addPermissionForm.addEventListener('submit', handleAddPermission);
        
        // Setup modal actions
        const modal = document.getElementById('kt_modal_add_permission');
        
        // Cancel button
        modal.querySelector('[data-kt-permissions-modal-action="cancel"]').addEventListener('click', e => {
            e.preventDefault();
            addPermissionForm.reset();
            bootstrap.Modal.getInstance(modal).hide();
        });
        
        // Close button
        modal.querySelector('[data-kt-permissions-modal-action="close"]').addEventListener('click', e => {
            e.preventDefault();
            addPermissionForm.reset();
            bootstrap.Modal.getInstance(modal).hide();
        });
    });
</script>
@endpush