<?php 
    session_start();
    $advert = serialize($_SESSION['history']);
    setcookie('advert', $advert, time() + 3600*24*7);
    $advert = unserialize($advert);
//     if (isset($_SESSION))
// {
//     session_unset();
//     session_destroy();
// }

// проверка массива GET на наличие парметра del на удаление новости
if (isset($_GET['del'])) {
    unset($_SESSION['history'][$_GET['del']]);
    $advert = serialize($_SESSION['history']);    
}
// проверка на наличие параматров в форме
if (isset($_POST['main_form_submit'])){
    // проверка на наличие знаков у параметров формы
    if (empty($_POST['title']) && empty($_POST['price']) &&  empty($_POST['seller_name'])&&  empty($_POST['phone'])) {
        echo '<p style="color:red;">Введите все данные</p>';
        } else {
        // перезапись объявления
        if (isset($_GET['id'])){
            $_SESSION['history'][$_GET['id']] = $_POST;
        } else{
        // присваиваем сессии данные из POST
        $_SESSION['history'][]=$_POST;
        }
    }
}
// var_dump($_SESSION);
// заполнение формы данными из GET
if (isset($_GET['id'])){
    $id = (int) $_GET['id'];
    $title=$_SESSION['history'][$id]['title'];
    $price=$_SESSION['history'][$id]['price'];
    $seller_name=$_SESSION['history'][$id]['seller_name'];
    $description=$_SESSION['history'][$id]['description'];
    $email=$_SESSION['history'][$id]['email'];
    $phone=$_SESSION['history'][$id]['phone'];
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
}

