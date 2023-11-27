<?php

namespace App\Models\User;

use App\Models\Role\Role;
use App\Models\Webshop\Webshop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $webshop_id
 * @property string $remember_token
 * @property Webshop $webshop
 * @property Role $role
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function assignRole(UserRole $role)
    {
        $role = Role::where('name', $role->getValue())->firstOrFail();

        $this->role()->associate($role);
        $this->save();
    }

    public function assignWebshop(Webshop $webshop)
    {
        $this->webshop()->associate($webshop);
        $this->save();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function webshop()
    {
        return $this->belongsTo(Webshop::class);
    }
}
