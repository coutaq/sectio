<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function sectionActivities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SectionActivity::class);
    }

    public function admins(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class)->join('roles', 'users.role_id', '=', 'roles.id')->where('slug','admin');
    }
    public function pupils(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class)->join('roles', 'users.role_id', '=', 'roles.id')->where('slug','pupil');
    }
}
