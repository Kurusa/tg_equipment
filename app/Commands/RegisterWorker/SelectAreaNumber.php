<?php

namespace App\Commands\RegisterWorker;

use App\Commands\BaseCommand;
use App\Commands\MainMenu;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class SelectAreaNumber extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::SELECT_AREA_NUMBER_REGISTER) {
            $this->user->area_number = $this->update->getMessage()->getText();
            $this->user->save();

            $this->triggerCommand(MainMenu::class);
        } else {
            $this->user->status = UserStatusService::SELECT_AREA_NUMBER_REGISTER;
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

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Выберите участок', new ReplyKeyboardMarkup($buttons, false, true));
        }
    }

}