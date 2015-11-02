<?php
/**
 * AsyncController
 * @author mosen <xu179@126.com>
 */
namespace console\controllers;
use \tanshuimaoxian\crontab\Task;
use \tanshuimaoxian\queue\Job;

class AsyncController extends Task
{
    protected $taskName = "async";
    public $server;
    public $queue = "queue|async";

    /**
     * actionRun
     * usage: yii async/run & 
     */
    public function actionRun()
    {
        $this->server = \Yii::$app->queue;
        while(true) {
            try {
                $msg = $this->server->receive($this->queue);
                if(!empty($msg)) {
                    //保存队列消息日志
                    $this->log($msg);
                    //处理队列
                    $job = new Job($this, $msg);
                    $job->run();
                }
                $this->checkSign();
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                $this->log("error:".$msg);
            }
        }
    }
} 
