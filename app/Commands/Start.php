<?php

namespace App\Commands;

use App\Commands\RegisterWorker\UserName;
use App\Models\AdminList;

class Start extends BaseCommand
{

    function processCommand($text = false)
    {
        $possible_admin_record = AdminList::where('chat_id', $this->user->chat_id)->first();
        if ($possible_admin_record) {
            $this->triggerCommand(MainMenu::class);
        } else {
            $this->triggerCommand(UserName::class);
        }
    }

}