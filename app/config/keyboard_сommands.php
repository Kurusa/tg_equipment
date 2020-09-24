<?php
return [
    'добавить оборудование' => \App\Commands\AddEquipment\Type::class,
    'выбор типа' => \App\Commands\AddEquipment\Type::class,
    'начать сначала' => \App\Commands\MainMenu::class,
    'кому передать' => \App\Commands\AddEquipment\SelectWorker::class,
    'выбрать другой участок' => \App\Commands\AddEquipment\SelectAreaNumber::class,
    'мое оборудование' => \App\Commands\WorkerEquipment::class
];