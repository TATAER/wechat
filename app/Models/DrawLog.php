<?php
/**
 * Created by PhpStorm.
 * User: 山岭巨人
 * Date: 2018/12/1
 * Time: 下午1:47
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrawLog extends Model
{
    protected $table = 'draw_log';
    protected $fillable = ['name'];
}