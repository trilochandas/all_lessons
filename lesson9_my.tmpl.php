<style>
table{
    border: 1px;
    border-collapse: collapse;
    text-align: center;
}
td{
    border: 1px solid;
    padding: 10px;
}
form{width: 500px;}
input:not([type="radio"]), select, textarea {
    float: right;
}
input{
    margin: 3px 0;
}
.form-row {
    margin: 10px 0;
    clear: both;
}

</style>
<p><?php echo $error_output ?></p>
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
    <?php 
        foreach ($select_meta as $key => $select) {
    ?>
        <div id="f_metro_id"> 
            <label for="<?php echo  $select['name'] . '_id'; ?>" class="form-label"><?php echo  $select['label']; ?></label>
            <select name="<?php echo  $select['name']; ?>" id="<?php echo  $select['name'] . '_id'; ?>">
                <?php 
                    foreach (json_decode($select['options']) as $val => $name) {
                        echo "<option value='{$val}' " . ($val == $city || $val == $metro?"selected":"") . ">{$name}</option>";
                    } 
                ?>
            </select>    
        </div>
    </div>
   <?php  } ?>
<!--     <div class="form-row"> 
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
    ?> -->
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
         <input type="submit" value="Далее" id="form_submit" name="main_form_submit" class="vas-submit-input"> 
     </div>
    </div>
</form>
<h3>Все объявления</h3>
<?php output_adverts_table(); ?>
