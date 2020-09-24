<?php

namespace App\Commands\AddEquipment;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Type extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::EQUIPMENT_TYPE) {
            $equipment = \App\Models\EquipmentType::where('title', $this->update->getMessage()->getText())->first();
            if ($equipment) {
                $this->user->equipment_type_id = $equipment->id;
                $this->user->save();

                $this->triggerCommand(Title::class);
            } else {
                $this->getBot()->sendMessage($this->user->chat_id, 'Выберите оборудование с клавиатуры ниже');
            }
        } else {
            $this->user->status = UserStatusService::EQUIPMENT_TYPE;
            $this->user->save();

            $buttons = [];
            $equipment_list = \App\Models\EquipmentType::all();
            foreach ($equipment_list as $equipment) {
                $buttons[] = [$equipment->title];
            }
            $buttons[] = ['кому передать'];
            $buttons[] = ['начать сначала'];

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Выберите тип оборудования', new ReplyKeyboardMarkup($buttons, false, true));
        }
    }

}