<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Định nghĩa các role
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user'; 
    const ROLE_CLIENT = 'client';

    protected $fillable = [
        'name',
        'email',
        'password',
        'address', 
        'phone',
        'avatar',
        'role',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    // Kiểm tra role
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function isClient() 
    {
        return $this->role === self::ROLE_CLIENT;
    }

    // Kiểm tra quyền
    public function canManageUsers()
    {
        return $this->isAdmin(); // Chỉ admin mới được quản lý users
    }

    public function canViewUsers()
    {
        return $this->isAdmin() || $this->isUser(); // Admin và user đều xem được
    }

    public function canAccessDashboard() 
    {
        return $this->isAdmin() || $this->isUser(); // Admin và user đều vào được dashboard
    }

    public function canAccessClientArea()
    {
        return true; // Tất cả role đều vào được trang client
    }

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Hoạt động' : 'Khóa';
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        return asset('images/default-avatar.png');
    }
}