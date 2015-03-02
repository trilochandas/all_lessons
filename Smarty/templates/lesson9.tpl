{literal}
<style>
    form{width: 500px;}
    input:not([type="radio"]), select, textarea {float: right;}
    input{margin: 5px 0;}
    .form-row { clear: both;}
    table{
        border-collapse: collapse;
    }
    td{border: 1px solid; padding: 5px;}
</style>
{/literal}

<p style="color:red;">{$error}</p>
<form  method="POST">
    <div class="form-row-indented"> 
        <label><input type="radio" {if $private == 1} {'checked'} {/if}  value="1" name="private">Частное лицо</label> 
        <label><input type="radio" {if $private == 0} {'checked'} {/if} value="0" name="private">Компания</label> 
    </div>
    <div class="form-row"> 
        <label for="fld_seller_name"><b> Ваше имя</b></label>
        <input type="text" maxlength="40" value="{$seller_name}" name="seller_name" id="fld_seller_name">
    </div>
    <div class="form-row"> 
        <label for="fld_email">Электронная почта</label>
        <input type="text" class="form-input-text" value="{$email}" name="email" id="fld_email">
    </div>
    <br>
    <div class="form-row-indented"> 
        <label  for="allow_mails">
        <input type="checkbox" {$allow_mails} value="1" name="allow_mails" id="allow_mails" ><span>Я не хочу получать вопросы по объявлению по e-mail</span>
        </label> 
    </div>
    <div class="form-row"> 
        <label for="fld_phone" class="form-label">Номер телефона</label>
        <input type="text"  value="{$phone}" name="phone" id="fld_phone">
    </div>
    <div id="f_location_id" class="form-row "> 
    <label for="region" class="form-label">Город</label> 
        {html_options name=location_id options=$citys selected=$location_id }
    </div>
    <div id="f_metro_id" class="form-row "> 
        <label for="metro_id" class="form-label">Метро</label>
        {html_options name=metro_id options=$underground selected=$metro_id }
    </div>
    <div class="form-row "> 
        <label for="category_id" >Категория</label>
        {html_options name=category_id options=$categorys selected=$category_id }
    </div>
    <div id="f_title" class="form-row f_title"> 
        <label for="fld_title" >Название объявления</label> 
        <input maxlength="50" value="{$title}" name="title" id="fld_title" type="text"> 
    </div>
    <div class="form-row"> 
        <label for="fld_description">Описание объявления</label> 
        <textarea maxlength="3000" name="description" id="fld_description" >{$description}</textarea> 
    </div>
    <div id="price_rw" class="form-row rl"> 
        <label for="fld_price" >Цена</label> 
        <input maxlength="9" value="{$price}" placeholder="0" name="price" id="fld_price" type="text">&nbsp;<span>руб.</span>
    </div>
    <div>
        <input type="submit" value="Далее" name="main_form_submit" >
    </div>
    <br>
    <br>
    {html_options name=location_id_sql options=$results }
    </form>   
    <h2>Все объявления</h2>
    <table>
        <tr>
            <td>Название объявления</td>
            <td>Цена</td>
            <td>Имя продавца</td>
            <td>Удалить</td>
        </tr>

    {foreach from=$current key=k item=v}
        <tr>
            <td><a href="{$smarty.server.SCRIPT_NAME}?id={$k}">{$v.title}</a></td> 
            <td>{$v.price}</td> 
            <td>{$v.seller_name}</td> 
            <td><a href="{$smarty.server.SCRIPT_NAME}?del={$k}">Удалить</a></td> 
       </tr>
    {/foreach}
    </table>
    {$results|@var_dump}

