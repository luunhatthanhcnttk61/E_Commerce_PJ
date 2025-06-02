<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
     use HasFactory;

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

    /**
     * Các trạng thái có thể có của contact
     */
    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';

    /**
     * Danh sách các trạng thái
     */
    public static $statuses = [
        self::STATUS_NEW => 'Mới',
        self::STATUS_READ => 'Đã đọc',
        self::STATUS_REPLIED => 'Đã trả lời'
    ];

    /**
     * Check if contact is new
     */
    public function isNew()
    {
        return $this->status === self::STATUS_NEW;
    }

    /**
     * Check if contact has been read
     */
    public function isRead()
    {
        return $this->status === self::STATUS_READ;
    }

    /**
     * Check if contact has been replied
     */
    public function isReplied()
    {
        return $this->status === self::STATUS_REPLIED;
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return self::$statuses[$this->status] ?? 'Unknown';
    }

    /**
     * Get status badge HTML
     */
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
