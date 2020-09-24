<?php

use App\Services\Status\UserStatusService;

return [
    UserStatusService::EQUIPMENT_TYPE => \App\Commands\AddEquipment\Type::class,
    UserStatusService::EQUIPMENT_TITLE => \App\Commands\AddEquipment\Title::class,
    UserStatusService::SELECT_AREA_NUMBER => \App\Commands\AddEquipment\SelectWorker::class,
    UserStatusService::SELECT_WORKER => \App\Commands\AddEquipment\SelectWorker::class,
    UserStatusService::USER_NAME => \App\Commands\RegisterWorker\UserName::class,
    UserStatusService::SELECT_AREA_NUMBER_REGISTER => \App\Commands\RegisterWorker\SelectAreaNumber::class,
];