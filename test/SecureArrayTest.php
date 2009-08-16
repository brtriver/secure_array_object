<?php
require(dirname(__FILE__). '/../SecureArrayObject.php');

$str = '<script>alert("test")</script>';
$ok_str = '&lt;script&gt;alert(&quot;test&quot;)&lt;/script&gt;';

$earray = secure_array();
$earray['attack'] = $str;
echo str_repeat("#", 50) . PHP_EOL;
echo "# SecureArrayObject Test" . PHP_EOL;
echo str_repeat("#", 50) . PHP_EOL;
echo "Escape the string by accessing the property  ... " . (($earray['attack'] === $ok_str)? "OK" : "NG") . PHP_EOL;
foreach ($earray as $k => $v) {
  echo "Escape the string by accessing the iterator  ... " . (($v === $ok_str)? "OK" : "NG") . PHP_EOL;
}

$earray = secure_array();
$earray['attack'] = array('test' => $str);
echo "Escape the string in array by accessing the property  ... " . (($earray['attack']['test'] === $ok_str)? "OK" : "NG") . PHP_EOL;
foreach ($earray as $k => $v) {
  foreach ($v as $k2 => $v2) {
	echo "Escape the string in array by accessing the iterator  ... " . (($v2 === $ok_str)? "OK" : "NG") . PHP_EOL;
  }
}

$earray = secure_array();
$earray['attack'] = $str;
echo "Unescape the string by calling the unescape method  ... " . (($earray->unescape('attack') === $str)? "OK" : "NG") . PHP_EOL;

unset($str);
$str = secure_array();
$str['hoge'] = secure_array();
$str['hoge'][] = '<a>';
$str['hoge'][] = '<a>';
$str['hoge'][] = '<a>';
$ok_str = '&lt;a&gt;';
foreach ($str as $k => $v) {
  foreach ($v as $k2 => $v2) {
    echo "Escape the string in array by accessing the iterator  ... " . (($v2 === $ok_str)? "OK" : "NG") . PHP_EOL;
  }
}
