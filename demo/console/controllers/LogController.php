<?php
namespace console\controllers;
use \tanshuimaoxian\crontab\Task;
use \tanshuimaoxian\queue\Job;

class LogController extends Task
{
    protected $taskName = "log";
    public $server;
    public $listenQueue = "queue|log";
    public function actionRun()
    {
        $this->server = \Yii::$app->queue;
        while(true) {
            try {
                $msg = $this->server->receive($this->listenQueue);
                if(!empty($msg)) {
                    //保存队列消息日志
                    $this->log($msg);
                    //处理队列
                    $job = new Job();
                    $job->run($this, $msg);
                }
                $this->sleep(1);
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                $this->log("error:".$msg);
            }
        }
    }
} 
