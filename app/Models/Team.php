<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function teamLeader()
    {
        return $this->hasOne(Employee::class, 'id', 'team_leader_id');
    }

    public function projectLeader()
    {
        return $this->hasOne(Employee::class, 'project_leader_id');
    }
}
