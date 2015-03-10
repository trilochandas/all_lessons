<?php
header('Content-Type: text/html; charset=utf-8');

// variables

$error_output = '';


$config = array(
        'DB_HOST'            =>  'localhost',
        'DB_USERNAME'   =>  'root',
        'DB_PASSWORD'  =>  '123'
);

// доделать
$categorys['selected'] = 'Выберите категорию';
$categorys['Транспорт'] = array(
    9 => 'Автомобили с пробегом',
    109 => 'Новые автомобили'
);
$categorys['Недвижимость'] = array(
    23 => 'Комнаты',
    24 => 'Квартиры',
);


// connect
function connect($host = 'localhost', $username, $password, $db = '')
{
    $conn = mysql_connect($host, $username, $password);

    if (!empty($db)){
        mysql_select_db($db, $conn);
    }

    return $conn;
}

// variables for connect to database
$conn = connect($config['DB_HOST'], $config['DB_USERNAME'], $config['DB_PASSWORD'], 'xaver');

// query
function query($query, $conn, $in_arr = false )
{
    mysql_query('SET NAMES utf8');
    $results = mysql_query($query, $conn);
    if (!$results)  return false;

    $rows = array();
    if (!$in_arr) {
        while($row = mysql_fetch_assoc($results)) {
            $rows[] = $row;
        }
    } else {
        $rows = mysql_fetch_assoc($results);
    }    
    return $rows;  
}

// put content
function put_content($query, $conn) {
    mysql_query('SET NAMES utf8');
    $results = mysql_query($query, $conn);
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
$select_meta = query('SELECT * FROM select_meta', $conn);

 // mysql 

// обработка формы. запись перезапись
if (isset($_POST['main_form_submit'])){
    // проверка на наличие знаков в полях формы
    if (empty($_POST['title']) || empty($_POST['price']) ||  empty($_POST['seller_name']) || empty($_POST['phone'])) {
        $error_output = 'Введите все данные';
        } else {
            // перезапись объявления
            if (isset($_GET['id'])){
                $id = $_GET['id'];
                var_dump($_POST);
                foreach ($_POST as $key => $value) {
                    $$key = $value;
                }
                $allow_mails = ( isset($allow_mails) ) ? 1 : 0;
                put_content("UPDATE adverts SET private = '$private', seller_name = '$seller_name', email = '$email', allow_mails = '$allow_mails', phone = '$phone', city = $city, metro = $metro, title = '$title', description = '$description', price = '$price' WHERE id = '$id' ", $conn);
           } else {
            //  добавление объявления
                var_dump($_POST);
                foreach ($_POST as $key => $value) {
                    $$key = $value;
                }
                put_content(" INSERT INTO adverts (private, seller_name, email, allow_mails, phone, city, metro, title, description, price)  VALUES ('$private', '$seller_name', '$email', $allow_mails, '$phone', '$city', '$metro', '$title', '$description', '$price')", $conn);
        }
    }
}


// заполнение формы
if (isset($_GET['id']) && (int) $_GET['id'] !== 0){
    $id = (int) $_GET['id'];
    $data = query("SELECT * FROM adverts WHERE id={$id} ", $conn, true);
    var_dump($data);
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
    $location_id='';
    $metro_id='';
    $category_id='';
}

//  удаление новости
if (isset($_GET['del'])) {
    $del = $_GET['del'];
    put_content("DELETE FROM adverts WHERE id = '$del' ", $conn);
}



// вывод всех объявлений
$advert_output_table = query('SELECT * FROM adverts', $conn);

include_once 'lesson9_my.tmpl.php'

?>