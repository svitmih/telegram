<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function index()
    {
        try {
            $bot = new \TelegramBot\Api\Client('1321013079:AAE5xNALr0zDQ8Ym_HkUdsnEPLaGxpzTC-c');

            //$bot = new \TelegramBot\Api\BotApi('1321013079:AAFbmC4-pJA0WfwUIH_qLL8ytbO0DAR-7_I');

            // обязательное. Запуск бота
            $bot->command('start', function ($message) use ($bot) {
                $user = User::where('id', 1)->first();
                $answer = $user->email;
                $bot->sendMessage($message->getChat()->getId(), $answer);
            });

            // помощь
            $bot->command('help', function ($message) use ($bot) {
                $answer = 'Команды:
            /help - помощь';
                $bot->sendMessage($message->getChat()->getId(), $answer);
            });

            // Кнопки у сообщений
            $bot->command("test", function ($message) use ($bot) {
                $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                    [
                        [
                            ['callback_data' => 'data_test', 'text' => 'Answer'],
                            ['callback_data' => 'data_test2', 'text' => 'ОтветЪ']
                        ]
                    ]
                );

                $bot->sendMessage($message->getChat()->getId(), "тест", false, null,null,$keyboard);
            });

            $bot->on(function($update) use ($bot){
                $callback = $update->getCallbackQuery();
                $message = $callback->getMessage();
                $chatId = $message->getChat()->getId();
                $data = $callback->getData();

                if($data == "data_test"){
                    $bot->answerCallbackQuery( $callback->getId(), "This is Ansver!",true);
                }
                if($data == "data_test2"){
                    $bot->sendMessage($chatId, "Это ответ!");
                    $bot->answerCallbackQuery($callback->getId()); // можно отослать пустое, чтобы просто убрать "часики" на кнопке
                }

            }, function($update){
                $callback = $update->getCallbackQuery();
                if (is_null($callback) || !strlen($callback->getData()))
                    return false;
                return true;
            });

            // Reply-Кнопки
            $bot->command("buttons", function ($message) use ($bot) {
                $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([[["text" => "Власть советам!"], ["text" => "Сиськи!"]]], true, true);
                //$bot->sendMessage($message->getChat()->getId(), "тест2", false, null,null, $keyboard);

                $bot->sendMessage($message->getChat()->getId(), "тест2", false, null,null, $keyboard);
            });

            $bot->on(function($Update) use ($bot){

                $message = $Update->getMessage();
                $mtext = $message->getText();
                $cid = $message->getChat()->getId();

                if(mb_stripos($mtext,"Сиськи") !== false){
                    $pic = "http://aftamat4ik.ru/wp-content/uploads/2017/05/14277366494961.jpg";

                    $bot->sendPhoto($message->getChat()->getId(), $pic);
                }
                if(mb_stripos($mtext,"власть советам") !== false){
                    $bot->sendMessage($message->getChat()->getId(), "Смерть богатым!");
                }
            }, function($update) {
                $msg = $update->getMessage();
                if (is_null($msg) || !strlen($msg->getText())) {  return false;   }
		        return true;
            });

            // запускаем обработку
            $bot->run();

        } catch (\TelegramBot\Api\Exception $e) {
            $e->getMessage();
        }
    }
}
