<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель кашелька пользователей
 */
class Wallet extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'balance'];
}
