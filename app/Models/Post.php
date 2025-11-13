<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User;

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
        'user_id',
        'category_id',
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
    public function favoret_post()
    {
        return $this->belongsToMany(User::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_posts', 'post_id', 'category_id');
    }
    public function comments()
    {
        return $this->hasMany(CommentsPost::class);
    }
}
