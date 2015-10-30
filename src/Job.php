<?php
/**
 * Job
 * @author mosen <xu179@126.com>
 */
namespace tanshuimaoxian\queue;
class Job
{
    // task
    public $task;
    // queue name
    public $queue;
    // data from task
    public $msg;

    public function __construct($task, $msg)
    {
        $this->task = $task;
        $this->queue = $msg[0];
        $this->msg = json_decode($msg[1], true);
    }

    /**
     * run
     */
    public function run()
    {
        if (isset($this->msg['job'])) {
            if (!is_array($this->msg['job'])) {
                $job = explode('@', $this->msg['job']);
            }
            $class = $job[0];
            $method = isset($job[1]) ? $job[1] : 'run';
            $instance = \Yii::createObject(array('class'=>$class));
            @call_user_func_array(array($instance, $method), array($this, $this->msg['data']));
        }
        
    }
}