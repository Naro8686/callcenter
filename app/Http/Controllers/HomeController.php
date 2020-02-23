<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required',
            'name' => 'required|max:100',
            'phone' => 'required|regex:~^(\+7)\(?[489][0-9]{2}\)[0-9]{3}[\s\-][0-9]{2}[\s\-][0-9]{2}$~u',
            'massage' => 'sometimes|max:500',
        ]);
        if ($validator->fails()) {
            return redirect($request['url'] . "?success=false");
        }
        $request->merge(['phone' => preg_replace('/[^\d]/', '', $request['phone'])]);
        Contact::query()->create($request->all());
        return redirect($request['url'] . "?success=true");
    }
}
