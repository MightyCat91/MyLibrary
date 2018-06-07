<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 16:22
 */

namespace MyLibrary\Comments\Models;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Comments
 * @package MyLibrary\Comments\Models
 *
 * @property string $text
 * @property float $rating
 * @property boolean $approved
 * @property integer $parent_id
 * @property integer $depth
 * @property integer $user_id
 * @property integer $com_id
 * @property string $com_table
 * @property \Carbon\Carbon $date
 */
class Comments extends Model
{
    protected $fillable = [
        'text',
        'rating',
        'approved',
        'parent_id',
        'depth',
        'user_id',
        'com_id',
        'com_table',
        'date'
    ];
    protected $casts = [
        'approved' => 'boolean'
    ];
}