<?php
function barber($type)
{
	global $a;
    echo "Вы хотели стрижку $type, без проблем\n";
    echo(call_user_func($a, 4));
}
// call_user_func('barber', "под горшок");
// call_user_func('barber', "наголо");
echo '<br>';
$a = function($ff){
	$sum= 10 - $ff;
	return $sum;
};
barber("Tri");


 // var_dump($_SERVER);
?>