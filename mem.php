<?php

	$mem = new memcache;
	$mem->connect('127.0.0.1', 11211);
	$mem->add("key", "abc");
	echo $mem->get("key");
	
	$redis = new redis();
	$redis->connect('127.0.0.1', 6379);
	$redis->set("hehe", "haha");
	echo $redis->get("hehe");
	
	// memched  key "设备ID" , "获取的mac", "生存时间2秒"
	// redis    key  MD5(设备ID -- Mac) , +1, "开始时间?"