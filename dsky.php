<?php
include('config.inc.php');
include('mysqlModel.class.php');
include('cache.php');
$mysql = new mysqlModel('data');
$cache = new cache();

if(isset($_POST['data']) && !empty($_POST['data'])) {
	$arrJson = json_decode($_POST['data'], true);
	$time = time();
	$id = isset($arrJson['id']) ? trim($arrJson['id']) : '';
	$mmac = isset($arrJson['mmac']) ? trim($arrJson['mmac']) : '';
	$rate = isset($arrJson['rate']) ? trim($arrJson['rate']) : '';
	$arrdata = isset($arrJson['data']) ? $arrJson['data'] : array();
	if(!empty($arrdata)) {
		$arrLog = array();
		foreach($arrdata as $arrval) {
			$mac = isset($arrval['mac']) ? trim($arrval['mac']) : '';
			$rssi = isset($arrval['rssi']) ? trim($arrval['rssi']) : '';
			$ts = isset($arrval['ts']) ? trim($arrval['ts']) : '';
			$tmc = isset($arrval['tmc']) ? trim($arrval['tmc']) : '';
			$tc = isset($arrval['tc']) ? trim($arrval['tc']) : '';
			$ds = isset($arrval['ds']) ? trim($arrval['ds']) : '';
			$rec = isset($arrval['rec']) ? trim($arrval['rec']) : '';
			$arrValues[] = "('{$id}', '{$mmac}', {$rate}, '{$mac}', '{$rssi}','{$ts}','{$tmc}','{$tc}','{$ds}','{$rec}','{$time}')";
		}
		$sql = "INSERT INTO `bro_data` (`id`, `mmac`, `rate`, `mac`, `rssi`, `ts`, `tmc`, `tc`, `ds`, `rec`, `time`) VALUES" .implode(",", $arrValues);
		$cache->setUserCache($id, $mac);
		$mysql->exec($sql);
	}	
}

