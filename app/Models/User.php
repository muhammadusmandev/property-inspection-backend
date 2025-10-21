<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'profile_photo',
        'gender',
        'date_of_birth',
        'bio',
        'role',
        'password',
        'is_active',
        'last_login_at',
        'realtor_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'uuid' => 'string',
        ];
    }

    /**
     * The accessors to append to the model's array
     *
     * @return array<string, string>
     */
    protected $appends = ['first_name', 'last_name'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * first name from full name.
     */
    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0] ?? null;
    }

    /**
     * last name from full name.
     */
    public function getLastNameAttribute()
    {
        $parts = explode(' ', $this->name);
        return isset($parts[1]) ? $parts[1] : null;
    }

    /**
     * Realtor may have many branches of the property.
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    /**
     * Realtor has many properties.
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Realtor has many clients.
     */

    public function clients()
    {
        return $this->hasMany(self::class, 'realtor_id');
    }

    /**
     * Client belongs to realtor.
     */

    public function realtor()
    {
        return $this->belongsTo(self::class, 'realtor_id');
    }
}
