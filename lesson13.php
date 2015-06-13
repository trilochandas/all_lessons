<h1>Lesson13.php - console.log()</h1>
<!-- zadanie 1 -->
<p>Задание 1</p>
<?
$name = 'Timur';
$age = 26;
echo 'Меня зовут '.$name.' Мне '.$age.' лет.';
unset($name, $age);
// var_dump($age) ; 
?>
<br>
<p>Задание 2</p>
<?
//zadanie 2
define('CITY', 'Evpatoria');
// var_dump(CITY);
if (CITY) {
    echo 'Мой город - ' . CITY . '!';
}
//CITY = Mayapur; zdes ya pitaus pomenyat konstantu
?>
<br>
<p>Задание 3</p>
<?
//zadanie 3
$book = array('title' => 'za predeli vaikunthi', 'autor' => 'Sanatana Goswami',
    'page' => '100');
echo 'Недавно я прочитал книгу ' . $book['title'] . ', написанную автором ' . $book['autor'] . ', я осилил
все ' . $book['page'] . ' страниц, мне она очень понравилась.';
?>
<br>
<p>Задание 4</p>
<?
//zadanie 4
$arr = array(
    array('title'  => 'Za predeli vaikunthi', 'author' => 'Sanatana Goswami','pages'=>'100'), 
    array('title'=>'sharanagati', 'author' =>'Bhaktivinod Thakur','pages'=>'40'),
);

 echo 'Недавно я прочитал книги ' .$arr[0]['title']. ' и ' .$arr[1]['title'].
         ', написанные соответственно авторами ' .$arr[0]['author']. 
    ' и ' .$arr[1]['author'].', я осилил в сумме ' .($arr[0]['pages']+$arr[1]['pages']). 
        ' страниц, не ожидал от себя подобного.';
?>

<script>
	console.log('Task #1');
	name = "Trilochan", age = 26;
	console.log('My name is ' + name + ' and my age is ' + age + ' years.');
	delete name;

	console.log('Task #2');
	const city = 'Mayapur';
	console.log('I live in the ' + city + ' city.');
	// const city = 'Dnipropetrovsk'
	// console.log(city);

	console.log('Task #3');
	var book = [];
	book["title"] = "Upadeshamrita";
	book["author"] = "Rupa Goswami";
	book["page"] = 20;
	console.log('Недавно я прочитал книгу ' + book['title'] + ', написанную автором: ' + book["author"] + ', я осилил все ' + book["page"] + ' страниц. Мне она очень понравилась');

	console.log('Task #4');
	var books = [{
			'title': 'Shikshashtaka',
			'author': 'Mahaprabhu',
			'pages': 2
		},
		{
			'title': 'Manah siksha',
			'author': 'Das Goswami',
			'pages': 20
		}
	];
	console.log('Недавно я прочитал книги ' + books[0]['title'] + ' и ' + books[1]['title'] + ', написанные соответственно авторами ' + books[0]['author'] + ' и ' + books[1]['author'] + ', я осилил в сумме ' + (books[0]['pages'] + books[1]['pages']) + ' страниц, не ожидал от себя подобного.');


</script>