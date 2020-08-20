<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::post('/webhook', function () {
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
    /help - помощь';
        $bot->sendMessage($message->getChat()->getId(), $answer);
    });

    // запускаем обработку
    $bot->run();

    } catch (\TelegramBot\Api\Exception $e) {
        $e->getMessage();
    }
}); */

Route::post('/webhook', 'TelegramController@index');

//Route::post('/42yUojv1YQPOssPEpn5i3q6vjdhh7hl7djVWDIAVhFDRMAwZ1tj0Og2v4PWyj4PZ/webhook', 'TelegramController@index')->name('tlg');

Route::get('/setwebhook', function () {

    $token = "1321013079:AAE5xNALr0zDQ8Ym_HkUdsnEPLaGxpzTC-c";
    $bot = new \TelegramBot\Api\BotApi($token);

    $page_url = 'https://4502a04726f3.ngrok.io/webhook';
    $result = $bot->setWebhook($page_url);
    dd($result);
});

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/cabinet', 'Cabinet\HomeController@index')->name('cabinet');
