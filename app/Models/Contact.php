<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
     use HasFactory;

     const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';


    public static $statuses = [
        self::STATUS_NEW => 'Mới',
        self::STATUS_READ => 'Đã đọc',
        self::STATUS_REPLIED => 'Đã trả lời'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email', 
        'phone',
        'subject',
        'message',
        'status'
    ];

    public function isNew()
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isRead()
    {
        return $this->status === self::STATUS_READ;
    }


    public function isReplied()
    {
        return $this->status === self::STATUS_REPLIED;
    }

 
    public function getStatusLabelAttribute()
    {
        return self::$statuses[$this->status] ?? 'Unknown';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_NEW => 'badge-primary',
            self::STATUS_READ => 'badge-info',
            self::STATUS_REPLIED => 'badge-success'
        ];

        $class = $badges[$this->status] ?? 'badge-secondary';
        
        return sprintf(
            '<span class="badge %s">%s</span>',
            $class,
            $this->status_label
        );
    }
}
