<?php

namespace App\Commands\AddEquipment;

use App\Commands\BaseCommand;
use App\Commands\MainMenu;
use App\Models\AdminList;
use App\Models\Equipment;
use App\Models\User;
use App\Services\Status\UserStatusService;
use Illuminate\Database\Capsule\Manager as DB;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class SelectWorker extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::SELECT_WORKER) {
            $worker_name = explode(', ', $this->update->getMessage()->getText());
            $possible_user = User::where('bot_name', $worker_name[0])->first();

            if ($possible_user) {
                $result = DB::select('SELECT type.title, type.id AS type_id, count(*) AS count 
FROM equipment
INNER JOIN equipment_type AS type ON type.id = equipment.type_id
WHERE admin_user_id = ' . $this->user->id . '
AND status = "NEW"
GROUP BY type_id');

                $message = 'Вам передали: ' . "\n" . "\n";
                foreach ($result as $item) {
                    $message .= $item->title . ' ' . $item->count . "\n";

                    $equipment_title_list = Equipment::where('admin_user_id', $this->user->id)->where('type_id', $item->type_id)->where('status', 'NEW')->get();
                    foreach ($equipment_title_list as $value) {
                        $message .= $value->title . "\n";
                    }
                    $message .= "\n";
                }
                $this->getBot()->sendMessageWithKeyboard($possible_user->chat_id, $message, new InlineKeyboardMarkup([
                    [[
                        'text' => 'Принять',
                        'callback_data' => json_encode([
                            'a' => 'access_equipment',
                            'admin_id' => $this->user->id
                        ])
                    ]],[[
                        'text' => 'Отказаться',
                        'callback_data' => json_encode([
                            'a' => 'decline_equipment',
                            'admin_id' => $this->user->id
                        ])
                    ]],
                ]));

                Equipment::where('admin_user_id', $this->user->id)->where('status', 'NEW')->update([
                    'status' => 'PENDING',
                    'worker_user_id' => $possible_user->id
                ]);

                $this->triggerCommand(MainMenu::class);
            } else {
                $this->getBot()->sendMessage($this->user->chat_id, 'Пользователь не найден');
            }
        } else {
            $this->user->status = UserStatusService::SELECT_WORKER;
            $this->user->save();

            $area_list = [
                '1.1',
                '1.2',
                '1.3',
                '1.4',
                '1.5',
                '1.6',
                '2.1',
                '2.2',
                '2.4',
                '2.5',
                '2.6',
                '2.7',
                '3.1',
                '3.1',
                '3.2',
                '3.3',
                '3.4',
                '3.5',
                '3.6',
                '4.2',
                '4.3',
                '4.4',
                '4.5',
                '4.6',
            ];
            if (in_array($this->update->getMessage()->getText(), $area_list)) {
                $area_number = $this->update->getMessage()->getText();
            } else {
                $admin_data = AdminList::where('chat_id', $this->user->chat_id)->first();
                $area_number = $admin_data->area_number;
            }
            $worker_list = User::where('bot_name', '!=', '')->where('area_number', $area_number)->get();

            $buttons = [];
            foreach ($worker_list as $worker) {
                $buttons[] = [$worker->bot_name . ', ' . $worker->area_number];
            }
            $buttons[] = ['выбрать другой участок'];
            $buttons[] = ['начать сначала'];

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Выберите сотрудника, которому хотите передать оборудование', new ReplyKeyboardMarkup($buttons, false, true));
        }
    }

}