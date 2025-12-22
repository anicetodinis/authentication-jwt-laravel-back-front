import axios from 'axios';
import './auth.js'; // Importar o gerenciador de autenticação

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configurar axios para enviar o token JWT em todas as requisições
axios.interceptors.request.use(config => {
    const token = localStorage.getItem('jwt_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

// Interceptar erros 401 (Não autorizado)
axios.interceptors.response.use(response => response, error => {
    if (error.response && error.response.status === 401) {
        // Token inválido ou expirado
        localStorage.removeItem('jwt_token');
        window.location.href = '/login';
    }
    return Promise.reject(error);
});
