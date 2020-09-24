<?php

namespace App\Commands;

use App\Models\Equipment;

class ProcessEquipment extends BaseCommand
{

    function processCommand()
    {
        $callback_data = json_decode($this->update->getCallbackQuery()->getData(), true);

        $this->getBot()->sendMessage($this->user->chat_id, $callback_data['admin_id']);
        if ($callback_data['a'] == 'access_equipment') {
            Equipment::where('admin_user_id', $callback_data['admin_id'])->where('status', 'PENDING')->where('worker_user_id', $this->user->id)->update([
                'status' => 'ACCESSED',
            ]);
        } else {
            Equipment::where('admin_user_id', $callback_data['admin_id'])->where('status', 'PENDING')->where('worker_user_id', $this->user->id)->update([
                'status' => 'DECLINED',
            ]);
        }

        $this->getBot()->deleteMessage($this->user->chat_id, $this->update->getCallbackQuery()->getMessage()->getMessageId());
    }

}