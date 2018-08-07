<?php

namespace OkamiChen\ConfigureClient\Console\Command;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Exception;
use OkamiChen\ConfigureClient\Event\ConfigFailed;
use OkamiChen\ConfigureClient\Event\ConfigSuccess;

class DaemonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'configure:client:daemon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '配置系统监听';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $config = config('configure.client');
        
        while(true){
            try {
                $this->doRun($config);
            } catch (Exception $ex) {
                $time   = date('Y-m-d H:i:s');
                $this->error('时间: ' . $time);
                $this->error('状态: 失败');
                $this->error('内容: ' . $ex->getMessage());
                $this->split();
                $event  = new ConfigFailed($time, $ex->getMessage());
                event($event);
            } finally {
                sleep(array_get($config, 'sleep', 5));
            }
        }
    }
    
    /**
     * 运行
     * @param type $config
     * @throws Exception
     */
    protected function doRun($config){
        
        if(!$config){
            throw new Exception('!!!配置系统URL未配置!!!');
        }

        $guzzle = array_get($config, 'guzzle');
        $uri    = array_get($config, 'url');
        
        if(!$uri){
            throw new Exception('!!!配置系统URL未找到!!!');
        }
        
        $client = new Client($guzzle);
        
        $options    = [
            'json'  => gethostname(),
        ];

        try {
            $response   = $client->request('post', $uri, $options);
            $body       = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        
        if(array_get($body, 'errorCode', 200)){
            $error  = array_get($body, 'errorMessage', '服务端异常');
            throw new Exception($error);
        }
        
        $time   = date('Y-m-d H:i:s');
        $config = array_get($body, 'config', []);
        $this->line('时间: ' . $time);
        $this->line('状态: 成功');
        $this->line('内容: 配置文件写入成功');
        $this->split();
        
        $event  = new ConfigSuccess($time, $config);
        event($event);
    }
    
    protected function split(){
        $this->line('------------------------------');
    }
}
