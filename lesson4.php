<?php 
$ini_string='
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
';
$bd=  parse_ini_string($ini_string, true);
// print_r($bd);
?>
<!-- <div style="float:left; width: 400px; border: 1px solid #333; padding: 10px;"> -->
<?php
echo "<h3>Содержине корзины:</h3>";
// функция разбора
function parse_basket($basket){
	foreach ($basket as $name => $params) {
		$discount = discount($name, $params['цена'], $params['количество заказано'], $params['diskont']);
		
		echo 'Вы заказали: <strong>'.$name. '</strong> <br> Цена товара: ' .$params['цена']. ' руб'. '<br> Количество: ' .$params['количество заказано']. ' штук' .'<br>Всего на складе: '.$params['осталось на складе']. ' штук'. '<br> Ваша скидка (diskont) : '.$discount['skidka']. '<br>Цена товара со скидкой: ' .$discount['price_one_disckount']. ' руб'. '<br> Стоимость (по наличию): ' .$discount['price-total']. ' руб';
		echo "<br><br>";
		// echo '<br> Всего позиций: ' .$name. ' штук';
	}
}
// функция подсчета скидки
function discount($name, $price, $amount, $diskont){
	$skidka = substr($diskont, 7, 2);
	$price_with_discount_per_item = $price - ($price * ($skidka *10) / 100);
	$total_price_all_items_width_discount = $amount * $price_with_discount_per_item;
	return array(
		'skidka'=>$skidka."0%",
		'price_one_disckount'=>$price_with_discount_per_item,
		'price-total'=>$total_price_all_items_width_discount
		);
}
// если не оказалось на складе и общее количество цены, количества.
function itogo($basket){
	static $kol_naimenovaniy;
	static $kolichestvo;
	static $total_price;
	foreach ($basket as $name => $params) {
		// вызываем функцию подсчета скидки
		$discount = discount($name, $params['цена'], $params['количество заказано'], $params['diskont']);
		// задаем переменные
		$kol_naimenovaniy = $kol_naimenovaniy + func_num_args();
		$kolichestvo = $kolichestvo + $params['количество заказано']; 
		$total_price = $total_price + $discount['price-total'];
		// uznaem obshee kolichestvo
		if ($params['количество заказано']>$params['осталось на складе']) {
			echo 'Товар: <strong>' .$name. '</strong>. Вы заказали <strong>'. $params['количество заказано']. ' штук</strong>. Всего на складе: <strong>'  .$params['осталось на складе'].  ' штук</strong> <br>';
		}		
	}
	echo "<br>";
	echo 'Всего наименовний заказано: ' .$kol_naimenovaniy. ' позиции';
	echo '<br>Общее количество товара: ' .$kolichestvo. ' штук';
	echo '<br>Общая сумма заказа: ' .$total_price. ' руб';
	// skidka dlya velosipeda esli zakazano 3 stuki i bolshe
		if ($name='игрушка детская велосипед' && $params['количество заказано']>=3) {
			echo '<br><br> Вы заказали: игрушка детская велосипед, 3 штуки или больше. Поздравляю. Скидка  30% на велосипеды.';
			// присваиваем скидку для велосипеда
			$discount['skidka'] = 3;
		}
}
// if ($params['осталось на складе']<$params['количество заказано']) {
// 	echo 'Нужного количества товара не оказалось на складе';
// }
parse_basket($bd); // начало
echo "\n";
itogo($bd); // моя функция kolichestvo
 ?>
<!-- </div>	 -->
<!-- <div style="float:left; margin-left: 40px;  width: 200px; border: 1px solid #333; padding: 10px;"> -->
<!-- </div> -->