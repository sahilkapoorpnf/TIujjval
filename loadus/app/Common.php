<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Common extends Model {

    public function getlanhuageidByname($param) {
        $res = DB::table('tbl_language')->where([['slug', '=', $param]])->first();
        if ($res) {
            return $res->id;
        } else {
            return FALSE;
        }
    }

    public function randString($n = NULL) {
        if (empty($n)) {
            $n = 8;
        }
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i <= $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

}
