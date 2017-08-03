<?php

namespace BirBrand;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'price', 'image_url', 'options'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    /*
     * Product belongs to a category
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Get all categories
     */
    public function allCategories() {
        return $this->category()->with('allCategories');
    }

    /*
     * Product belongs to a user
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}