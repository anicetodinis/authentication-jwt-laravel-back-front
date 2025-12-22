// Classe para gerenciar autenticação JWT
class AuthManager {
    constructor() {
        this.tokenKey = 'jwt_token';
        this.cookieName = 'jwt_token';
        this.init();
    }

    /**
     * Inicializa o gerenciador de autenticação
     */
    init() {
        // Sincronizar token do localStorage para cookie ao carregar a página
        this.syncTokenToCookie();
        
        // Interceptar eventos de armazenamento (mudanças em abas diferentes)
        window.addEventListener('storage', (e) => {
            if (e.key === this.tokenKey) {
                this.syncTokenToCookie();
            }
        });
    }

    /**
     * Armazena o token no localStorage e no cookie
     * @param {string} token - JWT token
     */
    saveToken(token) {
        localStorage.setItem(this.tokenKey, token);
        this.setCookie(this.cookieName, token, 7); // 7 dias
    }

    /**
     * Obtém o token do localStorage
     * @returns {string|null}
     */
    getToken() {
        return localStorage.getItem(this.tokenKey);
    }

    deleteCookie2(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    }

    /**
     * Remove o token do localStorage e do cookie
     */
    clearToken() {
        localStorage.removeItem(this.tokenKey);
        this.deleteCookie(this.cookieName);
    }

    /**
     * Sincroniza o token do localStorage para o cookie
     */
    syncTokenToCookie() {
        const token = this.getToken();
        if (token) {
            this.setCookie(this.cookieName, token, 7);
        }
    }

    /**
     * Define um cookie
     * @param {string} name - Nome do cookie
     * @param {string} value - Valor do cookie
     * @param {number} days - Dias de expiração
     */
    setCookie(name, value, days = 7) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;SameSite=Strict`;
    }

    /**
     * Obtém um cookie pelo nome
     * @param {string} name - Nome do cookie
     * @returns {string|null}
     */
    getCookie(name) {
        const nameEQ = name + "=";
        const cookies = document.cookie.split(';');
        for (let cookie of cookies) {
            cookie = cookie.trim();
            if (cookie.indexOf(nameEQ) === 0) {
                return cookie.substring(nameEQ.length);
            }
        }
        return null;
    }

    /**
     * Deleta um cookie
     * @param {string} name - Nome do cookie
     */
    deleteCookie(name) {
        document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT; SameSite=Strict;';
        // se usaste Domain/ Secure/ SameSite diferentes ao criar a cookie,
        // podes precisar de repetir com essas opções (domain, ; Secure)
    }

    /**
     * Verifica se está autenticado
     * @returns {boolean}
     */
    isAuthenticated() {
        return !!this.getToken();
    }

    /**
     * Faz logout: remove token e redireciona para login
     */
    async logout() {
        try {
            const token = this.getToken();
            
            if (token) {
                // Faz a chamada para o endpoint de logout
                await api.post('/logout');
                await axios.post('/session/logout');
            }

            // Limpa os dados
            this.clearToken();
            localStorage.removeItem('user_roles');
            localStorage.removeItem('user_permissions');

            // Redireciona para a página de login
            window.location.href = '/login';
        } catch (error) {
            console.error('Erro ao fazer logout:', error);
            
            // Mesmo se houver erro, limpa os dados e redireciona
            this.clearToken();
            localStorage.removeItem('user_roles');
            localStorage.removeItem('user_permissions');
            window.location.href = '/login';
        }
    }

    teste() {
        return 'testeeeeee';
    }
}

// Criar instância global
window.authManager = new AuthManager();

// Função para fazer logout (mantém compatibilidade com código anterior)
async function logout() {
    Swal.fire({
        title: "Tem certeza que deseja terminar a sessão?",
        icon: "question",
        showDenyButton: true,
        confirmButtonText: "Continuar",
        denyButtonText: `Sair`
    }).then((result) => {
        if (result.isConfirmed) {
  
        } else if (result.isDenied) {
            Swal.fire("Logout em processo", "", "info");
            return window.authManager.logout();
        }
    });
    
    
}

// Expõe a função logout globalmente
window.logout = logout;