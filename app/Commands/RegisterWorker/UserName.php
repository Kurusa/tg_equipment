<?php

namespace App\Commands\RegisterWorker;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;

class UserName extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::USER_NAME) {
            $this->user->bot_name = $this->update->getMessage()->getText();
            $this->user->save();

            $this->triggerCommand(SelectAreaNumber::class);
        } else {
            $this->user->status = UserStatusService::USER_NAME;
            $this->user->save();

            $this->getBot()->sendMessage($this->user->chat_id, 'Введите Фамилию, Имя и Отчество');
        }
    }

}

