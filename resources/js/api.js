// resources/js/api.js

import axios from 'axios';

// 1. Configurar URL base e Headers padrões
const api = axios.create({
    baseURL: '/api', // Todas as requisições irão para http://seu-laravel.test/api
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    }
});

// 2. Interceptor de Request: Anexar o Token JWT
api.interceptors.request.use(config => {
    const token = localStorage.getItem('jwt_token');
    if (token) {
        // Envia o token no formato Bearer para as rotas protegidas
        config.headers.Authorization = `Bearer ${token}`; 
    }
    return config;
}, error => {
    return Promise.reject(error);
});

// 3. Interceptor de Response: Tratar Erros 401 (Não Autorizado/Expirado)
api.interceptors.response.use(response => response, error => {
    if (error.response && error.response.status === 401) {
        // Token inválido ou expirado. 
        localStorage.removeItem('jwt_token');
        // Redireciona para o login
        window.location.href = '/login'; 
        alert('Sessão expirada. Por favor, faça login novamente.');
    }
    return Promise.reject(error);
});

export default api;