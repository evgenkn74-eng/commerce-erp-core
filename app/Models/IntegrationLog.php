<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationLog extends Model
{
	// включать или отключать автоматическое заполнение created_at и updated_at
    public $timestamps = false;

    protected $fillable = ['service', 'endpoint', 'status_code', 'duration_ms', 'error'];
}
