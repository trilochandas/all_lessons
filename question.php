<?php
function barber($type)
{
    echo "Вы хотели стрижку $type, без проблем\n";
}
call_user_func('barber', "под горшок");
call_user_func('barber', "наголо");

// можно так?
barber('под горшок');
?>