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
//     if (isset($_SESSION))
// {
//     session_unset();
//     session_destroy();
// }

// проверка массива GET на наличие парметра del на удаление новости
if (isset($_GET['del'])) {
    unset($_SESSION['history'][$_GET['del']]);
}
// var_dump($_POST);
// проверка на наличие параметров в форме
if (isset($_POST['main_form_submit'])){
    // проверка на наличие знаков у параметров формы
    if (empty($_POST['title']) && empty($_POST['price']) && empty($_POST['email']) &&  empty($_POST['seller_name'])&&  empty($_POST['phone']) &&  empty($_POST['location_id'])) {
        echo '<p style="color:red;">Введите все данные</p>';
        } else {
        // перезапись объявления
        if (isset($_GET['id'])){
            $_SESSION['history'][$_GET['id']] = $_POST;
            header('Location: ./lesson6.php');  
        } else{
        // присваиваем сессии данные из POST
        $_SESSION['history'][]=$_POST;
        }
    }
}
// заполнение формы данными из GET
if (isset($_GET['id'])){
    $id = (int) $_GET['id'];
    $title=$_SESSION['history'][$id]['title'];
    $price=$_SESSION['history'][$id]['price'];
    $seller_name=$_SESSION['history'][$id]['seller_name'];
    $description=$_SESSION['history'][$id]['description'];
    $email=$_SESSION['history'][$id]['email'];
    $phone=$_SESSION['history'][$id]['phone'];
    $location_id=$_SESSION['history'][$id]['location_id'];
    $metro_id=$_SESSION['history'][$id]['metro_id'];
    $category_id=$_SESSION['history'][$id]['category_id'];
    $private=$_SESSION['history'][$id]['private'];
    if (isset($_SESSION['history'][$id]['allow_mails'])){
        if($_SESSION['history'][$id]['allow_mails'] == 1){
            $allow_mails = 'checked';
        }
    }
        else{
            $allow_mails = '';
    }
    // добавление значений для пустой формы
} else{
    $title='';
    $price='';
    $seller_name='';
    $description='';
    $phone='';
    $email='';
    $allow_mails='';
    $location_id='';
    $metro_id='';
    $category_id='';
    $private='';
}
?>
<form  method="POST">
    <div class="form-row-indented"> 
        <label class="form-label-radio">
        <input type="radio" <?php if ($private == 1 ) echo 'checked'; ?> value="1" name="private">Частное лицо</label>
        <label class="form-label-radio">
        <input type="radio" <?php if ($private == 0 ) echo 'checked'; ?> value="0" name="private">Компания</label>
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
        <div class="vas-submit-button pull-left"> <span class="vas-submit-border"></span> <span class="vas-submit-triangle"></span> <input type="submit" value="Далее" id="form_submit" name="main_form_submit" class="vas-submit-input"> </div>
    </div>
</form>
<?php 

echo '<p style="font-size:24px; margin: 5px;">Все объявления:</p>';
// вывод всех объявлений
foreach ($_SESSION['history'] as $key => $value) {
        echo "<a href='{$_SERVER['SCRIPT_NAME']}?id=$key'>" . $value['title'] . "</a> | <span>" . $value['price'] . "</span> | <span>" . $value['seller_name'] . "</span> | <a href='{$_SERVER["SCRIPT_NAME"]}?del=$key'>Удалить</a><br>";
}       
?>