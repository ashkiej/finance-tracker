<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'month',
        'year'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getSpentAttribute()
    {
        return $this->category->transactions()
            ->where('user_id', $this->user_id)
            ->whereMonth('transaction_date', $this->month)
            ->whereYear('transaction_date', $this->year)
            ->where('type', 'expense')
            ->sum('amount');
    }
}
