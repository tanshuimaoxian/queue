<?php
/**
 * Log
 * @author mosen <xu179@126.com>
 */
namespace tanshuimaoxian\queue;
class Log
{
	/**
	 * save
	 * @param $job string class@method
	 * @param $param mixed method($task,$param)
	 */
    public static function save($job, $param)
    {
        \Yii::$app->queue->send('queue|log', array(
            'job' => $job,
            'data' => $param,
            ));
    }
}