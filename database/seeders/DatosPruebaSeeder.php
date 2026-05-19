<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Cliente;
use App\Models\Cementerio;
use App\Models\Espacio;
use App\Models\TipoInhumacion;
use App\Models\TipoMantenimiento;
use App\Models\Mantenimiento;

class DatosPruebaSeeder extends Seeder
{
    public function run(): void
    {
        // ────────────────────────────────────────────────
        // 1. PERMISOS
        // ────────────────────────────────────────────────
        $permisos = [
            'usuarios.ver', 'usuarios.crear', 'usuarios.editar', 'usuarios.eliminar',
            'empleados.ver', 'empleados.crear', 'empleados.editar', 'empleados.eliminar',
            'roles.ver', 'roles.crear', 'roles.editar', 'roles.eliminar',
            'cementerios.ver', 'cementerios.crear', 'cementerios.editar', 'cementerios.eliminar',
            'espacios.ver', 'espacios.crear', 'espacios.editar', 'espacios.eliminar',
            'inhumaciones.ver', 'inhumaciones.crear', 'inhumaciones.editar', 'inhumaciones.eliminar',
            'mantenimientos.ver', 'mantenimientos.crear', 'mantenimientos.editar', 'mantenimientos.eliminar',
            'clientes.ver', 'clientes.crear', 'clientes.editar', 'clientes.eliminar',
            'contratos.ver', 'contratos.crear', 'contratos.editar', 'contratos.eliminar',
            'ventas.ver', 'ventas.crear', 'ventas.editar', 'ventas.eliminar',
            'pagos.ver', 'pagos.crear', 'pagos.editar', 'pagos.eliminar',
            'reportes.ver',
            'bitacora.ver',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        // ────────────────────────────────────────────────
        // 2. ROLES
        // ────────────────────────────────────────────────
        $admin = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        $cajero = Role::firstOrCreate(['name' => 'Cajero', 'guard_name' => 'web']);
        $cajero->syncPermissions([
            'clientes.ver', 'clientes.crear', 'clientes.editar',
            'contratos.ver', 'contratos.crear',
            'ventas.ver', 'ventas.crear',
            'pagos.ver', 'pagos.crear',
            'espacios.ver',
            'inhumaciones.ver',
            'reportes.ver',
        ]);

        $operario = Role::firstOrCreate(['name' => 'Operario', 'guard_name' => 'web']);
        $operario->syncPermissions([
            'espacios.ver', 'espacios.editar',
            'mantenimientos.ver', 'mantenimientos.crear', 'mantenimientos.editar',
            'inhumaciones.ver',
            'cementerios.ver',
        ]);

        // ────────────────────────────────────────────────
        // 3. EMPLEADOS
        // ────────────────────────────────────────────────
        $empAdmin = Empleado::firstOrCreate(['ci' => '1234567'], [
            'nombre'    => 'Juan',
            'paterno'   => 'Pérez',
            'materno'   => 'García',
            'direccion' => 'Av. Monseñor Rivero #123',
            'telefono'  => '77712345',
            'cargo'     => 'Administrador',
            'estado'    => 'activo',
        ]);

        $empCajero = Empleado::firstOrCreate(['ci' => '2345678'], [
            'nombre'    => 'María',
            'paterno'   => 'López',
            'materno'   => 'Suárez',
            'direccion' => 'Calle Libertad #456',
            'telefono'  => '77723456',
            'cargo'     => 'Cajera',
            'estado'    => 'activo',
        ]);

        $empOperario = Empleado::firstOrCreate(['ci' => '3456789'], [
            'nombre'    => 'Carlos',
            'paterno'   => 'Ríos',
            'materno'   => 'Mamani',
            'direccion' => 'Barrio Las Palmas #789',
            'telefono'  => '77734567',
            'cargo'     => 'Operario',
            'estado'    => 'activo',
        ]);

        // ────────────────────────────────────────────────
        // 4. USUARIOS
        // ────────────────────────────────────────────────
        $userAdmin = User::firstOrCreate(['username' => 'admin'], [
            'empleado_id' => $empAdmin->id,
            'email'       => 'admin@sepulturero.com',
            'password'    => Hash::make('admin123'),
            'estado'      => 'activo',
        ]);
        $userAdmin->assignRole($admin);

        $userCajero = User::firstOrCreate(['username' => 'cajero'], [
            'empleado_id' => $empCajero->id,
            'email'       => 'cajero@sepulturero.com',
            'password'    => Hash::make('cajero123'),
            'estado'      => 'activo',
        ]);
        $userCajero->assignRole($cajero);

        $userOperario = User::firstOrCreate(['username' => 'operario'], [
            'empleado_id' => $empOperario->id,
            'email'       => 'operario@sepulturero.com',
            'password'    => Hash::make('operario123'),
            'estado'      => 'activo',
        ]);
        $userOperario->assignRole($operario);

        // ────────────────────────────────────────────────
        // 5. CLIENTES
        // ────────────────────────────────────────────────
        $clientes = [
            ['ci' => '4567890', 'nombre' => 'Roberto', 'paterno' => 'Flores',    'materno' => 'Vaca',   'telefono' => '77745678', 'correo' => 'roberto@mail.com'],
            ['ci' => '5678901', 'nombre' => 'Ana',     'paterno' => 'Gutierrez', 'materno' => 'Torrez', 'telefono' => '77756789', 'correo' => 'ana@mail.com'],
            ['ci' => '6789012', 'nombre' => 'Luis',    'paterno' => 'Vargas',    'materno' => 'Cortez', 'telefono' => '77767890', 'correo' => 'luis@mail.com'],
        ];

        foreach ($clientes as $c) {
            Cliente::firstOrCreate(['ci' => $c['ci']], array_merge($c, [
                'direccion' => 'Santa Cruz de la Sierra',
                'estado'    => 'activo',
            ]));
        }

        // ────────────────────────────────────────────────
        // 6. CEMENTERIOS
        // ────────────────────────────────────────────────
        $cementerio = Cementerio::firstOrCreate(['nombre' => 'Cementerio Municipal San Juan'], [
            'localizacion'    => 'Av. Cañoto s/n, Santa Cruz de la Sierra',
            'estado'          => 'activo',
            'espacio_total'   => 500,
            'tipo_cementerio' => 'Municipal',
        ]);

        $cementerio2 = Cementerio::firstOrCreate(['nombre' => 'Jardines del Recuerdo'], [
            'localizacion'    => 'Carretera al Norte Km 5, Santa Cruz de la Sierra',
            'estado'          => 'activo',
            'espacio_total'   => 300,
            'tipo_cementerio' => 'Privado',
        ]);

        // ────────────────────────────────────────────────
        // 7. TIPOS DE INHUMACIÓN
        // ────────────────────────────────────────────────
        $tipoNicho = TipoInhumacion::firstOrCreate(['nombre' => 'Nicho'], [
            'precio'        => 3500.00,
            'precio_base'   => 3000.00,
            'capacidad_max' => 1,
            'estado'        => 'activo',
            'area_base'     => 2.50,
        ]);

        $tipoBoveda = TipoInhumacion::firstOrCreate(['nombre' => 'Bóveda'], [
            'precio'        => 8000.00,
            'precio_base'   => 7000.00,
            'capacidad_max' => 4,
            'estado'        => 'activo',
            'area_base'     => 9.00,
        ]);

        $tipoTerreno = TipoInhumacion::firstOrCreate(['nombre' => 'Terreno'], [
            'precio'        => 5000.00,
            'precio_base'   => 4500.00,
            'capacidad_max' => 2,
            'estado'        => 'activo',
            'area_base'     => 6.00,
        ]);

        // ────────────────────────────────────────────────
        // 8. TIPOS DE MANTENIMIENTO
        // ────────────────────────────────────────────────
        $tipoLimpieza = TipoMantenimiento::firstOrCreate(['nombre' => 'Limpieza'], [
            'descripcion' => 'Limpieza general del espacio funerario',
            'precio_base' => 50.00,
        ]);

        $tipoReparacion = TipoMantenimiento::firstOrCreate(['nombre' => 'Reparación'], [
            'descripcion' => 'Reparación de daños estructurales (grietas, humedad)',
            'precio_base' => 200.00,
        ]);

        $tipoPintura = TipoMantenimiento::firstOrCreate(['nombre' => 'Pintura'], [
            'descripcion' => 'Pintura y mantenimiento estético',
            'precio_base' => 150.00,
        ]);

        $tipoJardineria = TipoMantenimiento::firstOrCreate(['nombre' => 'Jardinería'], [
            'descripcion' => 'Mantenimiento de áreas verdes alrededor del espacio',
            'precio_base' => 80.00,
        ]);

        $tipoRenovacion = TipoMantenimiento::firstOrCreate(['nombre' => 'Renovación'], [
            'descripcion' => 'Renovación completa del espacio',
            'precio_base' => 500.00,
        ]);

        TipoMantenimiento::firstOrCreate(['nombre' => 'Otro'], [
            'descripcion' => 'Otros tipos de mantenimiento',
            'precio_base' => 100.00,
        ]);

        // ────────────────────────────────────────────────
        // 9. ESPACIOS (con dimensiones y direcciones)
        // ────────────────────────────────────────────────
        $espaciosData = [
            // [cementerio_id, tipo_id, ancho, largo, precio_m2, seccion, numero, calle, fila]
            [$cementerio->id,  $tipoNicho->id,   1.00, 2.50, 1400.00, 'A', '1', 'Calle 1', '1'],
            [$cementerio->id,  $tipoNicho->id,   1.00, 2.50, 1400.00, 'A', '2', 'Calle 1', '1'],
            [$cementerio->id,  $tipoBoveda->id,  3.00, 3.00,  888.00, 'B', '1', 'Calle 2', '1'],
            [$cementerio->id,  $tipoTerreno->id, 2.00, 3.00,  833.00, 'C', '1', 'Calle 3', '1'],
            [$cementerio2->id, $tipoNicho->id,   1.00, 2.50, 1400.00, 'A', '1', 'Av. 1',   '1'],
            [$cementerio2->id, $tipoBoveda->id,  3.00, 3.00,  888.00, 'B', '1', 'Av. 2',   '1'],
        ];

        $espaciosCreados = [];
        foreach ($espaciosData as $e) {
            $dimId = DB::table('dimensiones')->insertGetId([
                'ancho'      => $e[2],
                'largo'      => $e[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $espacio = Espacio::create([
                'cementerio_id'      => $e[0],
                'dimension_id'       => $dimId,
                'tipo_inhumacion_id' => $e[1],
                'estado'             => 'disponible',
                'precio_m2'          => $e[4],
            ]);

            DB::table('direcciones')->insert([
                'espacio_id' => $espacio->id,
                'seccion'    => $e[5],
                'numero'     => $e[6],
                'calle'      => $e[7],
                'fila'       => $e[8],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $espaciosCreados[] = $espacio;
        }

        // ────────────────────────────────────────────────
        // 10. MANTENIMIENTOS DE PRUEBA
        // ────────────────────────────────────────────────
        $mantenimientosData = [
            [$espaciosCreados[0]->id, $tipoLimpieza->id,    60.00,  'pendiente',  'Limpieza mensual del nicho A-1'],
            [$espaciosCreados[0]->id, $tipoLimpieza->id,    60.00,  'pendiente',  'Segunda limpieza del nicho A-1'],
            [$espaciosCreados[0]->id, $tipoLimpieza->id,    70.00,  'pendiente',  'Limpieza profunda del nicho A-1'],
            [$espaciosCreados[1]->id, $tipoReparacion->id, 220.00,  'en_proceso', 'Reparación de grieta lateral'],
            [$espaciosCreados[2]->id, $tipoPintura->id,    160.00,  'completado', 'Repintado completo de la bóveda B-1'],
            [$espaciosCreados[3]->id, $tipoJardineria->id,  85.00,  'pendiente',  'Poda y limpieza de área verde'],
        ];

        foreach ($mantenimientosData as $m) {
            Mantenimiento::create([
                'espacio_id'            => $m[0],
                'tipo_mantenimiento_id' => $m[1],
                'precio'                => $m[2],
                'estado'                => $m[3],
                'descripcion'           => $m[4],
                'fecha_inicio'          => now()->subDays(rand(1, 30)),
                'fecha_fin'             => $m[3] === 'completado' ? now()->subDays(rand(1, 5)) : null,
            ]);
        }

        $this->command->info('✅ Datos de prueba cargados correctamente.');
        $this->command->info('');
        $this->command->info('👤 Usuarios creados:');
        $this->command->info('   admin    / admin123    (Administrador)');
        $this->command->info('   cajero   / cajero123   (Cajero)');
        $this->command->info('   operario / operario123 (Operario)');
    }
}
