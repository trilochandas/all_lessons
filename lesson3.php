<?php 
// mt_srand(time());
$date = array(
	'0' =>mt_rand(-100, time()),  
	'1' =>mt_rand(-100, time()),  
	'2' =>mt_rand(-100, time()),  
	'3' =>mt_rand(-100, time()),  
	'4' =>mt_rand(-100, time()),  
);

print_r($date);
echo "<br>";
// наименьший день
$dataDay = array(date('N l', $date[0]), date('N l', $date[1]), date('N l', $date[2]), date('N l', $date[3]), date('N l', $date[4]));
echo "\n  в сгенерированном массиве наименьшим днем получился  : ";
echo min($dataDay[0], $dataDay[1], $dataDay[2], $dataDay[3], $dataDay[4]). '<br>';
// наибольший месяц
$dataMonth = array(date('m F', $date[0]), date('m F', $date[1]), date('m F', $date[2]), date('m F', $date[3]), date('m F', $date[4]));
echo "\n  в сгенерированном массиве наибольшим месяцем получился  : ";
echo max($dataMonth[0], $dataMonth[1], $dataMonth[2], $dataMonth[3], $dataMonth[4]). '<br>';
// сортировка массива
sort($date);
echo "\n Отсортированный массив по возрастанию :\n <br>";
print_r($date);
echo  '<br>';
// последний элемент массива
echo "\n С помощью функция для работы с массивами извлеките последний элемент массива в новую переменную \$selected C помощью функции date() выведите \$selected на экран в формате дд.мм.ГГ ЧЧ:ММ:СС: ";
$selected = array_pop($date);
echo date('d.m.Y H:i:s', $selected).  '<br>';

// часовая зона
echo "\n Моя часовая зона до изменения: ";
echo date_default_timezone_get(). '<br>';

echo "\n Проверка скрипта для себя))";
$script_tz = date_default_timezone_get();
if (strcmp($script_tz, ini_get('date.timezone'))){
    echo 'Временная зона скрипта отличается от заданной в INI-файле.';
} else {
    echo 'Временные зоны скрипта и настройки INI-файла совпадают. <br>';
}

echo "\n";
date_default_timezone_set('America/New_York');
echo "\n Моя часовая зона после изменения: ";
echo date_default_timezone_get();
echo "\n  <br>";
$script_tz = date_default_timezone_get();
if (strcmp($script_tz, ini_get('date.timezone'))){
    echo 'Временная зона скрипта отличается от заданной в INI-файле.';
} else {
    echo 'Временные зоны скрипта и настройки INI-файла совпадают.';
}

 ?>
 <script>
 for (var i = 0; i < 10; i++) { 
  setTimeout(function () { 
    console.log(i); 
  }, 0); 
}
</script>