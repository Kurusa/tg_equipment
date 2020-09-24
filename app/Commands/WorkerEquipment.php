<?php

namespace App\Commands;

use App\Models\Equipment;
use Illuminate\Database\Capsule\Manager as DB;

class WorkerEquipment extends BaseCommand
{

    function processCommand()
    {
        $list = DB::select('SELECT type.title, type.id AS type_id, count(*) AS count 
FROM equipment
INNER JOIN equipment_type AS type ON type.id = equipment.type_id
WHERE worker_user_id = ' . $this->user->id . '
AND status = "ACCESSED"
GROUP BY type_id');

        $message = 'Вам передали: ' . "\n" . "\n";
        foreach ($list as $item) {
            $message .= $item->title . ' ' . $item->count . "\n";

            $equipment_title_list = Equipment::where('worker_user_id', $this->user->id)->where('type_id', $item->type_id)->where('status', 'ACCESSED')->get();
            foreach ($equipment_title_list as $value) {
                $message .= $value->title . "\n";
            }
            $message .= "\n";
        }

        $this->getBot()->sendMessage($this->user->chat_id, $message);
    }

}