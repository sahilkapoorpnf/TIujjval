<?php 
use App\Mailtemplate;

 $data = Mailtemplate::where('id','=','4')->first();

echo str_replace(array("['name']","['link']"), array($name,$link),$data->description);
?>
