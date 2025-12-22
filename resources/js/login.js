// resources/js/api.js

import axios from 'axios';

// 1. Configurar URL base e Headers padrões
const login = axios.create({
    baseURL: '/api', // Todas as requisições irão para http://seu-laravel.test/api
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    }
});



export default login;