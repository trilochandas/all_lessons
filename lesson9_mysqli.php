<?php
header('Content-Type: text/html; charset=utf-8');

require('Smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$projectroot = $_SERVER['DOCUMENT_ROOT'];
$smarty_dir = $projectroot . '/smarty/' ;

$smarty->template_dir = $smarty_dir . 'templates';
$smarty->compile_dir = $smarty_dir . 'templates_c';
$smarty->cache_dir = $smarty_dir . 'cache';
$smarty->config_dir = $smarty_dir . 'configs';

// variables 


$categorys['selected'] = 'Выберите категорию';
$categorys['Транспорт'] = array(
    9 => 'Автомобили с пробегом',
    109 => 'Новые автомобили'
);
$categorys['Недвижимость'] = array(
    23 => 'Комнаты',
    24 => 'Квартиры',
);

$smarty->assign('error', '');

// mysql
$config = array(
        'DB_HOST'            =>  'localhost',
        'DB_USERNAME'   =>  'root',
        'DB_PASSWORD'  =>  '123'
    );
// connect
$link = mysqli_connect( 
            'localhost',  /* Хост, к которому мы подключаемся */ 
            'root',       /* Имя пользователя */ 
            '123',   /* Используемый пароль */ 
            'xaver');     /* База данных для запросов по умолчанию */ 

if (!$link) { 
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error()); 
   exit; 
} 

// query
function query_i($link, $query, $in_arr = false){
    mysqli_set_charset($link, "utf8");
    $result = mysqli_query($link, $query);
    if (!$result) { 
        die('connecting error '. mysql_error()); 
    } else {
        $rows = array();
        if (!$in_arr) {
            while($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        } else {
            $rows = mysqli_fetch_assoc($result);
        } 
    }
    mysqli_free_result($result); 
    return $rows;
}

// put content
function put_content($conn, $query) {
    $results = mysqli_query($conn, $query);
    header('Location: ' . $_SERVER['PHP_SELF']); 
        if ( !$results ) {
            die('updating error '. mysql_error());
        }
}

// output table with adverts
function output_adverts_table(){
    $out_text =  '<table>';
    $out_text .= '<tr>';
    $out_text .= '<td>Название объявления</td>';
    $out_text .= '<td>Цена</td>';
    $out_text .= '<td>Имя продавца</td>';
    $out_text .= '<td>Удалить</td>';
    $out_text .= '</tr>';

    global $advert_output_table;

    foreach ($advert_output_table as $key => $value) {
       $out_text .= "<tr>";
       $out_text .= "<td><a href='{$_SERVER['SCRIPT_NAME']}?id={$value['id']}'>" . $value['title'] . "</a></td>";
       $out_text .= "<td>{$value['price']}</td>";
       $out_text .= "<td>{$value['seller_name']}</td>";
       $out_text .= "<td><a href='{$_SERVER["SCRIPT_NAME"]}?del={$value['id']}'>Удалить</a></td>";
       $out_text .= "</tr>";
    }

    $out_text .= "</table>";

    echo $out_text;
}

// output select_meta
$select_meta = query_i($link, 'SELECT * FROM select_meta');
$citys = json_decode($select_meta[0]['options'], true);
$metro = json_decode($select_meta[1]['options'], true);
$smarty->assign('citys' ,$citys);
$smarty->assign('metro1' ,$metro);

// обработка формы. запись перезапись
if (isset($_POST['main_form_submit'])){
    // проверка на наличие знаков у параметров формы
    if (empty($_POST['title']) || empty($_POST['price']) ||  empty($_POST['seller_name']) || empty($_POST['phone'])) {
        $smarty->assign('error', 'Введите все данные');
        } else {
            // перезапись объявления
            if (isset($_GET['id'])){
                $id = $_GET['id'];
                foreach ($_POST as $key => $value) {
                    $$key = $value;
                }
                $allow_mails = ( isset($allow_mails) ) ? 1 : 0;
                put_content($link, "UPDATE adverts SET private = '$private', seller_name = '$seller_name', email = '$email', allow_mails = '$allow_mails', phone = '$phone', city = '$city', metro = '$metro_all', title = '$title', description = '$description', price = '$price' WHERE id = '$id' ");
           } else {
            //  добавление объявления
                foreach ($_POST as $key => $value) {
                    $$key = $value;
                }
                put_content($link, " INSERT INTO adverts (private, seller_name, email, allow_mails, phone, city, metro,  title, description, price)  VALUES ('$private', '$seller_name', '$email', $allow_mails, '$phone', '$city', '$metro_all', '$title', '$description', '$price')", $conn);
        }
    }
}



// заполнение формы
if (isset($_GET['id'])){
    $id = (int) $_GET['id'];
    $data = query_i($link, "SELECT * FROM adverts WHERE id = $id ", true);
    foreach ($data as $key => $value) 
        $$key = $value;
    $allow_mails = ( $allow_mails == 1) ? 'checked' : '';
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
        $city='';
        $metro1='';
        $category_id='';
}

$smarty->assign('private', $private);
$smarty->assign('seller_name', $seller_name);
$smarty->assign('email', $email);
$smarty->assign('allow_mails', $allow_mails);
$smarty->assign('phone', $phone);
$smarty->assign('city', $city);
$smarty->assign('metro', $metro);
$smarty->assign('title', $title);
$smarty->assign('description', $description);
$smarty->assign('price', $price);


//  удаление новости
if (isset($_GET['del'])) {
    $del = $_GET['del'];
    put_content($link, "DELETE FROM adverts WHERE id = $del ");
}

// вывод всех объявлений
$advert_output_table = query_i($link, 'SELECT * FROM adverts');
$smarty->assign('advert_output_table', $advert_output_table);

$smarty->display('lesson9_mysqli.tpl');

?>