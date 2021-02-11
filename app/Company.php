<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $table = "company";
    protected $fillable =['title','welcom_word','welcom_clouse','add_compline_clouse','add_propusel_clouse','add_thanks_clouse','follw_compline_clouse','how_we','mopile',
        'phone','free_number','mail','address','fax','steps_file'];

}
