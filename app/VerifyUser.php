<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * User Class
 *
 * @package
 * @subpackage            User
 * @category              Model
 * @DateOfCreation        17 August 2018
 * @DateOfDeprecated
 * @ShortDescription      This class contains code that deals with verification of users without admin access
 * @LongDescription
 */
class VerifyUser extends Model
{
    protected $guarded = [];
    /**
     * @DateOfCreation        17 August 2018
     * @ShortDescription	This function defines relationship with user model
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
