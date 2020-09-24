<?php

namespace App\Commands\AddEquipment;

use App\Commands\BaseCommand;
use App\Models\AdminList;
use App\Models\User;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class SelectAreaNumber extends BaseCommand
{

    function processCommand()
    {
        $this->user->status = UserStatusService::SELECT_AREA_NUMBER;
        $this->user->save();

        $buttons = [
            ['1.1', '1.2'],
            ['1.3', '1.4'],
            ['1.5', '1.6'],
            ['2.1', '2.2'],
            ['2.4', '2.5'],
            ['2.6', '2.7'],
            ['3.1', '3.1'],
            ['3.2', '3.3'],
            ['3.4', '3.5'],
            ['3.6', '4.2'],
            ['4.3', '4.4'],
            ['4.5', '4.6'],
        ];
        $buttons[] = ['начать сначала'];

        $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Выберите участок', new ReplyKeyboardMarkup($buttons, false, true));
    }

}