<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Models\Traits\HasAvatar;
use App\Models\Traits\HasImpersonate;
use App\Models\Traits\HasUserSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;

/**
 * @property \App\Models\Favoritable[]|\Illuminate\Database\Eloquent\Collection $favorites
 */
class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use Notifiable;
    use HasImpersonate;
    use HasApiTokens;
    use HasAvatar;
    use HasUserSlug;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'role',
        'slug',
        'use_gravatar',
        'display_favorites',
        'display_reviews',
        'display_gender',
        'about',
        'gender',
        'pronouns',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
        'role' => RoleEnum::class,
        'last_login_at' => 'datetime',
    ];

    public static function boot()
    {
        static::creating(function (User $user) {
            $user->slug = self::generateSlug($user, 'name', true);
        });

        parent::boot();
    }

    public function setPasswordAttribute($password)
    {
        if ($password) {
            $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
        }
    }

    public function hasAdminAccess()
    {
        return $this->role->equals(RoleEnum::super_admin, RoleEnum::admin);
    }

    public function canUpdate(User $user)
    {
        if ($this->role->equals(RoleEnum::admin)) {
            return ! $user->role->equals(RoleEnum::super_admin);
        }

        return $this->role->equals(RoleEnum::super_admin);
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.users.show', [
            'user_slug' => $this->slug,
        ]);
    }

    public function getShowLinkReviewsAttribute(): string
    {
        return route('api.users.reviews', [
            'user_slug' => $this->slug,
        ]);
    }

    public function getShowLinkFavoritesAttribute(): string
    {
        return route('api.users.favorites', [
            'user_slug' => $this->slug,
        ]);
    }

    public function hasRole(RoleEnum $role): bool
    {
        // $roles = [];
        // foreach ($this->roles as $key => $role) {
        //     array_push($roles, $role->name->value);
        // }

        // if (in_array($role_to_verify->value, $roles)) {
        //     return true;
        // }

        return $this->role == $role->value;
    }

    public function favorites()
    {
        return $this->hasMany(Favoritable::class)
            ->orderBy('created_at')
        ;
    }

    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
