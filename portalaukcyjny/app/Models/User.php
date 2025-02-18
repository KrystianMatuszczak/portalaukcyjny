<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAddressDetails;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isWorker(): bool
    {
        return $this->hasRole(config('auth.roles.worker'));
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(config('auth.roles.admin'));
    }

    public function markAsTrusted() {
      $this->trusted = true;
      $this->save();
    }

    public function unmarkAsTrusted() {
      $this->trusted = false;
      $this->save();
    }

    public function block() {
      $this->blocked = true;
      $this->save();
    }
    
    public function unblock() {
      $this->blocked = false;
      $this->save();
    }

    public function userAddressDetails() {
      return $this->hasOne(UserAddressDetails::class);
    }
    public function products()
    {
      return $this->hasMany(Product::class);
    }
}
