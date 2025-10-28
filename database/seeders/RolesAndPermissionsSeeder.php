<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpar cache de roles e permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        try {
            // Primeiro, criar o usuário admin se ainda não existir
            $admin = User::firstOrCreate(
                ['email' => 'admin@admin.com'],
                [
                    'name' => 'Admin',
                    'password' => bcrypt('password')
                ]
            );

            // Criar role admin primeiro
            $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);

            // Criar permissões uma por uma
            $permissions = [
                'view users',
                'create users',
                'edit users',
                'delete users',
                'manage roles',
                'manage permissions'
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
            }

            // Atribuir todas as permissões à role admin após criá-las
            $adminRole->givePermissionTo($permissions);

            // Atribuir role admin ao usuário admin
            $admin->assignRole($adminRole);

        } catch (\Exception $e) {
            // Log do erro para debug
            Log::error('Erro ao criar permissões/roles: ' . $e->getMessage());
            throw $e;
        }
    }
}
