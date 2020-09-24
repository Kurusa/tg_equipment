<?php

namespace App\Commands\AddEquipment;

use App\Commands\BaseCommand;
use App\Models\Equipment;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Title extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::EQUIPMENT_TITLE) {
            Equipment::create([
                'admin_user_id' => $this->user->id,
                'type_id' => $this->user->equipment_type_id,
                'title' => $this->update->getMessage()->getText()
            ]);
            $this->getBot()->sendMessage($this->user->chat_id, 'Добавлено');
        } else {
            $this->user->status = UserStatusService::EQUIPMENT_TITLE;
            $this->user->save();

            $buttons[] = ['выбор типа'];
            $buttons[] = ['начать сначала'];
            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Введите серийный номер', new ReplyKeyboardMarkup($buttons, false, true));
        }
    }

}