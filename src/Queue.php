<?php
/**
 * Queue
 * @author mosen <xu179@126.com>
 */
namespace tanshuimaoxian\queue;
use yii\base\Component;
use yii\redis\Connection;
class Queue extends Component
{
    // redis client
    public $redis = 'redis';

    /**
     * init
     */
    public function init()
    {
        parent::init();
        if (is_string($this->redis)) {
            $this->redis = \Yii::$app->get($this->redis);
        } elseif (is_array($this->redis)) {
            if (!isset($this->redis['class'])) {
                $this->redis['class'] = Connection::className();
            }
            $this->redis = \Yii::createObject($this->redis);
        }
        if (!$this->redis instanceof Connection) {
            throw new InvalidConfigException("Queue::redis must be either a Redis connection instance or the application component ID of a Redis connection.");
        }
    }

    /**
     * send
     * @param $queue string
     * @param $msg mixed
     */
    public function send($queue, $msg='')
    {
        $msg = json_encode($msg);
        return $this->redis->LPUSH($queue, $msg);
    }

    /**
     * receive
     * @param $queue string
     * @param $timeout int default 5
     */
    public function receive($queue, $timeout=5)
    {
        return $this->redis->BRPOP($queue, $timeout);
    }
}
