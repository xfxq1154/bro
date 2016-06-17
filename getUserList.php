<?php
include('cache.php');

$cache = new cache();

$result = $cache->Alllife();

echo "<pre />";
print_R($result);
/*
$value = $cache->getUserTime();
echo "<hr />";
echo "<pre />";
print_R($value);*/