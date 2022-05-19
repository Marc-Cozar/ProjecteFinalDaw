<?php

namespace App\Models;

use App\Models\Web;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserEmailNotification extends Model
{
    protected $fillable = ['user_id', 'web_id', 'product_id', 'active'];
    protected $table = "user_email_notification";
    use HasFactory;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Web()
    {
        return $this->belongsTo(Web::class);
    }
}
