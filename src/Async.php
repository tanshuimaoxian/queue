<?php
/**
 * Async
 * @author mosen <xu179@126.com>
 */
namespace tanshuimaoxian\queue;
class Async
{
	/**
	 * send
	 * @param $job string class@method
	 * @param $param mixed method($task,$param)
	 */
    public static function send($job, $param)
    {
        \Yii::$app->queue->send('queue|async', array(
            'job' => $job,
            'data' => $param,
            ));
    }
}