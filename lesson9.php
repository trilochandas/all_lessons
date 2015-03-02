<?php
header('Content-Type: text/html; charset=utf-8');

require('Smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = true;

$projectroot = $_SERVER['DOCUMENT_ROOT'];
$smarty_dir = $projectroot . '/smarty/' ;

$smarty->template_dir = $smarty_dir . 'templates';
$smarty->compile_dir = $smarty_dir . 'templates_c';
$smarty->cache_dir = $smarty_dir . 'cache';
$smarty->config_dir = $smarty_dir . 'configs';

// variables 
$citys = array(
    'selected' => 'Выберите город',
    641780 => 'Новосибирск',
    641490 => 'Барабинск',
    641510 => 'Бердск',
); 
$underground = array(
   'selected' => 'Выберите метро',
   2028 => 'Берёзовая роща',
   2018 => 'Гагаринская',
   2017 => 'Заельцовская',
);
$categorys['selected'] = 'Выберите категорию';
$categorys['Транспорт'] = array(
    9 => 'Автомобили с пробегом',
    109 => 'Новые автомобили'
);
$categorys['Недвижимость'] = array(
    23 => 'Комнаты',
    24 => 'Квартиры',
);

$smarty->assign('citys', $citys);
$smarty->assign('underground', $underground);
$smarty->assign('categorys', $categorys);

if (!file_exists('advert.txt')){
    fopen('advert.txt', 'w') or die("Unable to open/create file!");
}

// переменная для работы с файлом
$current = file_get_contents('advert.txt');
$current = unserialize($current);
$smarty->assign('current' ,$current);

$smarty->assign('error', '');


function put_serialized_content($array){
    $array = serialize($array);
    file_put_contents('advert.txt', $array);
    header('Location: ' . $_SERVER['PHP_SELF']); 
}

// mysql
$config = array(
        'DB_HOST'            =>  'localhost',
        'DB_USERNAME'   =>  'root',
        'DB_PASSWORD'  =>  '123'
    );

function connect($host = 'localhost', $username, $password, $db = '')
{
    $conn = mysql_connect($host, $username, $password);

    if (!empty($db)){
        mysql_select_db($db, $conn);
    }

    return $conn;
}

function query($query, $conn)
{
    mysql_query('SET NAMES utf8');
    $results = mysql_query($query, $conn);

    if ( $results ) {
        $rows = array();
        while($row = mysql_fetch_assoc($results)) {
            $rows[] = $row;
        }
        return $rows;
    }

    return false;
}

$conn = connect($config['DB_HOST'], $config['DB_USERNAME'], $config['DB_PASSWORD'], 'xaver');
$results = query('SELECT city, city_index FROM citys', $conn);
$smarty->assign('results' ,$results);


 // mysql 

// обработка формы. запись перезапись
if (isset($_POST['main_form_submit'])){
    // проверка на наличие знаков у параметров формы
    if (empty($_POST['title']) || empty($_POST['price']) ||  empty($_POST['seller_name']) || empty($_POST['phone'])) {
        $smarty->assign('error', 'Введите все данные');
        } else {
            // перезапись объявления
            if (isset($_GET['id'])){
                $current[$_GET['id']] = $_POST;
                put_serialized_content($current);                
                // exit; 
           } else {
            //  добавление объявления
                $advert=$_POST;
                $current[] = $advert;
                put_serialized_content($current);
                // exit; 
        }
    }
}


// заполнение формы
if (isset($_GET['id'])){
    $id = (int) $_GET['id'];
    $current = $current[$id];
    foreach ($current as $key => $value) {
     $$key = $value;
    }
    if (isset($current['allow_mails'])){
        if($current['allow_mails'] == 1){
            $allow_mails = 'checked';
        }
    }
        else{
            $allow_mails = '';
    }
// пустые переменные для пустой формы
} else {
    $title='';
    $price='';
    $seller_name='';
    $description='';
    $phone='';
    $email='';
    $allow_mails='';
    $private='';
    $location_id='';
    $metro_id='';
    $category_id='';
}

$smarty->assign('private', $private);
$smarty->assign('seller_name', $seller_name);
$smarty->assign('email', $email);
$smarty->assign('allow_mails', $allow_mails);
$smarty->assign('phone', $phone);
$smarty->assign('location_id', $location_id);
$smarty->assign('metro_id', $metro_id);
$smarty->assign('category_id', $category_id);
$smarty->assign('title', $title);
$smarty->assign('description', $description);
$smarty->assign('price', $price);


//  удаление новости
if (isset($_GET['del'])) {
    unset($current[$_GET['del']]);
    put_serialized_content($current);
    // exit;
}

$smarty->display('lesson9.tpl');

?>