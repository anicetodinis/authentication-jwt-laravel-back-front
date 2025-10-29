@extends('layouts.app')

@section('title', 'Gestão de Utilizadores')

@section('content')
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><i class="path1"></i><i
                            class="path2"></i></i> <input type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Pesquisar Utilizador">
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-2"><i class="path1"></i><i class="path2"></i></i> Filtro
                    </button>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Opções de Filtro</div>
                        </div>
                        <!--end::Header-->

                        <!--begin::Separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Separator-->

                        <!--begin::Content-->
                        <div class="px-7 py-5" data-kt-user-table-filter="form">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Role:</label>
                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                    data-placeholder="Select option" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="true">
                                    <option></option>
                                    <option value="Administrator">Administrador</option>
                                    <option value="Analyst">Tecnico</option>
                                </select>
                            </div>
                            <!--end::Input group-->


                            <!--end::Input group-->

                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                    data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true"
                                    data-kt-user-table-filter="filter">Aplicar</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1--> <!--end::Filter-->

                    <!--begin::Export-->
                    {{-- <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_export_users">
                        <i class="ki-duotone ki-exit-up fs-2"><i class="path1"></i><i class="path2"></i></i> Exportar
                    </button> --}}
                    <!--end::Export-->

                    <!--begin::Add user-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_user">
                        <i class="ki-duotone ki-plus fs-2"></i> Adicionar Utilizador
                    </button>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <div class="card-body py-4">
            <table class="table align-middle table-striped table-row-dashed fs-6 gy-5" id="kt_table_users">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Utilizador</th>
                        <th class="min-w-125px">E-mail</th>
                        <th class="min-w-125px">Data de Criação</th>
                        <th class="text-end min-w-100px">Acções</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold" id="users-list-body">
                    <tr class="align-middle placeholder-glow">
                        <td><span class="placeholder col-4"></span></td>
                        <td><span class="placeholder col-4"></span></td>
                        <td><span class="placeholder col-12"></span></td>
                        <td><span class="placeholder col-4"></span></td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-8">
                <div>
                    <span id="users-info" class="me-3">Mostrando 0 a 0 de 0 dados</span>
                </div>
                <div class="d-flex justify-content-end">
                    <ul id="users-pagination" class="pagination pagination-outline text-end">
                        <!-- Pagination buttons will be injected here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog  modal-dialog-centered mw-950px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Adicionar Utilizador</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-duotone ki-cross fs-1"><i class="path1"></i><i class="path2"></i></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_user_form" class="form" action="#">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                                <!--end::Label-->


                                <!--begin::Image placeholder-->
                                <style>
                                    .image-input-placeholder {
                                        background-image: url('assets/media/svg/files/blank-image.svg');
                                    }

                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url('assets/media/svg/files/blank-image-dark.svg');
                                    }
                                </style>
                                <!--end::Image placeholder-->
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline image-input-placeholder"
                                    data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url(assets/media/avatars/300-6.jpg);">
                                    </div>
                                    <!--end::Preview existing avatar-->

                                    <!--begin::Label-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-7"><i class="path1"></i><i
                                                class="path2"></i></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                        <input type="hidden" name="avatar_remove">
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Cancel-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="Cancel avatar">
                                        <i class="ki-duotone ki-cross fs-2"><i class="path1"></i><i
                                                class="path2"></i></i> </span>
                                    <!--end::Cancel-->

                                    <!--begin::Remove-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="Remove avatar">
                                        <i class="ki-duotone ki-cross fs-2"><i class="path1"></i><i
                                                class="path2"></i></i> </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->

                                <!--begin::Hint-->
                                <div class="form-text">Tipos permitidos: png,
                                    jpg, jpeg.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nome Completo</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input id="name" type="text" name="name"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nome Completo">
                                <div class="invalid-feedback" id="error-name"></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Email</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input id="email" type="email" name="email"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com"
                                    value="smith@kpmg.com">
                                <div class="invalid-feedback" id="error-email"></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Password</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input id="password" type="password" name="password"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password">
                                <div class="invalid-feedback" id="error-password"></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Confirmar Password</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Confirm Password">
                                <div class="invalid-feedback" id="error-password_confirmation"></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-5">Role</label>
                                <!--end::Label-->

                                <!--begin::Roles - will be populated dynamically-->
                                <div id="user-roles-list" class="d-flex flex-column"></div>
                                <div class="invalid-feedback d-block" id="error-role_id" style="display:none;"></div>
                                <!--end::Roles-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                Fechar
                            </button>

                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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
    <!--end::Modal - Add task-->

    @include('components.users.modals')
