<?php


//THIS FILE IS USED FOR THESTING THE random_str() -function, it server no purpose in webmessage.link but is included for transparency and testing.
$lines = array();

for($i = 0; $i < 1000000;$i++){
	$new_word = random_str(512);

	/*
	if(($i % 1000) == 0){
		echo $i.PHP_EOL;
	}*/

	if(in_array($new_word, $lines)){
		echo "Lol bad algorithm";
		echo $i;
		exit();
	}
	array_push($lines, $new_word);
}

function random_str(
	int $length = 64,
	string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string {
	if ($length < 1) {
		throw new \RangeException("Length must be a positive integer");
	}
	$pieces = [];
	$max = mb_strlen($keyspace, '8bit') - 1;
	for ($i = 0; $i < $length; ++$i) {
		$pieces []= $keyspace[random_int(0, $max)];
	}
	return implode('', $pieces);
}
?>
