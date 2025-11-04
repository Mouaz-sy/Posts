<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * نموذج Post
 * يتوافق مع جدول 'posts' في قاعدة البيانات.
 */
class Post extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعيينها بشكل مجمع.
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    /**
     * إعداد الأعمدة لتكون من نوع تاريخ (datetime).
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
