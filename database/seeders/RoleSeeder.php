<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. LIMPIAR MEMORIA DE SPATIE
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. CREAR TODOS LOS PERMISOS DEL SISTEMA
        $permisos = [

            'maestros.view', 'maestros.create', 'maestros.update', 'maestros.delete',

            'pedidos.view', 'pedidos.update_status',

            'clientes.view', 'clientes.toggle', 'clientes.update',

            'users.manage',
        ];

        foreach ($permisos as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // --- 3. CREAR ROLES Y ASIGNAR PODERES ---

        $rolAdmin = Role::firstOrCreate(['name' => 'administrador']);
        $rolAdmin->syncPermissions(Permission::all());


        $rolGestor = Role::firstOrCreate(['name' => 'gestor-tienda']);
        $rolGestor->syncPermissions(['maestros.view', 'maestros.create', 'maestros.update']);


        $rolLogistica = Role::firstOrCreate(['name' => 'operador-logistico']);
        $rolLogistica->syncPermissions(['pedidos.view', 'pedidos.update_status']);


        $rolAtencion = Role::firstOrCreate(['name' => 'atencion-cliente']);
        $rolAtencion->syncPermissions(['clientes.view', 'clientes.toggle', 'clientes.update']);


        $adminUser = User::firstOrCreate(
            ['email' => 'admin@pharmavictoria.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        if (!$adminUser->hasRole('administrador')) {
            $adminUser->assignRole($rolAdmin);
        }

        $this->command->info('✅ Matriz de 4 Roles de PharmaVictoria configurada con éxito.');
    }
}