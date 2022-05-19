<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmailNotification extends Model
{
    protected $fillable = ['user_id', 'web_id', 'product_id', 'active'];
    protected $table = "user_email_notification";
    use HasFactory;
}
