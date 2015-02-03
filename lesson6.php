<?php 
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
}
?>
<form  method="POST">
<!--     <div class="form-row-indented"> <label class="form-label-radio"><input type="radio" checked="" value="1" name="private">Частное лицо</label> <label class="form-label-radio"><input type="radio" value="0" name="private">Компания</label> </div> -->
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
    <select title="Выберите Ваш город" name="location_id" id="region" class="form-input-select">
            <option selected value="">-- Выберите город --</option>
            <option class="opt-group" disabled="disabled">-- Города --</option>
            <option  <?php if ($location_id == 641780 ) echo 'selected'; ?> value="641780">Новосибирск</option>   
            <option  <?php if ($location_id == 641490 ) echo 'selected'; ?> value="641490">Барабинск</option>   
            <option  <?php if ($location_id == 641510 ) echo 'selected'; ?> value="641510">Бердск</option>
    </select> 
    <div id="f_metro_id"> 
        <select title="Выберите станцию метро" name="metro_id" > 
            <option value="">-- Выберите станцию метро --</option>
            <option <?php if ($metro_id == 2028 ) echo 'selected'; ?> value="2028">Берёзовая роща</option>
            <option <?php if ($metro_id == 2018 ) echo 'selected'; ?> value="2018">Гагаринская</option>
            <option <?php if ($metro_id == 2017 ) echo 'selected'; ?> value="2017">Заельцовская</option>
        </select>
    </div>
    <div class="form-row"> 
        <label for="fld_category_id" class="form-label">Категория</label> 
        <select title="Выберите категорию объявления" name="category_id" > 
            <option value="">-- Выберите категорию --</option>
            <optgroup label="Транспорт">
                <option <?php if ($category_id == 9 ) echo 'selected'; ?>  value="9">Автомобили с пробегом</option>
                <option <?php if ($category_id == 109 ) echo 'selected'; ?> value="109">Новые автомобили</option>
            </optgroup>
            <optgroup label="Недвижимость">
                <option <?php if ($category_id == 24 ) echo 'selected'; ?> value="24">Квартиры</option>
                <option <?php if ($category_id == 23 ) echo 'selected'; ?> value="23">Комнаты</option>
            </optgroup>
        </select> 
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