@endsection

@push('scripts')
    <script>
        // Funções globais para editar e deletar usuário
        async function handleEditUser(userId) {
            try {
                // Buscar dados do usuário
                const response = await api.get(`/users/${userId}`);
                const user = response.data.data;

                // Preencher o formulário
                const form = document.getElementById('kt_modal_edit_user_form');
                form.querySelector('#edit_user_id').value = user.id;
                form.querySelector('#edit_name').value = user.name;
                form.querySelector('#edit_email').value = user.email;
                
                // Carregar roles
                await window.loadRolesForEditUserForm(user.roles[0]?.name);

                // Abrir o modal
                const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_user'));
                modal.show();
            } catch (error) {
                console.error('Erro ao carregar dados do usuário:', error);
                toastr.error('Não foi possível carregar os dados do usuário.');
            }
        }

        async function handleDeleteUser(userId) {
            // Abrir modal de confirmação
            const modal = new bootstrap.Modal(document.getElementById('kt_modal_delete_user'));
            modal.show();

            // Configurar botão de delete
            const deleteButton = document.querySelector('[data-kt-users-modal-action="delete"]');
            deleteButton.onclick = async () => {
                try {
                    deleteButton.setAttribute('data-kt-indicator', 'on');
                    deleteButton.disabled = true;

                    await api.delete(`/users/${userId}`);
                    
                    modal.hide();
                    window.loadUsers(1);
                    toastr.success('Utilizador eliminado com sucesso!');

                } catch (error) {
                    console.error('Erro ao eliminar utilizador:', error);
                    toastr.error(error.response?.data?.message || 'Não foi possível eliminar o utilizador.');
                } finally {
                    deleteButton.removeAttribute('data-kt-indicator');
                    deleteButton.disabled = false;
                }
            };
        }
    </script>
    <script type="module">
        // import api from '{{ asset('js/api.js') }}'; 

        // Lógica do Axios para o CRUD
        document.addEventListener('DOMContentLoaded', function() {
            // Função para montar uma linha da tabela
            function buildUserRow(user) {
                const tr = document.createElement('tr');

                const tdName = document.createElement('td');
                tdName.textContent = user.name;

                const tdEmail = document.createElement('td');
                tdEmail.textContent = user.email;

                const tdCreated = document.createElement('td');
                tdCreated.textContent = user.created_at;

                const tdActions = document.createElement('td');
                tdActions.className = 'text-end';

                // Actions dropdown with event handlers
                tdActions.innerHTML = `
                    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        Acções
                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" onclick="handleEditUser(${user.id})">Editar</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 text-danger" onclick="handleDeleteUser(${user.id})">Eliminar</a>
                        </div>
                    </div>
                `;

                tr.appendChild(tdName);
                tr.appendChild(tdEmail);
                tr.appendChild(tdCreated);
                tr.appendChild(tdActions);

                return tr;
            }

            // Função para renderizar paginação
            function renderPagination(meta) {
                const container = document.getElementById('users-pagination');
                container.innerHTML = '';

                // Previous
                const prevLi = document.createElement('li');
                prevLi.className = 'page-item ' + (meta.current_page === 1 ? 'disabled' : '');
                const prevA = document.createElement('a');
                prevA.className = 'page-link';
                prevA.href = '#';
                prevA.textContent = 'Anterior';
                prevA.addEventListener('click', e => {
                    e.preventDefault();
                    if (meta.current_page > 1) loadUsers(meta.current_page - 1);
                });
                prevLi.appendChild(prevA);
                container.appendChild(prevLi);

                // Page buttons (use meta.last_page to generate)
                for (let p = 1; p <= meta.last_page; p++) {
                    const li = document.createElement('li');
                    li.className = 'page-item ' + (meta.current_page === p ? 'active' : '');
                    const a = document.createElement('a');
                    a.className = 'page-link';
                    a.href = '#';
                    a.textContent = p;
                    a.addEventListener('click', e => {
                        e.preventDefault();
                        loadUsers(p);
                    });
                    li.appendChild(a);
                    container.appendChild(li);
                }

                // Next
                const nextLi = document.createElement('li');
                nextLi.className = 'page-item ' + (meta.current_page === meta.last_page ? 'disabled' : '');
                const nextA = document.createElement('a');
                nextA.className = 'page-link';
                nextA.href = '#';
                nextA.textContent = 'Proximo';
                nextA.addEventListener('click', e => {
                    e.preventDefault();
                    if (meta.current_page < meta.last_page) loadUsers(meta.current_page + 1);
                });
                nextLi.appendChild(nextA);
                container.appendChild(nextLi);

                // Update info
                const info = document.getElementById('users-info');
                const from = meta.from || 0;
                const to = meta.to || 0;
                const total = meta.total || 0;
                info.textContent = `Mostrando ${from} a ${to} de ${total} dados`;
            }

            // Carregar roles para o formulário de adicionar usuário
            async function loadRolesForUserForm() {
                try {
                    const response = await api.get('/roles');
                    const roles = response.data.data || [];

                    const container = document.getElementById('user-roles-list');
                    container.innerHTML = '';

                    roles.forEach((role, index) => {
                        const id = `kt_modal_add_user_role_${role.id}`;
                        const div = document.createElement('div');
                        div.className = 'd-flex fv-row';
                        div.innerHTML = `
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input me-3" name="role_id" type="radio" value="${role.name}" id="${id}" ${index === 0 ? 'checked' : ''}>
                                <label class="form-check-label" for="${role.id}">
                                    <div class="fw-bold text-gray-800">${role.name}</div>
                                    <div class="text-gray-600">${role.guard_name || ''}</div>
                                </label>
                            </div>
                        `;

                        container.appendChild(div);

                        // separator between roles
                        const sep = document.createElement('div');
                        sep.className = 'separator separator-dashed my-5';
                        container.appendChild(sep);
                    });

                    // remove last separator if exists
                    if (container.lastElementChild && container.lastElementChild.classList.contains('separator')) {
                        container.removeChild(container.lastElementChild);
                    }

                } catch (error) {
                    console.error('Erro ao carregar roles:', error);
                    toastr.error('Não foi possível carregar as roles.');
                }
            }

            // Handler para submeter criação de usuário
            
            // Helper: limpa erros do formulário
            function clearFormErrors(form) {
                try {
                    const invalids = form.querySelectorAll('.is-invalid');
                    invalids.forEach(el => el.classList.remove('is-invalid'));

                    const feedbacks = form.querySelectorAll('[id^="error-"]');
                    feedbacks.forEach(f => {
                        f.textContent = '';
                        f.style.display = 'none';
                    });
                } catch (e) {
                    // ignore
                }
            }

            // Helper: setar erro em um campo por nome (name, email, password, ...)
            function setFieldError(form, fieldName, message) {
                const input = form.querySelector(`#${fieldName}`) || form.querySelector(`[name="${fieldName}"]`);
                const feedback = document.getElementById(`error-${fieldName}`);

                if (input) {
                    // radios: input may be a NodeList if name matches multiple; handle separately
                    if (input instanceof NodeList || Array.isArray(input)) {
                        const first = input[0];
                        if (first) first.classList.add('is-invalid');
                    } else {
                        input.classList.add('is-invalid');
                    }
                }

                if (feedback) {
                    feedback.textContent = message;
                    feedback.style.display = 'block';
                } else {
                    // fallback
                    toastr.error(message);
                }
            }

            async function handleAddUser(event) {
                event.preventDefault();

                const form = document.getElementById('kt_modal_add_user_form');
                const submitButton = form.querySelector('[data-kt-users-modal-action="submit"]') || form.querySelector('[type="submit"]');

                // clear previous errors
                clearFormErrors(form);

                // client-side validation: password confirmation
                const password = form.querySelector('[name="password"]')?.value || '';
                const passwordConfirmation = form.querySelector('[name="password_confirmation"]')?.value || '';

                if (!password) {
                    setFieldError(form, 'password', 'A password é obrigatória.');
                    return;
                }

                if (password !== passwordConfirmation) {
                    setFieldError(form, 'password', 'As passwords não coincidem.');
                    setFieldError(form, 'password_confirmation', 'As passwords não coincidem.');
                    return;
                }

                try {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    const formData = new FormData(form);

                    // Send as multipart/form-data so avatar uploads work
                    const response = await api.post('/users/registar', {
                        name: formData.get('name'),
                        email: formData.get('email'),
                        password: formData.get('password'),
                        password_confirmation: formData.get('password_confirmation'),
                        role_id: formData.get('role_id'),
                       // avatar: formData.get('avatar') instanceof File ? formData.get('avatar') : null
                    });

                    // Success
                    const modal = document.getElementById('kt_modal_add_user');
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) bsModal.hide();

                    // reload users
                    loadUsers(1);

                    form.reset();
                    clearFormErrors(form);
                    toastr.success('Utilizador criado com sucesso!');

                } catch (error) {
                    console.error('Erro ao criar utilizador:', error);

                    // If validation errors from backend, map them to form fields
                    const errs = error.response?.data?.errors;
                    if (errs && typeof errs === 'object') {
                        // mapping backend keys to our form field names
                            const keyMap = {
                                name: 'name',
                                email: 'email',
                                password: 'password',
                                password_confirmation: 'password_confirmation',
                                role_id: 'role_id',
                                role: 'role_id',
                                avatar: 'avatar'
                            };

                            Object.keys(errs).forEach(k => {
                                const mapped = keyMap[k] || k;
                                const msg = Array.isArray(errs[k]) ? errs[k].join(' ') : String(errs[k]);
                                setFieldError(form, mapped, msg);
                            });

                    } else {
                        let message = 'Não foi possível criar o utilizador.';
                        if (error.response?.data?.message) message = error.response.data.message;
                        toastr.error(message);
                    }

                } finally {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            }

            // Função para carregar usuários
            window.loadUsers = async function(pagina) {
                try {
                    const response = await api.get('/users?page=' + (pagina || 1));
                    const users = response.data.data; // Dados formatados pelo UserResource
                    const meta = response.data.meta;

                    const tableBody = document.getElementById('users-list-body');
                    tableBody.innerHTML = ''; // Limpa a tabela

                    users.forEach(user => {
                        const row = buildUserRow(user);
                        tableBody.appendChild(row);
                    });

                    renderPagination(meta);
                    // Re-inicializar componentes KT caso necessário
                    if (typeof initKTComponents === 'function') initKTComponents();

                } catch (error) {
                    console.error('Erro ao carregar utilizadores:', error);
                    alert('Não foi possível carregar a lista de utilizadores.');
                }
            }

            loadUsers(1); // Carregar a primeira página ao iniciar

            // setup modal behaviors: load roles when add-user modal opens
            const addUserModal = document.getElementById('kt_modal_add_user');
            if (addUserModal) {
                // Handler para fechar o modal com os botões
                const closeButtons = document.querySelectorAll('[data-kt-users-modal-action="close"], [data-kt-users-modal-action="cancel"]');
                closeButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const modal = bootstrap.Modal.getInstance(addUserModal);
                        if (modal) modal.hide();
                    });
                });

                addUserModal.addEventListener('shown.bs.modal', () => loadRolesForUserForm());

                // attach submit handler
                const addUserForm = document.getElementById('kt_modal_add_user_form');
                if (addUserForm) {
                    addUserForm.addEventListener('submit', handleAddUser);

                    // clear field errors when user types
                    addUserForm.querySelectorAll('input, select, textarea').forEach(el => {
                        el.addEventListener('input', () => {
                            // if element is a role radio it has name 'role_id'
                            const key = (el.name === 'role_id') ? 'role_id' : (el.id || el.name);
                            if (!key) return;
                            const fb = document.getElementById('error-' + key);
                            if (fb) {
                                fb.textContent = '';
                                fb.style.display = 'none';
                            }
                            el.classList.remove('is-invalid');
                        });
                    });

                    // clear role errors when user selects a role (radios are dynamic)
                    const rolesContainer = document.getElementById('user-roles-list');
                    if (rolesContainer) {
                        rolesContainer.addEventListener('change', () => {
                            const fb = document.getElementById('error-role_id');
                            if (fb) {
                                fb.textContent = '';
                                fb.style.display = 'none';
                            }
                            const radios = addUserForm.querySelectorAll('[name="role_id"]');
                            radios.forEach(r => r.classList.remove('is-invalid'));
                        });
                    }
                }

                // clear errors & reset form when modal hides
                addUserModal.addEventListener('hidden.bs.modal', () => {
                    const f = document.getElementById('kt_modal_add_user_form');
                    if (f) {
                        f.reset();
                        clearFormErrors(f);
                    }
                });
            }

            // Funções para editar usuário
            async function handleEditUser(userId) {
                try {
                    // Buscar dados do usuário
                    const response = await api.get(`/users/${userId}`);
                    const user = response.data.data;

                    // Preencher o formulário
                    const form = document.getElementById('kt_modal_edit_user_form');
                    form.querySelector('#edit_user_id').value = user.id;
                    form.querySelector('#edit_name').value = user.name;
                    form.querySelector('#edit_email').value = user.email;
                    
                    // Carregar roles
                    await loadRolesForEditUserForm(user.roles[0]?.name);

                    // Abrir o modal
                    const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_user'));
                    modal.show();
                } catch (error) {
                    console.error('Erro ao carregar dados do usuário:', error);
                    toastr.error('Não foi possível carregar os dados do usuário.');
                }
            }

            // Carregar roles para o formulário de edição
            window.loadRolesForEditUserForm = async function(selectedRole) {
                try {
                    const response = await api.get('/roles');
                    const roles = response.data.data || [];

                    const container = document.getElementById('edit-user-roles-list');
                    container.innerHTML = '';

                    roles.forEach((role) => {
                        const id = `kt_modal_edit_user_role_${role.id}`;
                        const div = document.createElement('div');
                        div.className = 'd-flex fv-row';
                        div.innerHTML = `
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input me-3" name="role_id" type="radio" value="${role.name}" 
                                    id="${id}" ${role.name === selectedRole ? 'checked' : ''}>
                                <label class="form-check-label" for="${role.id}">
                                    <div class="fw-bold text-gray-800">${role.name}</div>
                                    <div class="text-gray-600">${role.guard_name || ''}</div>
                                </label>
                            </div>
                        `;

                        container.appendChild(div);

                        const sep = document.createElement('div');
                        sep.className = 'separator separator-dashed my-5';
                        container.appendChild(sep);
                    });

                    if (container.lastElementChild?.classList.contains('separator')) {
                        container.removeChild(container.lastElementChild);
                    }
                } catch (error) {
                    console.error('Erro ao carregar roles:', error);
                    toastr.error('Não foi possível carregar as roles.');
                }
            }

            // Handler para submeter edição de usuário
            async function handleEditUserSubmit(event) {
                event.preventDefault();

                const form = document.getElementById('kt_modal_edit_user_form');
                const submitButton = form.querySelector('[data-kt-users-modal-action="submit"]');
                const userId = form.querySelector('#edit_user_id').value;

                clearFormErrors(form);

                const password = form.querySelector('#edit_password').value;
                const passwordConfirmation = form.querySelector('#edit_password_confirmation').value;

                if (password && password !== passwordConfirmation) {
                    setFieldError(form, 'edit_password', 'As passwords não coincidem.');
                    setFieldError(form, 'edit_password_confirmation', 'As passwords não coincidem.');
                    return;
                }

                try {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    const formData = new FormData(form);
                    const data = {
                        name: formData.get('name'),
                        email: formData.get('email'),
                        role_id: formData.get('role_id')
                    };

                    // Só incluir password se foi preenchida
                    if (password) {
                        data.password = password;
                        data.password_confirmation = passwordConfirmation;
                    }

                    await api.put(`/users/${userId}`, data);

                    const modal = bootstrap.Modal.getInstance(document.getElementById('kt_modal_edit_user'));
                    modal.hide();

                    loadUsers(1);
                    toastr.success('Utilizador atualizado com sucesso!');

                } catch (error) {
                    console.error('Erro ao atualizar utilizador:', error);

                    const errs = error.response?.data?.errors;
                    if (errs && typeof errs === 'object') {
                        const keyMap = {
                            name: 'edit_name',
                            email: 'edit_email',
                            password: 'edit_password',
                            password_confirmation: 'edit_password_confirmation',
                            role_id: 'edit_role_id'
                        };

                        Object.keys(errs).forEach(k => {
                            const mapped = keyMap[k] || k;
                            const msg = Array.isArray(errs[k]) ? errs[k].join(' ') : String(errs[k]);
                            setFieldError(form, mapped, msg);
                        });
                    } else {
                        toastr.error(error.response?.data?.message || 'Não foi possível atualizar o utilizador.');
                    }
                } finally {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            }

            // Função para deletar usuário
            async function handleDeleteUser(userId) {
                // Abrir modal de confirmação
                const modal = new bootstrap.Modal(document.getElementById('kt_modal_delete_user'));
                modal.show();

                // Configurar botão de delete
                const deleteButton = document.querySelector('[data-kt-users-modal-action="delete"]');
                deleteButton.onclick = async () => {
                    try {
                        deleteButton.setAttribute('data-kt-indicator', 'on');
                        deleteButton.disabled = true;

                        await api.delete(`/users/${userId}`);
                        
                        modal.hide();
                        loadUsers(1);
                        toastr.success('Utilizador eliminado com sucesso!');

                    } catch (error) {
                        console.error('Erro ao eliminar utilizador:', error);
                        toastr.error(error.response?.data?.message || 'Não foi possível eliminar o utilizador.');
                    } finally {
                        deleteButton.removeAttribute('data-kt-indicator');
                        deleteButton.disabled = false;
                    }
                };
            }

            // Setup do modal de edição
            const editUserModal = document.getElementById('kt_modal_edit_user');
            if (editUserModal) {
                // Handlers para fechar o modal
                const closeButtons = editUserModal.querySelectorAll('[data-kt-users-modal-action="close"], [data-kt-users-modal-action="cancel"]');
                closeButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const modal = bootstrap.Modal.getInstance(editUserModal);
                        if (modal) modal.hide();
                    });
                });

                // Handler de submit
                const editUserForm = document.getElementById('kt_modal_edit_user_form');
                if (editUserForm) {
                    editUserForm.addEventListener('submit', handleEditUserSubmit);

                    // Limpar erros ao digitar
                    editUserForm.querySelectorAll('input, select, textarea').forEach(el => {
                        el.addEventListener('input', () => {
                            const key = (el.name === 'role_id') ? 'edit_role_id' : (el.id || 'edit_' + el.name);
                            const fb = document.getElementById('error-' + key);
                            if (fb) {
                                fb.textContent = '';
                                fb.style.display = 'none';
                            }
                            el.classList.remove('is-invalid');
                        });
                    });
                }

                // Limpar form ao fechar
                editUserModal.addEventListener('hidden.bs.modal', () => {
                    const form = document.getElementById('kt_modal_edit_user_form');
                    if (form) {
                        form.reset();
                        clearFormErrors(form);
                    }
                });
            }
        });
    </script>
@endpush
