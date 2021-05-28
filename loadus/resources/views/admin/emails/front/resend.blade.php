<?php 
use App\Mailtemplate;

 $data = Mailtemplate::where('id','=','3')->first();

echo str_replace(array("['name']","['verification_code']"), array($name,$verification_code),$data->description);
?>
