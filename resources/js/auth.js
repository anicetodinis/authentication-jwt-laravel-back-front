// Função para fazer logout
async function logout() {
    try {
        const token = localStorage.getItem('jwt_token');
        
        if (token) {
            // Configura o token no header da requisição
            api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            
            // Faz a chamada para o endpoint de logout
            await api.post('/logout');
        }

        // Limpa os dados do usuário do localStorage
        localStorage.removeItem('jwt_token');
        localStorage.removeItem('user_roles');
        localStorage.removeItem('user_permissions');

        // Redireciona para a página de login
        window.location.href = '/login';
    } catch (error) {
        console.error('Erro ao fazer logout:', error);
        
        // Mesmo se houver erro, limpa os dados e redireciona
        localStorage.removeItem('jwt_token');
        localStorage.removeItem('user_roles');
        localStorage.removeItem('user_permissions');
        window.location.href = '/login';
    }
}

// Expõe a função logout globalmente
window.logout = logout;