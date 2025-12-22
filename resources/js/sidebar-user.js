// Função para obter as iniciais do nome
function getInitials(name = '') {
    if (!name) return '...';
    return name
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
}

// Função para atualizar os elementos da UI com os dados do usuário no sidebar
function updateSidebarUserUI(userData) {
    if (!userData) {
        console.error('Dados do usuário não encontrados');
        return;
    }

    const initials = getInitials(userData.name);
    const mainRole = userData.roles?.[0]?.name || 'Usuário';
    
    // Atualizar o menu do sidebar
    const sidebarName = document.getElementById('sidebar-user-name');
    const sidebarEmail = document.getElementById('sidebar-user-email');
    const sidebarInitials = document.getElementById('sidebar-user-initials');

    if (sidebarName) sidebarName.textContent = userData.name || 'Usuário';
    if (sidebarEmail) sidebarEmail.textContent = userData.email || '';
    if (sidebarInitials) sidebarInitials.textContent = initials;
    
    // Atualizar o menu dropdown do sidebar
    const menuName = document.getElementById('sidebar-menu-user-name');
    const menuEmail = document.getElementById('sidebar-menu-user-email');
    const menuInitials = document.getElementById('sidebar-menu-user-initials');

    if (menuName) menuName.textContent = userData.name || 'Usuário';
    if (menuEmail) menuEmail.textContent = mainRole;
    if (menuInitials) menuInitials.textContent = initials;

    // Armazenar as roles e permissões no localStorage para uso futuro
    try {
        localStorage.setItem('user_roles', JSON.stringify(userData.roles || []));
        localStorage.setItem('user_permissions', JSON.stringify(userData.permissions || []));
    } catch (e) {
        console.error('Erro ao armazenar dados do usuário no localStorage:', e);
    }
}

// Carregar os dados do usuário quando o documento estiver pronto
 document.addEventListener('DOMContentLoaded', async function() {
    /* const initials = getInitials(@js($user->name ?? ''));

     const sidebarInitials = document.getElementById('sidebar-user-initials');
    if (sidebarInitials) sidebarInitials.textContent = initials; */
    // Verifica se existe um token JWT no localStorage
    /*const token = localStorage.getItem('jwt_token');
    
    if (token1) {
        try {
            const response = await api.get('/me');
            // Verificar se temos dados válidos na resposta
            // A resposta está aninhada em response.data.data
            if (response?.data?.data) {
                updateSidebarUserUI(response.data.data);
            } else {
                console.error('Resposta da API não contém dados do usuário');
            }
        } catch (error) {
            console.error('Erro ao carregar dados do usuário:', error);
            // Se o token estiver inválido, remove-o do localStorage
            if (error.response?.status === 401) {
                localStorage.removeItem('jwt_token');
                localStorage.removeItem('user_roles');
                localStorage.removeItem('user_permissions');
            }
        }
    } else {
        console.log('Nenhuma sessão de usuário encontrada');
    }*/
}); 