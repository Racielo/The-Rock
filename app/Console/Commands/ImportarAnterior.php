<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\{DB,Schema,Hash};
class ImportarAnterior extends Command {
    protected $signature='rock:importar {base_origen : Base MySQL anterior, por ejemplo therock}';
    protected $description='Copia datos de la base PHP anterior a una base Laravel vacía, sin modificar el origen';
    public function handle(): int {
        if (DB::getDriverName() !== 'mysql') { $this->error('Este importador requiere MySQL.');return 1; }
        $origen=$this->argument('base_origen');
        if (!preg_match('/^[A-Za-z0-9_-]+$/',$origen) || $origen===DB::getDatabaseName()) { $this->error('Especifica una base de origen distinta de la de Laravel.');return 1; }
        $tables=['usuarios','productos','inventario','recetas','pedidos','pedido_detalles','movimientos_inventario'];
        foreach($tables as $table) if(DB::table($table)->exists()) { $this->error('La base destino debe estar vacía. No se sobrescribió nada.');return 1; }
        config(['database.connections.anterior'=>array_merge(config('database.connections.mysql'),['database'=>$origen,'url'=>null])]);
        DB::purge('anterior');$source=DB::connection('anterior');
        foreach($tables as $table) if (!Schema::connection('anterior')->hasTable($table)) { $this->error('Falta la tabla '.$table.' en el origen. Ejecuta primero las mejoras del proyecto PHP sobre una copia.');return 1; }
        if (!$this->confirm('¿Copiar '.$origen.' a '.DB::getDatabaseName().' (el origen no se modifica)?')) return 1;
        DB::transaction(function () use ($tables,$source) {
            foreach($tables as $table) {
                $columns=Schema::getColumnListing($table);
                foreach($source->table($table)->get() as $record) {
                    $row=array_intersect_key((array)$record,array_flip($columns));
                    if ($table==='usuarios' && !password_get_info($row['pass'])['algo']) $row['pass']=Hash::make($row['pass']);
                    DB::table($table)->insert($row);
                }
            }
        });
        $this->info('Datos copiados. Copia también las fotografías según LEEME.md.');return 0;
    }
}
