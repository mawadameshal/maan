<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class appendix extends Model
{
    protected $table = "appendixes";

    protected $fillable =['appendix_name','appendix_describe','appendix_file'];

}
