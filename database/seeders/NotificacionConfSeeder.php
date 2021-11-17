<?php

namespace Database\Seeders;

use App\Models\NotificacionConf;
use Illuminate\Database\Seeder;

class NotificacionConfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $noti = new NotificacionConf();
        $noti -> codigo = "2021NC-1";
        $noti -> fechaEmDocumento = "2021-10-22" ;
        $noti -> lugar = "cochabamba";
        $noti -> estado = false;
        $noti -> documento = "7XcWvSqdDOAhziMIsd0m.pdf";
        $noti->save();
    }
}
