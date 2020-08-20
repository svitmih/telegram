<?php

require __DIR__.'/../vendor/autoload.php';



try {
    $bot = new \TelegramBot\Api\Client('1321013079:AAFbmC4-pJA0WfwUIH_qLL8ytbO0DAR-7_I');
    // or initialize with botan.io tracker api key
    // $bot = new \TelegramBot\Api\Client('YOUR_BOT_API_TOKEN', 'YOUR_BOTAN_TRACKER_API_KEY');
    
// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать!';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// помощ
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/help - помощ';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// запускаем обработку
$bot->run();

} catch (\TelegramBot\Api\Exception $e) {
    $e->getMessage();
}