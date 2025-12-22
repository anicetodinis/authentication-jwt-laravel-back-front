//import './bootstrap';
import axios from './api';
import login from './login';
import './sidebar-user';
import './auth';

// Exportar para uso nas views Blade
window.api = axios;
window.login = login;