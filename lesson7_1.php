<?php 
header('Content-Type: text/html; charset=utf-8');
$citys = array(
    1 => array ( 'city' => 'Новосибирск',  '641780' ),
    2 => array( 'city' => 'Барабинск',  '641490' ),
    3 => array( 'city' => 'Бердск',  '641510' )
); 
$underground = array(
    1 => array ( 'station' => 'Берёзовая роща', '2028' ),
    2 => array( 'station' => 'Гагаринская', '2018' ),
    3 => array( 'station' => 'Заельцовская', '2017' )
);
$categorys_auto = array(
    1 => array ( 'category' => 'Автомобили с пробегом', '9' ),
    2 => array( 'category' => 'Новые автомобили', '109' )
);
$categorys_room = array(
    1 => array( 'category' => 'Комнаты', '23' ),
    2 => array( 'category' => 'Квартиры', '24' )
);
    session_start();
    $advert = array();

// проверка массива GET на наличие парметра del на удаление новости
if (isset($_GET['del'])) {
    $current = $_COOKIE['advert'];
    $current = unserialize($current);
    unset($current[$_GET['del']]);
    $current = serialize($current);
    setcookie('advert', $current, time() + 3600*24*7);
    header('Location: ' . $_SERVER['PHP_SELF']); 
    exit;
}
// проверка на наличие параметров в форме
if (isset($_POST['main_form_submit'])){
    // проверка на наличие знаков у параметров формы
    if (empty($_POST['title']) || empty($_POST['price']) ||  empty($_POST['seller_name']) ||  empty($_POST['phone'])) {
        echo '<p style="color:red;">Введите все данные</p>';
    } else {
        // перезапись объявления
        if (isset($_GET['id']) && !empty($_GET['id'])){
            $current = $_COOKIE['advert'];
            $current = unserialize($current);
            $current[$_GET['id']] = $_POST;
            $current = serialize($current);
            setcookie('advert', $current, time() + 3600*24*7);
            header('Location: ' . $_SERVER['PHP_SELF']);  
            exit();
        } else {
        // присваиваем данные из POST в COOKIE
        $advert=$_POST;
        $current = $_COOKIE['advert'];
        $current = unserialize($current);
        $current[] = $advert;
        $current = serialize($current);
        setcookie('advert', $current, time() + 3600*24*7);
        header('Location: ' . $_SERVER['PHP_SELF']);  
        exit();
        }
    }
}


