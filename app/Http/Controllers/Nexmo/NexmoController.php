<?php

namespace App\Http\Controllers\Nexmo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Nexmo\Call\Call;
use Nexmo\Client;
use Illuminate\Support\Facades\Log;
use Nexmo\Client\Credentials\Keypair;

class NexmoController extends Controller
{
    /**
     * @param array $ncco
     */
    protected $ncco = [];

    public function __construct()
    {
//        $this->ncco = file_exists(storage_path('nexmo/ncco.json'))
//            ? json_decode(file_get_contents(storage_path('nexmo/ncco.json')), true)
//            : [
//                [
//                    "action" => "talk",
//                    "text" => "Добро пожаловать",
//                    "voiceName" => "Tatyana",
//                ]
//            ];
        //$this->middleware('auth');

    }

    public function call(Request $request)
    {
        $this->append([
            "action" => "connect",
            "from" => env("NEXMO_NUMBER", "12015009254"),
            "endpoint" => [
                [
                    "type" => "phone",
                    "number" => "37498953274"
                ]
            ]
        ]);
        $this->append([
            "action" => "talk",
            "text" => "You are connected"
        ]);


        //dd($this->ncco);
//        $this->append([
//            "action" => "talk",
//            "text" => "Press 1 to hear Taylor's latest tweet. Press 2 to listen to the latest Laravel Podcast",
//            "bargeIn" => true
//        ]);
//        $this->append([
//            "action" => "input",
//            "eventUrl" => [route("nexmo.menu")],
//            "maxDigits" => 1
//        ]);
        try {
            $keypair = new Keypair(
                file_get_contents(config("nexmo.private_key")),
                config("nexmo.application_id")
            );
            $client = new Client($keypair);
            $call = new Call();
            $call->setTo("37498408686")
                ->setFrom(env("NEXMO_NUMBER", "12015009254"))
                ->setNcco($this->ncco);
            $response = $client->calls()->create($call);

            // Log::info("Call fallback", $request->all());
            echo $response->getId();
            //return response('', 204);

        } catch (\Exception $exception) {
            dd($exception);
        }

    }

    public function event(Request $request)
    {
        Log::info("Call event", $request->all());
        return error_log($request->getContent());;
    }

    public function menu(Request $request)
    {
        Log::info("Call menu", $request->all());
        switch ($request->json("dtmf")) {
            case "1";
                $this->append([
                    "action" => "stream",
                    "level" => 1,
                    "streamUrl" => [asset("records/song.mp3")],
                ]);
                return $this->ncco;
            case "2":
                $this->append([
                    "action" => "talk",
                    "text" => "abres"
                ]);
                return $this->ncco;
            default:
                return $this->answer($request);
        }
    }

    public function answer(Request $request)
    {
        DB::table("tests")->insert(["data" => json_encode(["answer" => $request->all()])]);
        Log::info("Call answer", $request->all());
        return [
            [
                "action" => "talk",
                "text" => "Welcome to the Laravel Hotline"
            ],
            [
                "action" => "talk",
                "text" => "Press 1 to hear Taylor's latest tweet. Press 2 to listen to the latest Laravel Podcast",
                "bargeIn" => true
            ],
            [
                "action" => "input",
                "eventUrl" => [route("nexmo.menu")],
                "maxDigits" => 1
            ]

        ];
    }

    public function fallback(Request $request)
    {
        DB::table("tests")->insert(["data" => json_encode(["fallback" => $request->all()])]);
        Log::info("Call fallback", $request->all());
        return response("", 204);
    }

    protected function append($ncco)
    {
        array_push($this->ncco, $ncco);
    }

    protected function prepend($ncco)
    {
        array_unshift($this->ncco, $ncco);
    }
}
