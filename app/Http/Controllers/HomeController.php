<?php

namespace App\Http\Controllers;

use App\Forms\ConfForm;
use App\Forms\FileForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Kris\LaravelFormBuilder\FormBuilder;
use Symfony\Component\Process\Process;

class HomeController extends Controller
{
    private $fileName = "userFile";

    public function getProcessId()
    { 
        $path = 'aausers'.session('currentpath').'/run.pid';
        
        $content = Storage::exists($path);

        if($content){
            $content = Storage::get($path);
            if(trim($content) == ''){
              return -1;
            }else{
              return $content;
            }
        }else
          return 0;
    }
    public function getLog($download = null)
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
    public function downloadConfig()
    {
        $path = 'aausers'.session('currentpath').'/config.json';
        return Storage::download($path);
    }
    public function uploadFile(Request $request)
    {
    $extension = $request->file('upload_file')->extension();
    $path = $request->file('upload_file')->storeAs('aausers'.session('currentpath'),$this->fileName.'.'.$extension);
        return redirect('home');
    }
    
    public function runprocess()
    {
        // path to current instance
        $path = base_path().'/aausers'.session('currentpath');
        //shell_exec("cd /var/www/html/python && nohup python3 python.py </dev/null &>/dev/null &");
        //$process = new Process(['ls']);
        //$process->setWorkingDirectory('/var/www/html/python');
        //$process->run();
        //return $process;
        //system("echo 'Run'");
        /*$process = Process::fromShellCommandline('cd /var/www/html/python && nohup python3 python.py </dev/null &>/dev/null &');
        $process->start();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
         //throw new ProcessFailedException($process);
        }

        return $process->getOutput();*/

        $process = Process::fromShellCommandline('cd '.$path.' && nohup python3 main.py </dev/null &>/dev/null &');
        $process->start();

        $this->processId = $process->getPid() + 1;

        // write process id to file
        session(['processId' => $this->processId]);

        return $this->processId;

    }
    public function killprocess()
    {   
        // get process id from file
        $process = Process::fromShellCommandline("kill -9 ".session('processId'));
        $process->start();
        //return ;
    }

}
// refresh button  - try to update every 5 sec -done
// upload name file static name - done
// downlaod button for config - done
// processid show - try to update every 5 sec