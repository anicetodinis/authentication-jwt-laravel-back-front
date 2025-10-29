    <!--begin::Modal - Edit user-->
    <div class="modal fade" id="kt_modal_edit_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-950px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_edit_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Editar Utilizador</h2>
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
                    <form id="kt_modal_edit_user_form" class="form" action="#">
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_user_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nome Completo</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input id="edit_name" type="text" name="name"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nome Completo">
                                <div class="invalid-feedback" id="error-edit-name"></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Email</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input id="edit_email" type="email" name="email"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com">
                                <div class="invalid-feedback" id="error-edit-email"></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Password</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input id="edit_password" type="password" name="password"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Deixe em branco para manter a atual">
                                <div class="invalid-feedback" id="error-edit-password"></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Confirmar Password</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input id="edit_password_confirmation" type="password" name="password_confirmation"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Confirmar Password">
                                <div class="invalid-feedback" id="error-edit-password_confirmation"></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-5">Role</label>
                                <!--end::Label-->

                                <!--begin::Roles - will be populated dynamically-->
                                <div id="edit-user-roles-list" class="d-flex flex-column"></div>
                                <div class="invalid-feedback d-block" id="error-edit-role_id" style="display:none;"></div>
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
                                    Guardar Alterações
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
    <!--end::Modal - Edit user-->

    <!--begin::Modal - Delete user-->
    <div class="modal fade" id="kt_modal_delete_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-end border-0 pb-0">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><i class="path1"></i><i class="path2"></i></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <!--begin::Content-->
                    <div class="text-center mb-13">
                        <h1 class="mb-3">Eliminar Utilizador</h1>
                        <div class="text-muted fw-semibold fs-5">
                            Tem certeza que deseja eliminar este utilizador?<br>Esta ação não pode ser desfeita.
                        </div>
                    </div>
                    <!--end::Content-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="button" class="btn btn-danger" data-kt-users-modal-action="delete">
                            <span class="indicator-label">
                                Sim, Eliminar
                            </span>
                            <span class="indicator-progress">
                                Aguarde... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Delete user-->