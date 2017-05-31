<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $level
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $perms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends EntrustRole
{
    protected $guarded = [];

    /**
     * Find a role by its name.
     *
     * @param string $name
     *
     * @return Role
     */
    public static function findByName($name)
    {
        $role = static::where('name', $name)->first();

        return $role;
    }

    public static function lowerCurrentUser() {
        if (\Auth::guest()) {
            return collect();
        }
        return Role::query()
            ->where('level', '<=', \Auth::user()->roleLevel())
            ->orderBy('level', 'desc')
            ->get();
    }
}
