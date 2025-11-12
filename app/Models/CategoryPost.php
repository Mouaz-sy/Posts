<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryPost extends Pivot
{
    protected $table = 'category_posts'; // حدد اسم الجدول
    public $fillable = [
        'post_id',
        'category_id',
        // أي حقول إضافية في الجدول الوسيط
    ];

    // لا تضع هنا belongsToMany
    // العلاقات هنا ستكون belongsTo لكل من Post و Category
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
