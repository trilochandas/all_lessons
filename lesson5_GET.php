<?php
//GET
$news='Четыре новосибирские компании вошли в сотню лучших работодателей
Выставка университетов США: открой новые горизонты
Оценку «неудовлетворительно» по качеству получает каждая 5-я квартира в новостройке
Студент-изобретатель раскрыл запутанное преступление
Хоккей: «Сибирь» выстояла против «Ак Барса» в пятом матче плей-офф
Здоровое питание: вегетарианская кулинария
День святого Патрика: угощения, пивной теннис и уличные гуляния с огнем
«Красный факел» пустит публику на ночные экскурсии за кулисы и по закоулкам столетнего здания
Звезды телешоу «Голос» Наргиз Закирова и Гела Гуралиа споют в «Маяковском»';
$news=  explode("\n", $news);
echo '<br> Метод GET';
// проверка наличия параметра в передаче
	if (isset($_GET['id'])) {
		// количество элементов в массиве
		$quantity_news = count($news);
		if ($_GET['id'] <= $quantity_news){
			// вывод одной новости
			echo '<h4>Одна новость: </h4>';
			echo $news[$_GET['id']];
		} else if ($_GET['id'] > $quantity_news){
			// 	// вывод всех новостей
			echo '<h4>Все новости: </h4>';
			foreach ($news as $value) {
				echo $value. '<br>';
			}
		}
	} else {
		require_once('404.php'); 
		header("HTTP/1.0 404 Not Found");
			exit;
	}
?>
