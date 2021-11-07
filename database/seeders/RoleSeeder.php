<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name'=>'ADMINISTRADOR']);
        $role2 = Role::create(['name'=>'VENDEDOR']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'productos.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'productos.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'productos.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'productos.delete'])->syncRoles([$role1]);
        Permission::create(['name' => 'productos.show'])->syncRoles([$role1]);
        Permission::create(['name' => 'productos.upload'])->syncRoles([$role1]);
        Permission::create(['name' => 'productos.saveExcel'])->syncRoles([$role1]);

        Permission::create(['name' => 'user.index'])->syncRoles(['ADMINISTRADOR']);
        Permission::create(['name' => 'proveedores.index'])->syncRoles(['ADMINISTRADOR']);
        Permission::create(['name' => 'compras.create'])->syncRoles(['ADMINISTRADOR']);
        Permission::create(['name' => 'compras.index'])->syncRoles(['ADMINISTRADOR']);

        Permission::create(['name' => 'reporte.ventas'])->syncRoles(['ADMINISTRADOR']);
        Permission::create(['name' => 'reporte.compras'])->syncRoles(['ADMINISTRADOR']);
        Permission::create(['name' => 'reporte.inventario'])->syncRoles(['ADMINISTRADOR']);

    }
}
