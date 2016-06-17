<?php
/**
 * 数据缓存
*/
class cache {

    private $cache_pix;
    private $redis;
    private $mem;
    public function __construct()
    {
        $this->redis = new redis();
        $this->redis->connect('127.0.0.1', 6379);

        $this->mem = new memcache;
        $this->mem->connect('127.0.0.1', 11211);

    }

    /**
     * @param $id
     * @param $mmac
     * @param $mac
     */
    public function setUserCache($id, $mac) {
        $key = MD5($id.$this->cache_pix.$mac);
        //如果想看到实时用户的话 还是在redis里吧
        //先查看hash有没有这个
        //redis存最后一次出现的时间  memcache存第一次出现的时间
        //表来扫redis 扫到最后一次出现的时间 先算一下 跟开始时间的间隔 然后判断过期没
        //如果过期则写入数据库
        //需要最后一次出现的时间  需要第一次出现的时间
        $time = time();
        $this->mem->add($key, $time);
        $this->redis->HSET($id, $mac, $time);
        unset($time);
    }

    public function getUserList() {
        $id = "0082af06";
        return $this->redis->hkeys($id);
    }

    public function getUserTime() {
        $id = "0082af06";
        return $this->redis->HVALS($id);
    }

    public function getAll() {
        $id = "0082af06";
        return $this->redis->Hgetall($id);
    }

    public function Alllife() {
        $id = "0082af06";
        $data = $this->redis->Hgetall($id);
        $array = [];
        foreach($data as $key => $value){
            $mem_key = MD5($id.$this->cache_pix.$key);
            $start_time = $this->mem->get($mem_key);
            $array[$key] = $value - $start_time;
        }
        return $array;
    }
}