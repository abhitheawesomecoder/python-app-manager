<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forms\ConfForm;
use App\Forms\FileForm;
use Illuminate\Support\Facades\Storage;
use Kris\LaravelFormBuilder\FormBuilder;

class HomeController extends Controller
{
    private function getLog($download = null)
    {   
        $log = '';
        $arrDir = Storage::directories('aausers'.session('currentpath').'/logs');
        if(empty($arrDir))
            return $log;
        $newArr = [];
        foreach ($arrDir as $key => $value) {
            $rowarrDir = explode("/",$value);
            array_push($newArr,end($rowarrDir));
        }
        $sorted = collect($newArr)->sort()->all();
        $latest = end($sorted);
        $path = 'aausers'.session('currentpath').'/logs/'.$latest.'/client.log';
        if($download)
            return Storage::download($path);
        $log = Storage::get($path);
        return $log;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $this->middleware(function ($request, $next){
            $login = session('login');
            if(session('login')){

            }else{
                redirect()->route('login')->send();
            }
            return $next($request);
        });
    }
//nohup python3 main.py & echo $! > run.pid
//kill -9 41345
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(FormBuilder $formBuilder)
    {
        $log = $this->getLog();
        $conf = base_path().'/aausers'.session('currentpath').'/config.json';
        //echo $conf;
        //exit();
        $conf = json_decode(file_get_contents($conf), true); 
        $form = $formBuilder->create(ConfForm::class, [
            'method' => 'POST'
        ],['conf' => $conf]);

        $fileform = $formBuilder->create(FileForm::class, [
            'method' => 'POST',
            'url' => route('upload.file'),
            'id' => 'module_form'
        ]);

        return view('home',['log' => $log,'form' => $form, 'fileform' => $fileform]);
    }
    public function postindex(Request $request)
    {
        $confpath = base_path().'/aausers'.session('currentpath').'/config.json';
        $conf = json_decode(file_get_contents($confpath), true); 
        $arr = [];
        foreach ($conf as $key => $value) {  
            $arr[$key] = $request->${'key'};
        } 
        Storage::put('aausers'.session('currentpath').'/config.json', json_encode($arr));
        
       return redirect()->route('home');
    }
    public function switch_instance($key)
    {
       session(['currentpath' => session('details')['instances'][$key]]);
       return redirect('home');
    }
    public function downloadLog()
    {
        return $this->getLog(true);
    }
    public function uploadFile(Request $request)
    {
        $path = $request->file('upload_file')->store('aausers'.session('currentpath'));
        return redirect('home');
    }

}
