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

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $permisos = [

            'maestros.view', 'maestros.create', 'maestros.update', 'maestros.delete',
            

            'banners.view', 'banners.create', 'banners.update', 'banners.delete',
            

            'pedidos.view', 'pedidos.update_status',
            

            'clientes.view', 'clientes.toggle', 'clientes.update',
            

            'users.manage',
        ];


        foreach ($permisos as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }


        $rolAdmin = Role::firstOrCreate(['name' => 'administrador']);
        $rolAdmin->syncPermissions(Permission::all());


        $rolGestor = Role::firstOrCreate(['name' => 'gestor-tienda']);
        $rolGestor->syncPermissions([
            'maestros.view', 
            'maestros.create', 
            'maestros.update',
            'banners.view', 
            'banners.create', 
            'banners.update', 
            'banners.delete'
        ]);


        $rolLogistica = Role::firstOrCreate(['name' => 'operador-logistico']);
        $rolLogistica->syncPermissions(['pedidos.view', 'pedidos.update_status']);


        $rolAtencion = Role::firstOrCreate(['name' => 'atencion-cliente']);
        $rolAtencion->syncPermissions(['clientes.view', 'clientes.toggle', 'clientes.update']);


        $adminUser = User::updateOrCreate(
            ['email' => 'admin@pharmavictoria.com'], 
            [
                'name' => 'Vicente',
                'password' => Hash::make('12345678'), 
                'email_verified_at' => now(),
            ]
        );

        $adminUser->assignRole($rolAdmin);

        $this->command->info('✅ Matriz de Seguridad actualizada: Permisos de Banners añadidos.');
        $this->command->info('✅ Usuario Admin listo: admin@pharmavictoria.com / 12345678');
    }
}