// заполнение формы данными из GET
if (isset($_GET['id']) && !empty($_GET['id'])){
    $id = (int) $_GET['id'];
    $advert = $_COOKIE['advert'];
    $advert = unserialize($advert);
    $advert = $advert[$id];
    foreach ($advert as $key => $value) {
     $$key = $value;
    }
    if (isset($advert['allow_mails'])){
        if($advert['allow_mails'] == 1){
            $allow_mails = 'checked';
        }
    }
        else{
            $allow_mails = '';
    }
    // добавление значений для пустой формы
} else{
    // $current = file_get_contents('advert.txt');
    // $current = unserialize($current);
    // foreach ($current as $key => $value) {
    //  $$key = '';    
    // }
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
?>
<style>
form{width: 500px;}
input:not([type="radio"]), select, textarea {
    float: right;
}
input{
    margin: 5px 0;
}
.form-row {
    margin: 10px 0;
    clear: both;
}

</style>
<form  method="POST">
    <div class="form-row-indented"> 
        <label class="form-label-radio"><input type="radio" <?php if ($private == 1 ) echo 'checked'; ?> value="1" name="private">Частное лицо</label> 
        <label class="form-label-radio"><input type="radio" <?php if ($private == 0 ) echo 'checked'; ?> value="0" name="private">Компания</label> 
    </div>
    <div class="form-row"> <label for="fld_seller_name" class="form-label"><b id="your-name">Ваше имя</b></label>
        <input type="text" maxlength="40" class="form-input-text" value="<?php echo $seller_name; ?>" name="seller_name" id="fld_seller_name">
    </div>
    <div class="form-row"> <label for="fld_email" class="form-label">Электронная почта</label>
        <input type="text" class="form-input-text" value="<?php echo $email; ?>" name="email" id="fld_email">
    </div>
    <div class="form-row-indented"> 
        <label class="form-label-checkbox" for="allow_mails">
            <input type="checkbox" <?php echo $allow_mails; ?>  value="1" name="allow_mails" id="allow_mails" class="form-input-checkbox"><span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span>
        </label> 
    </div>
    <div class="form-row"> <label id="fld_phone_label" for="fld_phone" class="form-label">Номер телефона</label> <input type="text" class="form-input-text" value="<?php echo $phone; ?>" name="phone" id="fld_phone">
    </div>
    <div id="f_location_id" class="form-row form-row-required"> 
    <label for="region" class="form-label">Город</label> 
    <?php
        echo '<select name="location_id" >';
        echo '<option selected value="">-- Выберите город --</option>';
        foreach ($citys as $numb => $one_city) {
            if ($location_id == $one_city['0']) {
                $selected = 'selected ';
            } else {
                $selected ="";
            }
            echo '<option ' . $selected . ' value="' . $one_city['0'] . '">' . $one_city['city'] . '</option>';
        }
        echo '</select>';
    ?>
    <div id="f_metro_id"> 
    <br>
    <?php 
        echo '<label for="metro_id" class="form-label">Метро</label>'; 
        echo '<select name="metro_id" > id="metro_id"> ';
        echo '<option value="">-- Выберите станцию метро --</option>';
        foreach ($underground as $numb => $one_station) {
            if ($metro_id == $one_station['0']) {
                $selected = 'selected ';
            } else {
                $selected ="";
            }
            echo '<option ' . $selected . ' value="' . $one_station['0'] . '">' . $one_station['station'] . '</option>';
        }
        echo '</select>';
    ?>
    </div>
    <div class="form-row"> 
    <?php
        echo '<label for="fld_category_id" class="form-label">Категория</label>'; 
        echo '<select title="Выберите категорию объявления" name="category_id" > ';
        echo '<option value="">-- Выберите категорию --</option>';
        echo '<optgroup label="Транспорт">';
        foreach ($categorys_auto as $numb => $one_category) {
            if ($category_id == $one_category['0']) {
                $selected = 'selected ';
            } else {
            $selected ="";
        }
        echo '<option ' . $selected . ' value="' . $one_category['0'] . '">' . $one_category['category'] . '</option>';
        }
        echo '</optgroup>';
        echo '<optgroup label="Недвижимость">';
         foreach ($categorys_room as $numb => $one_category) {
            if ($category_id == $one_category['0']) {
                $selected = 'selected ';
            } else {
            $selected ="";
        }
        echo '<option ' . $selected . ' value="' . $one_category['0'] . '">' . $one_category['category'] . '</option>';
        }
        echo '</optgroup>';
        echo '</select>';
    ?>
    </div>
    <div id="f_title" class="form-row f_title"> 
        <label for="fld_title" class="form-label">Название объявления</label> 
        <input type="text" maxlength="50" class="form-input-text-long" value="<?php echo $title; ?>" name="title" id="fld_title"> 
    </div>
    <div class="form-row"> 
        <label for="fld_description" class="form-label" id="js-description-label">Описание объявления</label> 
        <textarea maxlength="3000" name="description" id="fld_description" class="form-input-textarea"><?php echo $description; ?></textarea> 
    </div>
    <div id="price_rw" class="form-row rl"> 
        <label id="price_lbl" for="fld_price" class="form-label">Цена</label> 
        <input type="text" maxlength="9" class="form-input-text-short" value="<?php echo $price; ?>" placeholder="0" name="price" id="fld_price">&nbsp;<span id="fld_price_title">руб.</span> <!-- <a class="link_plain grey right_price c-2 icon-link" id="js-price-link" href="/info/pravilnye_ceny?plain"><span>Правильно указывайте цену</span></a> --> 
    </div>

    <div class="form-row-indented form-row-submit b-vas-submit" id="js_additem_form_submit">
        <div class="vas-submit-button pull-left"> <span class="vas-submit-border"></span> <span class="vas-submit-triangle"></span> <input type="submit" value="Далее" d="form_submit" name="main_form_submit" class="vas-submit-input"> </div>
    </div>
</form>
<?php 

echo '<p style="font-size:24px; margin: 5px;">Все объявления:</p>';
// вывод всех объявлений
$advert = $_COOKIE['advert'];
$advert = unserialize($advert);
foreach ($advert as $key => $value) {
        echo "<a href='{$_SERVER['SCRIPT_NAME']}?id=$key'>" . $value['title'] . "</a> | <span>" . $value['price'] . "</span> | <span>" . $value['seller_name'] . "</span> | <a href='{$_SERVER["SCRIPT_NAME"]}?del=$key'>Удалить</a><br>";
}       
// var_dump($_COOKIE['advert']);
// var_dump($advert);
?>