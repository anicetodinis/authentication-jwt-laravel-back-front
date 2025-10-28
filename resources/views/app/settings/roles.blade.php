@extends('layouts.app')

@section('title', 'Gestão de Papéis (Roles)')

@section('content')
    <!--begin::Row-->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
        
    </div>
    <!--end::Row-->

    <!--begin::Modal - Add role-->
    <div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Adicionar Role</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                        <i class="ki-duotone ki-cross fs-1"><i class="path1"></i><i class="path2"></i></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_role_form" class="form" action="#">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
                            data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Role name</span>
                                </label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Nome da Role"
                                    name="role_name">
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Permissions-->
                            <div class="fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                                <!--end::Label-->

                                <!--begin::Table wrapper-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-semibold" id="permissions-list">
                                            <!-- Permissions will be loaded here dynamically -->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table wrapper-->
                            </div>
                            <!--end::Permissions-->
                        </div>
                        <!--end::Scroll-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">
                                Fechar
                            </button>

                            <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
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
    <!--end::Modal - Add role-->

    <!--begin::Modal - Update role-->
    <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Editar Role</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                        <i class="ki-duotone ki-cross fs-1"><i class="path1"></i><i class="path2"></i></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_update_role_form" class="form" action="#">
                        <input type="hidden" name="role_id" value="">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header"
                            data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Role name</span>
                                </label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Nome da Role"
                                    name="role_name">
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Permissions-->
                            <div class="fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                                <!--end::Label-->

                                <!--begin::Table wrapper-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-semibold" id="permissions-list-update">
                                            <!-- Permissions will be loaded here dynamically -->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table wrapper-->
                            </div>
                            <!--end::Permissions-->
                        </div>
                        <!--end::Scroll-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">
                                Fechar
                            </button>

                            <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                                <span class="indicator-label">
                                    Atualizar
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
    <!--end::Modal - Update role-->

@endsection

