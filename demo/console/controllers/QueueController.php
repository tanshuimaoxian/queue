<?php
namespace console\controllers;
use \tanshuimaoxian\crontab\Task;
use \tanshuimaoxian\queue\Job;

class QueueController extends Task
{
    protected $taskName = "queue";
    public $server;
    public $listenQueue = "queue";
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
                $this->checkSign();
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                $this->log("error:".$msg);
            }
        }
    }
} 
