<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Seo;
use App\Url;
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
        $urls = Url::all()->sortBy('id', false);
        $contacts = Contact::query()->paginate(10);
        return view('home', compact('urls', 'contacts'));
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

    public function siteMap($url)
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, "http://{$url}/assets/php/sitemap.php");
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
            $out = curl_exec($curl);
            curl_close($curl);
            if ($out) {
                return redirect()->back()->with('message', 'sitemap.xml успешно сгенерирован');
            }
        }
        return redirect()->back()->withErrors(["errors" => "ошибка"]);
    }

    public function domainShow(int $id)
    {
        $urls = Url::all()->sortBy('id', false);
        $url = Url::query()->with('seo')->findOrFail($id);
        return view('domain', compact('url', 'urls'));
    }

    public function domainAdd(Request $request)
    {
        $request->validate([
            'domain' => 'required|unique:urls|regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i|max:100'
        ]);
        Url::query()->create([
            'domain' => $request->input('domain')
        ])->seo()->create([
            'title' => 'title',
        ]);
        return redirect()->back()->with('message', 'домен добавлен');
    }

    public function domainDelete($id)
    {
        try {
            Url::query()->findOrFail($id)->delete();
        } catch (\Exception $e) {
            return redirect('/admin')->withErrors(['error' => $e->getMessage()]);
        }
        return redirect('/admin')->with('message', 'домен удалён');
    }

    public function domainEdit($id, Request $request)
    {
        unset($request['_token']);
        $request->validate([
            "domain" => "required|unique:urls,domain,{$id}"
        ]);
        Url::query()->findOrFail($id)->update(['domain' => $request['domain']]);
        return redirect()->back()->with('message', 'домен изменён');
    }

    public function seoChange($id, Request $request)
    {
        unset($request['_token']);
        $request->validate([
            "title" => "required",
            "keywords" => "sometimes|max:1500",
            "description" => "sometimes|max:1500",
            "text" => "sometimes|max:1500",
            "url_id" => "required|exists:urls,id",
        ]);
        Seo::query()->findOrFail($id)->update($request->all());
        return redirect()->back()->with('message', 'успешное изменение');
    }
}
