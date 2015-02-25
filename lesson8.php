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
// $smarty->assign('selected_city', $citys['selected']);
$smarty->assign('underground', $underground);
// $smarty->assign('selected_underground', $underground['selected']);
$smarty->assign('categorys', $categorys);
// $smarty->assign('selected_categorys', $categorys['selected']);


// переменная для работы с файлом
$current = file_get_contents('advert.txt');
$current = unserialize($current);
$smarty->assign('current' ,$current);

// обработка формы. запись перезапись
if (isset($_POST['main_form_submit'])){
    // проверка на наличие знаков у параметров формы
    if (empty($_POST['title']) || empty($_POST['price']) ||  empty($_POST['seller_name']) || empty($_POST['phone'])) {
        $smarty->assign('error', 'Введите все данные');
        } else {
            // перезапись объявления
            if (isset($_GET['id'])){
                $current[$_GET['id']] = $_POST;
                $current = serialize($current);
                file_put_contents('advert.txt', $current);
                header('Location: ' . $_SERVER['PHP_SELF']); 
                exit; 
           } else {
            //  добавление объявления
            if ( !is_null(file_get_contents('advert.txt'))) {
                $advert=$_POST;
                $current = file_get_contents('advert.txt');
                $current = unserialize($current);
                $current[] = $advert;
                $current = serialize($current);
                file_put_contents('advert.txt', $current);
            // если advert.txt пустой
            } else {
                // $advert=$_POST;
                $current = array();
                $current[] = $advert;
                $current = serialize($current);
                file_put_contents('advert.txt', $current); 
            }
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

$smarty->assign('checked', 'checked');
$smarty->assign('private', $private);
$smarty->assign('seller_name', $seller_name);
$smarty->assign('email', $email);
$smarty->assign('allow_mails', $allow_mails);
$smarty->assign('phone', $phone);

$smarty->assign('title', $title);
$smarty->assign('description', $description);
$smarty->assign('price', $price);


//  удаление новости
if (isset($_GET['del'])) {
    unset($current[$_GET['del']]);
    $current = serialize($current);
    file_put_contents('advert.txt', $current);
    header('Location: ' . $_SERVER['PHP_SELF']); 
    exit;
}

$smarty->display('lesson8.tpl');

?>