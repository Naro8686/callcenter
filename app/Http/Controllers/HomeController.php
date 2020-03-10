<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Imports\CallImport;
use App\Seo;
use App\Url;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

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

    public function phone()
    {
        return view('phone');
    }

    public function upload(Request $request)
    {
        $validator = Validator::make(
            [
                'file' => $request->file('upload'),
                'extension' => strtolower($request->file('upload')->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp',
            ]
        );

        try {
            if ($validator->fails()) {
                throw new Exception('выбран неправильный формат (doc,csv,xlsx,xls,docx,ppt,odt,ods,odp)');
            }
            throw new Exception('Coming soon');//product-i hamar jnjel es toxe
            Excel::import(new CallImport(), $request->file('upload'));
        } catch (Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
        return redirect()->back()->with('message', 'файл успешно загружен');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $urls = Url::all()->sortBy('id', false);
        $contacts = Contact::query()->orderByDesc('status')->paginate(10);
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
        $domain = Url::query()->pluck('domain')->toArray();
        $request->merge(['domain' => preg_replace('~^(https://|http://)(.*?)(/?)$~i', '$2', $request['url'])]);
        $request->merge(['phone' => preg_replace('/[^\d]/', '', $request['phone'])]);
        if ($validator->fails() || !array_search($request['domain'], $domain)) {
            return redirect($request['url'] . "?success=false");
        }
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
        $request->merge(['domain' => preg_replace('~^(https://|http://)(.*?)(/?)$~i', '$2', $request['domain'])]);
        $request->validate([
            'domain' => 'required|unique:urls,domain|regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i|max:100'
        ]);
        Url::query()->create([
            'domain' => $request['domain']
        ])->seo()->create([
            'title' => 'title',
        ]);
        return redirect()->back()->with('message', 'домен добавлен');
    }

    public function domainDelete($id)
    {
        try {
            Url::query()->findOrFail($id)->delete();
        } catch (Exception $e) {
            return redirect('/admin')->withErrors(['error' => $e->getMessage()]);
        }
        return redirect('/admin')->with('message', 'домен удалён');
    }

    public function domainEdit($id, Request $request)
    {
        unset($request['_token']);
        $request->merge(['domain' => preg_replace('~^(https://|http://)(.*?)(/?)$~i', '$2', $request['domain'])]);
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
