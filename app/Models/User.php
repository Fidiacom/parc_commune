<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const TABLE = 'users';
    public const ID_COLUMN = 'id';
    public const NAME_COLUMN = 'name';
    public const USERNAME_COLUMN = 'username';
    public const EMAIL_COLUMN = 'email';
    public const EMAIL_VERIFIED_AT_COLUMN = 'email_verified_at';
    public const PASSWORD_COLUMN = 'password';
    public const REMEMBER_TOKEN_COLUMN = 'remember_token';
    public const ROLE_ID_COLUMN = 'role_id';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getName(): string
    {
        return $this->getAttribute(self::NAME_COLUMN);
    }

    public function getUsername(): ?string
    {
        return $this->getAttribute(self::USERNAME_COLUMN);
    }

    public function getEmail(): string
    {
        return $this->getAttribute(self::EMAIL_COLUMN);
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->getAttribute(self::EMAIL_VERIFIED_AT_COLUMN);
    }

    public function getRoleId(): ?int
    {
        return $this->getAttribute(self::ROLE_ID_COLUMN);
    }
}
