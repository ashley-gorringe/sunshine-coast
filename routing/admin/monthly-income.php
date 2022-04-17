<?php

$paymentDates = $GLOBALS['database']->select('booking','paid_date',[
	'paid'=>1
]);

foreach ($paymentDates as $key => $paymentDate) {
	$paymentDates[$key] = date('Y',strtotime($paymentDate));
}

$paymentDates = array_unique($paymentDates);

if($_GET['year']){
	$lastJan = strtotime($_GET['year'].'-2-1 -1 day');
	$lastFeb = strtotime($_GET['year'].'-3-1 -1 day');
	$lastMar = strtotime($_GET['year'].'-4-1 -1 day');
	$lastApr = strtotime($_GET['year'].'-5-1 -1 day');
	$lastJun = strtotime($_GET['year'].'-6-1 -1 day');
	$lastJul = strtotime($_GET['year'].'-7-1 -1 day');
	$lastAug = strtotime($_GET['year'].'-8-1 -1 day');
	$lastSep = strtotime($_GET['year'].'-9-1 -1 day');
	$lastOct = strtotime($_GET['year'].'-10-1 -1 day');
	$lastNov = strtotime($_GET['year'].'-11-1 -1 day');
	$lastDec = strtotime(($_GET['year'] + 1).'-1-1 -1 day');

	$incomeJan = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-1-1',date('Y-m-d',$lastJan)],
			'paid'=>1
		]
	]);
	$incomeFeb = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-2-1',date('Y-m-d',$lastFeb)],
			'paid'=>1
		]
	]);
	$incomeMar = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-3-1',date('Y-m-d',$lastMar)],
			'paid'=>1
		]
	]);
	$incomeApr = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-4-1',date('Y-m-d',$lastApr)],
			'paid'=>1
		]
	]);
	$incomeMay = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-5-1',date('Y-m-d',$lastMay)],
			'paid'=>1
		]
	]);
	$incomeJun = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-6-1',date('Y-m-d',$lastJun)],
			'paid'=>1
		]
	]);
	$incomeJul = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-7-1',date('Y-m-d',$lastJul)],
			'paid'=>1
		]
	]);
	$incomeAug = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-8-1',date('Y-m-d',$lastAug)],
			'paid'=>1
		]
	]);
	$incomeSep = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-9-1',date('Y-m-d',$lastSep)],
			'paid'=>1
		]
	]);
	$incomeOct = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-10-1',date('Y-m-d',$lastOct)],
			'paid'=>1
		]
	]);
	$incomeNov = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-11-1',date('Y-m-d',$lastNov)],
			'paid'=>1
		]
	]);
	$incomeDec = $GLOBALS['database']->sum('booking','total_price',[
		'AND'=>[
			'paid_date[<>]'=> [$_GET['year'].'-12-1',date('Y-m-d',$lastDec)],
			'paid'=>1
		]
	]);

	$incomeMonths = array(
		'Jan' => $incomeJan / 100,
		'Feb' => $incomeFeb / 100,
		'Mar' => $incomeMar / 100,
		'Apr' => $incomeApr / 100,
		'May' => $incomeMay / 100,
		'Jun' => $incomeJun / 100,
		'Jul' => $incomeJul / 100,
		'Aug' => $incomeAug / 100,
		'Sep' => $incomeSep / 100,
		'Oct' => $incomeOct / 100,
		'Nov' => $incomeNov / 100,
		'Dec' => $incomeDec / 100,
	);

	$incomeYear = array_sum($incomeMonths);

	echo $GLOBALS['twig']->render('/admin/monthly-income.twig',['years'=>$paymentDates,'income'=>$incomeMonths,'incomeYear'=>$incomeYear,'active'=>true]);
}else{
	echo $GLOBALS['twig']->render('/admin/monthly-income.twig',['years'=>$paymentDates]);
}
?>
