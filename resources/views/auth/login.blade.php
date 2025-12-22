<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Open HTML Pro</title>
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/login.js'])
</head>

<body class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <div class="d-flex flex-center w-lg-100 p-10">
            <div class="card p-10 w-100 w-lg-500px">
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="/dashboard"
                    action="#">
                    <div class="text-center mb-11">
                        <h1 class="text-dark fw-bolder mb-3">Login</h1>
                    </div>

                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Email" name="email" id="email" autocomplete="off"
                            class="form-control bg-transparent" required />
                    </div>
                    <div class="fv-row mb-3">
                        <input type="password" placeholder="Password" name="password" id="password" autocomplete="off"
                            class="form-control bg-transparent" required />
                    </div>

                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <span class="indicator-label">Entrar</span>
                            <span class="indicator-progress">Por favor, aguarde...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script>
        // Esperar que o Vite carregue os módulos (authManager estará disponível)
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('kt_sign_in_form').addEventListener('submit', async (e) => {
                e.preventDefault();

                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                if(!email || !password){
                    toastr.error('Por favor, preenha todos os campos.');
                    return;
                }

                const submitButton = document.getElementById('kt_sign_in_submit');
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;

                try {
                    const response = await login.post('/login', {
                        email,
                        password
                    });

                    // Sucesso: Armazenar o token usando AuthManager
                    const token = response.data.access_token;
                    if (window.authManager) {
                        window.authManager.saveToken(token);
                    } else {
                        localStorage.setItem('jwt_token', token);
                    }

                    // Criar sessão web a partir do token JWT
                    try {
                        await axios.post('/session', { token });
                    } catch (err) {
                        console.warn('Erro ao criar sessão web:', err);
                    }

                    // Redirecionar para dashboard
                    window.location.href = '/dashboard';
            
                } catch (error) {
                    console.log('Login Failed:', error);
                    toastr.error('Credenciais inválidas.');

                } finally {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            });
        });
    </script>
</body>

</html>
