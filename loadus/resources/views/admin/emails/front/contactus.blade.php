<?php 
use App\Mailtemplate;

 $data = Mailtemplate::where('id','=','5')->first();

echo str_replace(array("['name']", "['email']","['phone']","['messages']"), array($name, $email,$phone,$messages),$data->description);
?>
