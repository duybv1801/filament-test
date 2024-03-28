<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use App\Filament\Pages\Auth\EditProfile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements HasAvatar
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'start_date',
        'phone',
        'birthday',
        'avatar',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return env('APP_URL') . '/storage/' . $this->avatar;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // public function getRoleIdAttribute($value)
    // {
    //     switch ($value) {
    //         case 1:
    //             return 'Admin';
    //         case 2:
    //             return 'Manager';
    //         case 3:
    //             return 'Member';
    //         default:
    //             return 'No role';
    //     }
    // }
}
