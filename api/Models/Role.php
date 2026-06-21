<?php
/**
 * Author: Course Project Team
 * Date: 6/15/2026
 * File: Role.php
 * Description: Define the Role model class.
 */

namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'role');
    }
}
