<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebEstadoPedido;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call(RoleSeeder::class);


        $estados = ['Pendiente', 'Pagado', 'Enviado', 'Entregado', 'Cancelado'];
        foreach ($estados as $e) { WebEstadoPedido::firstOrCreate(['nombre' => $e]); }


        $this->call(CentralMockSeeder::class);


        $this->call(WebProductoSeeder::class);
        

        $this->call(WebClienteSeeder::class);
    }
}