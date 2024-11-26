<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class UserTokenModel extends Model
{
    protected $DBGroup = "residentes"; // database group
    protected $table = 'user_tokens';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'access_token', 'refresh_token', 'expires_at'];
}