<?php

namespace App\Http\Controllers\Zadarma;

use App\Contact;
use App\Notifications\ZadarmaCallNotfy;
use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use Jlorente\Laravel\Zadarma\Facades\Zadarma;
use Jlorente\Laravel\Zadarma\Notifications\Channel\ZadarmaPhoneCallChannel;


class ZadarmaController extends Controller
{
    public function event(){
        echo '12345678';
        if (isset($_GET['zd_echo'])) exit($_GET['zd_echo']);
    }
//public function __construct(){
//
//    $balans = Zadarma::api()->getBalance();
//    $user = Contact::query()->firstOrFail();
//
//    Notification::send($user, new ZadarmaCallNotfy());
//
//    dd($user);
//    return false;
//}
    public function call(Request $request){
        //        dd(ZadarmaController::class);
//        $api = new \Zadarma_API\Api(config('zadarma.api_key'), config('zadarma.api_secret'),true);
//
//        try{
//            $result = $api->getSipStatus('917775');
//            echo $result->sip.'w status: '.($result->is_online ? 'online' : 'offline');
//        } catch (\Zadarma_API\ApiException $e) {
//            echo 'Error: '.$e->getMessage();
//        }
        //            ksort($params);
//            $paramsStr = http_build_query($params);
//            $sign = base64_encode(hash_hmac('sha1', $method . $paramsStr . md5($paramsStr), config('zadarma.api_secret')));
//            $header = 'Authorization: ' . config('zadarma.api_key') . ':' . $sign;
//            echo $header;

//        try {
//            $params = [
//                'from' => '+37498408686',
//                'to' => '+37498953274',
//               // 'predicted',
//            ];
//            $method = '/v1/request/callback/';
//
//            $zd = new \Zadarma_API\Client(config('zadarma.api_key'), config('zadarma.api_secret'),true);
//            $answer = $zd->call($method, $params);
//            $answerObject = json_decode($answer);
//            if ($answerObject->status === 'success') {
//                print_r($answerObject);
//            } else {
//                echo $answerObject->message;
//            }
//        } catch (Exception $e) {
//            dd($e->getMessage());
//        }
    }
}
