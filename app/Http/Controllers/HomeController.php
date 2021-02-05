<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forms\ConfForm;
use Illuminate\Support\Facades\Storage;
use Kris\LaravelFormBuilder\FormBuilder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $this->middleware(function ($request, $next){
            //session()->flush();
            //exit();
            $login = session('login');
            if(session('login')){

            }else{
                redirect()->route('login')->send();
            }
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(FormBuilder $formBuilder)
    {
        $log = Storage::get('aausers'.session('currentpath').'/test.log');
        $conf = base_path().'/aausers'.session('currentpath').'/config.json';
        //echo $conf;
        //exit();
        $conf = json_decode(file_get_contents($conf), true); 
        $form = $formBuilder->create(ConfForm::class, [
            'method' => 'POST'
        ],['conf' => $conf]);

        return view('home',['log' => $log,'form' => $form]);
    }
    /*public function test($key)
    {
        echo "test";

    }*/
    public function switch_instance($key)
    {
        //echo "test";
        //exit();
        //print_r(session('details')['instances'][$key]);

       session(['currentpath' => session('details')['instances'][$key]]);
       return redirect('home');
    }

}
