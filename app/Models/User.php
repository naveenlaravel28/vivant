<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'first_name',
        'last_name',
        'country_code',
        'mobile',
        'email',
        'location',
        'address',
        'profile_image',
        'password',
        'status',
    ];

    protected $appends = [
        'name',
        'profile_url',
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
        ];
    }

    public function getNameAttribute() {
        return $this->first_name.' '.$this->last_name;
    }

    public function getProfileUrlAttribute() {
        if(!blank($this->profile_image)) {
            return Storage::url($this->profile_image);
        } else {
            return asset('admin/assets/img/avatars/admin.png');
        }
    }
}
