<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use App\Models\WebCliente;
use App\Models\WebDireccionCliente;
use App\Models\WebPedido;
use App\Models\WebDetallePedido;
use App\Models\WebSede;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class WebClienteSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::role('cliente')->delete(); 
        
        WebCliente::truncate();
        WebDireccionCliente::truncate();
        WebPedido::truncate();
        WebDetallePedido::truncate();
        WebSede::truncate();
        Schema::enableForeignKeyConstraints();


        $sedesCentral = DB::table('central_sedes_simulacion')->get();
        foreach ($sedesCentral as $sc) {
            WebSede::create([
                'id' => $sc->id, 
                'codigo' => $sc->codigo,
                'nombre' => $sc->nombre,
                'direccion' => 'Dirección de Sede ' . $sc->nombre,
                'activo' => true
            ]);
        }


        $clientes = [
            ['nom' => 'Juan', 'ape' => 'Pérez Soto', 'dni' => '11111111', 'mail' => 'juan@test.com'],
            ['nom' => 'Maria', 'ape' => 'Lopez Jara', 'dni' => '22222222', 'mail' => 'maria@test.com'],
        ];

        foreach ($clientes as $index => $c) {
            DB::transaction(function () use ($c, $index) {

                $user = User::create([
                    'name' => $c['nom'] . ' ' . $c['ape'],
                    'email' => $c['mail'],
                    'password' => Hash::make('password'),
                ]);


                $user->assignRole('cliente');


                $cliente = WebCliente::create([
                    'user_id' => $user->id, 
                    'nombres' => $c['nom'],
                    'apellidos' => $c['ape'],
                    'dni' => $c['dni'],
                    'telefono' => '987654321',
                    'activo' => true
                ]);


                WebDireccionCliente::create([
                    'cliente_id' => $cliente->id,
                    'alias' => 'Casa',
                    'direccion_completa' => 'Calle Las Farmacias 123',
                    'distrito' => 'Lima',
                    'ciudad' => 'Lima',
                    'es_principal' => true
                ]);


                $total = 100.00;
                $sub = round($total / 1.18, 2);
                
                $pedido = WebPedido::create([
                    'cliente_id' => $cliente->id,
                    'estado_id' => ($index === 0) ? 3 : 1, 
                    'sede_recojo_id' => ($index === 0) ? 1 : null, 
                    'subtotal' => $sub,
                    'impuesto' => round($total - $sub, 2),
                    'total' => $total,
                ]);


                WebDetallePedido::create([
                    'pedido_id' => $pedido->id, 
                    'sku_producto' => 'ANA-001',
                    'cantidad' => 1,
                    'precio_unitario' => 100.00,
                    'subtotal' => 100.00
                ]);
            });
        }
    }
}