@push('scripts')
    <script type="module">
        // Função para carregar permissões no formulário
        async function loadPermissions() {
            try {
                const response = await api.get('/permissions');
                const permissions = response.data.data;
                
                const tbody = document.getElementById('permissions-list');
                tbody.innerHTML = ''; // Limpa a lista atual
                
                permissions.forEach(permission => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <!--begin::Label-->
                        <td class="text-gray-800">
                            ${permission.name}
                            <span class="badge badge-light-primary ms-2">${permission.guard_name}</span>
                        </td>
                        <!--end::Label-->
                        
                        <!--begin::Options-->
                        <td>
                            <!--begin::Wrapper-->
                            <div class="d-flex">
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" 
                                           value="${permission.id}" 
                                           name="permissions[]">
                                    <span class="form-check-label">Habilitar</span>
                                </label>
                            </div>
                            <!--end::Wrapper-->
                        </td>
                        <!--end::Options-->
                    `;
                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Erro ao carregar permissões:', error);
                alert('Não foi possível carregar a lista de permissões.');
            }
        }

        // Handler para criação de nova role
        async function handleAddRole(event) {
            event.preventDefault();
            
            const submitButton = event.target.querySelector('[data-kt-roles-modal-action="submit"]');
            const form = document.getElementById('kt_modal_add_role_form');
            const formData = new FormData(form);
            
            // Preparar dados
            const roleName = formData.get('role_name');
            const permissions = Array.from(formData.getAll('permissions[]')).map(Number);
            
            try {
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
                
                const response = await api.post('/roles', {
                    name: roleName,
                    permissions: permissions
                });
                
                // Sucesso
                const modal = document.getElementById('kt_modal_add_role');
                const bsModal = bootstrap.Modal.getInstance(modal);
                bsModal.hide();
                
                // Recarregar lista de roles
                loadRoles();
                
                // Resetar formulário
                form.reset();
                
                // Mostrar mensagem de sucesso
                toastr.success('Role criada com sucesso!');
                
            } catch (error) {
                console.error('Erro ao criar role:', error);
                let errorMessage = 'Não foi possível criar a role.';
                
                if (error.response?.data?.message) {
                    errorMessage = error.response.data.message;
                }
                
                toastr.error(errorMessage);
                
            } finally {
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;
            }
        }

        // Inicialização
        document.addEventListener('DOMContentLoaded', function() {
            // Carregar permissões quando o modal for aberto
            const addRoleModal = document.getElementById('kt_modal_add_role');
            addRoleModal.addEventListener('shown.bs.modal', loadPermissions);
            
            // Setup form submission
            const addRoleForm = document.getElementById('kt_modal_add_role_form');
            addRoleForm.addEventListener('submit', handleAddRole);

            // Setup update form submission
            const updateRoleForm = document.getElementById('kt_modal_update_role_form');
            updateRoleForm.addEventListener('submit', handleUpdateRole);
            
            // Setup modal actions
            const modal = document.getElementById('kt_modal_add_role');
            const updateModal = document.getElementById('kt_modal_update_role');
            
            // Cancel button
            modal.querySelector('[data-kt-roles-modal-action="cancel"]').addEventListener('click', e => {
                e.preventDefault();
                addRoleForm.reset();
                bootstrap.Modal.getInstance(modal).hide();
            });
            
            // Close button
            modal.querySelector('[data-kt-roles-modal-action="close"]').addEventListener('click', e => {
                e.preventDefault();
                addRoleForm.reset();
                bootstrap.Modal.getInstance(modal).hide();
            });

            // Setup update modal actions
            updateModal.querySelector('[data-kt-roles-modal-action="cancel"]').addEventListener('click', e => {
                e.preventDefault();
                updateRoleForm.reset();
                bootstrap.Modal.getInstance(updateModal).hide();
            });
            
            updateModal.querySelector('[data-kt-roles-modal-action="close"]').addEventListener('click', e => {
                e.preventDefault();
                updateRoleForm.reset();
                bootstrap.Modal.getInstance(updateModal).hide();
            });
        });

        function createRoleCard(role) {
            // Template para o card de role
            const template = `
            <div class="col-md-4">
                <div class="card card-flush h-md-100">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>${role.name}</h2>
                        </div>
                    </div>

                    <div class="card-body pt-1">
                        <div class="fw-bold text-gray-600 mb-5">
                            Role Guard: ${role.guard_name}
                        </div>

                        <div class="d-flex flex-column text-gray-600">
                            ${role.permissions.map(permission => `
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>
                                        ${permission.name}
                                    </div>
                                `).join('')}
                        </div>
                    </div>

                    <div class="card-footer flex-wrap pt-0">
                        <button type="button" class="btn btn-light btn-active-primary my-1 me-2" 
                                onclick="viewRole(${role.id})">
                            View Role
                        </button>
                        <button type="button" class="btn btn-light btn-active-light-primary my-1" 
                                onclick="editRole(${role.id})"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                            Edit Role
                        </button>
                    </div>
                </div>
            </div>
        `;

            const div = document.createElement('div');
            div.innerHTML = template.trim();
            return div.firstChild;
        }

        function createAddNewCard() {
            return `
            <div class="col-md-4">
                <div class="card h-md-100">
                    <div class="card-body d-flex flex-center">
                        <button type="button" class="btn btn-clear d-flex flex-column flex-center"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                            <img src="${hostUrl}/media/illustrations/dozzy-1/4.png" alt="" class="mw-100 mh-150px mb-7">
                            <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Adicionar Nova Role</div>
                        </button>
                    </div>
                </div>
            </div>
        `;
        }

        async function loadRoles() {
            try {
                const response = await api.get('/roles');
                const roles = response.data.data;

                // Encontrar o container onde os cards serão renderizados
                const container = document.querySelector('.row.row-cols-1.row-cols-md-2.row-cols-xl-3');
                container.innerHTML = ''; // Limpar conteúdo existente

                // Adicionar cada role card
                roles.forEach(role => {
                    const card = createRoleCard(role);
                    container.appendChild(card);
                });

                // Adicionar o card "Add New Role" no final
                container.insertAdjacentHTML('beforeend', createAddNewCard());

                // Re-inicializar componentes do tema se necessário
                if (typeof initKTComponents === 'function') {
                    initKTComponents();
                }

            } catch (error) {
                console.error('Erro ao carregar papéis:', error);
                alert('Não foi possível carregar a lista de papéis.');
            }
        }

        // Funções auxiliares para actions dos botões
        window.viewRole = function(id) {
            // Implementar visualização detalhada do papel
            console.log('Visualizar role:', id);
        };

        async function loadPermissionsForUpdate(roleId) {
            try {
                const [permissionsResponse, roleResponse] = await Promise.all([
                    api.get('/permissions'),
                    api.get(`/roles/${roleId}`)
                ]);

                const permissions = permissionsResponse.data.data;
                const role = roleResponse.data.data;
                
                // Preencher o nome da role
                const form = document.getElementById('kt_modal_update_role_form');
                form.querySelector('[name="role_name"]').value = role.name;
                form.querySelector('[name="role_id"]').value = role.id;
                
                const tbody = document.getElementById('permissions-list-update');
                tbody.innerHTML = ''; // Limpa a lista atual
                
                permissions.forEach(permission => {
                    const isChecked = role.permissions.some(p => p.id === permission.id);
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <!--begin::Label-->
                        <td class="text-gray-800">
                            ${permission.name}
                            <span class="badge badge-light-primary ms-2">${permission.guard_name}</span>
                        </td>
                        <!--end::Label-->
                        
                        <!--begin::Options-->
                        <td>
                            <!--begin::Wrapper-->
                            <div class="d-flex">
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" 
                                           value="${permission.id}" 
                                           name="permissions[]"
                                           ${isChecked ? 'checked' : ''}>
                                    <span class="form-check-label">Habilitar</span>
                                </label>
                            </div>
                            <!--end::Wrapper-->
                        </td>
                        <!--end::Options-->
                    `;
                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Erro ao carregar dados para edição:', error);
                toastr.error('Não foi possível carregar os dados da role.');
            }
        }

        // Handler para atualização de role
        async function handleUpdateRole(event) {
            event.preventDefault();
            
            const submitButton = event.target.querySelector('[data-kt-roles-modal-action="submit"]');
            const form = document.getElementById('kt_modal_update_role_form');
            const formData = new FormData(form);
            
            // Preparar dados
            const roleId = formData.get('role_id');
            const roleName = formData.get('role_name');
            const permissions = Array.from(formData.getAll('permissions[]')).map(Number);
            
            try {
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
                
                const response = await api.put(`/roles/${roleId}`, {
                    name: roleName,
                    permissions: permissions
                });
                
                // Sucesso
                const modal = document.getElementById('kt_modal_update_role');
                const bsModal = bootstrap.Modal.getInstance(modal);
                bsModal.hide();
                
                // Recarregar lista de roles
                loadRoles();
                
                // Resetar formulário
                form.reset();
                
                // Mostrar mensagem de sucesso
                toastr.success('Role atualizada com sucesso!');
                
            } catch (error) {
                console.error('Erro ao atualizar role:', error);
                let errorMessage = 'Não foi possível atualizar a role.';
                
                if (error.response?.data?.message) {
                    errorMessage = error.response.data.message;
                }
                
                toastr.error(errorMessage);
                
            } finally {
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;
            }
        }

        window.editRole = function(id) {
            loadPermissionsForUpdate(id);
        };

        // Carregar roles ao iniciar
        loadRoles();
    </script>
@endpush