?>
<form  method="POST">
<!--     <div class="form-row-indented"> <label class="form-label-radio"><input type="radio" checked="" value="1" name="private">Частное лицо</label> <label class="form-label-radio"><input type="radio" value="0" name="private">Компания</label> </div> -->
    <div class="form-row"> <label for="fld_seller_name" class="form-label"><b id="your-name">Ваше имя</b></label>
        <input type="text" maxlength="40" class="form-input-text" value="<?php echo $seller_name; ?>" name="seller_name" id="fld_seller_name">
    </div>
    <div class="form-row"> <label for="fld_email" class="form-label">Электронная почта</label>
        <input type="text" class="form-input-text" value="" name="email" id="fld_email">
    </div>
    <div class="form-row-indented"> 
        <label class="form-label-checkbox" for="allow_mails">
            <input type="checkbox" <?php echo $allow_mails; ?>  value="1" name="allow_mails" id="allow_mails" class="form-input-checkbox"><span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span>
        </label> 
    </div>
    <div class="form-row"> <label id="fld_phone_label" for="fld_phone" class="form-label">Номер телефона</label> <input type="text" class="form-input-text" value="<?php echo $phone; ?>" name="phone" id="fld_phone">
    </div>
    <div id="f_location_id" class="form-row form-row-required"> <label for="region" class="form-label">Город</label> <select title="Выберите Ваш город" name="location_id" id="region" class="form-input-select"> <option selected value="">-- Выберите город --</option>
            <option class="opt-group" disabled="disabled">-- Города --</option>
            <option  data-coords=",," value="641780">Новосибирск</option>   <option data-coords=",," value="641490">Барабинск</option>   <option data-coords=",," value="641510">Бердск</option>   <option data-coords=",," value="641600">Искитим</option>   <option data-coords=",," value="641630">Колывань</option>   <option data-coords=",," value="641680">Краснообск</option>   <option data-coords=",," value="641710">Куйбышев</option>   <option data-coords=",," value="641760">Мошково</option>   <option data-coords=",," value="641790">Обь</option>   <option data-coords=",," value="641800">Ордынское</option>   <option data-coords=",," value="641970">Черепаново</option>   <option id="select-region" value="0">Выбрать другой...</option> </select> <div id="f_metro_id"> <select title="Выберите станцию метро" name="metro_id" id="fld_metro_id" class="form-input-select"> <option value="">-- Выберите станцию метро --</option><option value="2028">Берёзовая роща</option><option value="2018">Гагаринская</option><option value="2017">Заельцовская</option><option value="2029">Золотая Нива</option><option value="2019">Красный проспект</option><option value="2027">Маршала Покрышкина</option><option value="2021">Октябрьская</option><option value="2025">Площадь Гарина-Михайловского</option><option value="2020">Площадь Ленина</option><option value="2024">Площадь Маркса</option><option value="2022">Речной вокзал</option><option value="2026">Сибирская</option><option value="2023">Студенческая</option></select> </div> <div id="f_district_id"> <select title="Выберите район города" name="district_id" id="fld_district_id" class="form-input-select" style="display: none;"> <option value="">-- Выберите район города --</option></select> </div> <div id="f_road_id"> <select title="Выберите направление" name="road_id" id="fld_road_id" class="form-input-select" style="display: none;"> <option value="">-- Выберите направление --</option><option value="56">Бердское шоссе</option><option value="57">Гусинобродское шоссе</option><option value="53">Дачное шоссе</option><option value="55">Краснояровское шоссе</option><option value="54">Мочищенское шоссе</option><option value="52">Ордынское  шоссе</option><option value="58">Советское шоссе</option></select> </div> </div>
    <div class="form-row"> <label for="fld_category_id" class="form-label">Категория</label> <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-input-select"> <option value="">-- Выберите категорию --</option><optgroup label="Транспорт"><option value="9">Автомобили с пробегом</option><option value="109">Новые автомобили</option><option value="14">Мотоциклы и мототехника</option><option value="81">Грузовики и спецтехника</option><option value="11">Водный транспорт</option><option value="10">Запчасти и аксессуары</option></optgroup><optgroup label="Недвижимость"><option value="24">Квартиры</option><option value="23">Комнаты</option><option value="25">Дома, дачи, коттеджи</option><option value="26">Земельные участки</option><option value="85">Гаражи и машиноместа</option><option value="42">Коммерческая недвижимость</option><option value="86">Недвижимость за рубежом</option></optgroup><optgroup label="Работа"><option value="111">Вакансии (поиск сотрудников)</option><option value="112">Резюме (поиск работы)</option></optgroup><optgroup label="Услуги"><option value="114">Предложения услуг</option><option value="115">Запросы на услуги</option></optgroup><optgroup label="Личные вещи"><option value="27">Одежда, обувь, аксессуары</option><option value="29">Детская одежда и обувь</option><option value="30">Товары для детей и игрушки</option><option value="28">Часы и украшения</option><option value="88">Красота и здоровье</option></optgroup><optgroup label="Для дома и дачи"><option value="21">Бытовая техника</option><option value="20">Мебель и интерьер</option><option value="87">Посуда и товары для кухни</option><option value="82">Продукты питания</option><option value="19">Ремонт и строительство</option><option value="106">Растения</option></optgroup><optgroup label="Бытовая электроника"><option value="32">Аудио и видео</option><option value="97">Игры, приставки и программы</option><option value="31">Настольные компьютеры</option><option value="98">Ноутбуки</option><option value="99">Оргтехника и расходники</option><option value="96">Планшеты и электронные книги</option><option value="84">Телефоны</option><option value="101">Товары для компьютера</option><option value="105">Фототехника</option></optgroup><optgroup label="Хобби и отдых"><option value="33">Билеты и путешествия</option><option value="34">Велосипеды</option><option value="83">Книги и журналы</option><option value="36">Коллекционирование</option><option value="38">Музыкальные инструменты</option><option value="102">Охота и рыбалка</option><option value="39">Спорт и отдых</option><option value="103">Знакомства</option></optgroup><optgroup label="Животные"><option value="89">Собаки</option><option value="90">Кошки</option><option value="91">Птицы</option><option value="92">Аквариум</option><option value="93">Другие животные</option><option value="94">Товары для животных</option></optgroup><optgroup label="Для бизнеса"><option value="116">Готовый бизнес</option><option value="40">Оборудование для бизнеса</option></optgroup></select> </div>
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