<?php

namespace User\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Realty\Interfaces\RolesInterface;
use Settings\Interfaces\HasSettingsInterface;
use Settings\Models\Setting;
use Settings\Traits\HasSettingsTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use User\Events\ResetPasswordEvent;
use User\Events\UserConfirmedByPhoneEvent;
use User\Exceptions\AuthException;
use User\Exceptions\ConfirmationCodeException;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $phone_confirmation_code
 * @property bool $is_confirmed
 * @property \Illuminate\Support\Carbon|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneConfirmationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerifiedAt($value)
 * @property-read Collection|Setting[] $settings
 * @property-read int|null $settings_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @property-read \User\Models\UserInfo|null $info
 */
class User extends Authenticatable implements HasMedia, HasSettingsInterface
{
    use InteractsWithMedia;
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasSettingsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'phone_confirmation_code',
        'phone_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'phone_confirmation_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'is_confirmed' => 'boolean',
    ];

    /**
     * @return Builder
     */
    public static function hasUsersRoles(): Builder
    {
        return self::query()->has('roles', '<>', 0, 'and', function (Builder $query) {
            return $query->whereIn('name', RolesInterface::USER_ROLES);
        });
    }

    /**
     * @param  string  $code
     * @param  bool  $assertIsConfirmed
     * @return void
     *
     * @throws ConfirmationCodeException
     */
    public function confirm(string $code, bool $assertIsConfirmed = true): void
    {
        if ($assertIsConfirmed) {
            $this->assertIsConfirmed();
        }
        if ($code != $this->phone_confirmation_code) {
            throw ConfirmationCodeException::codeCompareException();
        }

        $this->is_confirmed = true;
        $this->phone_verified_at = Carbon::now();
        $this->save();

        event(new UserConfirmedByPhoneEvent($this));
    }

    /**
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->is_confirmed;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->phone_confirmation_code;
    }

    /**
     * @throws ConfirmationCodeException
     */
    private function assertIsConfirmed()
    {
        if ($this->isConfirmed()) {
            throw ConfirmationCodeException::userAlreadyConfirmed();
        }
    }

    /**
     * @return string
     */
    public function guardName(): string
    {
        return 'sanctum';
    }

    /**
     * @param  string  $verifiablePassword
     * @return bool
     */
    public function comparePassword(string $verifiablePassword): bool
    {
        return Hash::check($verifiablePassword, $this->password);
    }

    /**
     * @throws AuthException
     */
    public function updatePassword(string $newPassword)
    {
        $this->assertPassword($newPassword);
        $this->update(['password' => Hash::make($newPassword)]);
    }

    /**
     * @param  string  $newPassword
     * @return void
     *
     * @throws AuthException
     */
    private function assertPassword(string $newPassword): void
    {
        if ($this->comparePassword($newPassword)) {
            throw AuthException::passwordsIdenticalException();
        }
    }

    /**
     * @param  string  $code
     * @return void
     */
    public function resetPassword(string $code): void
    {
        $this->phone_confirmation_code = $code;
        $this->save();
        event(new ResetPasswordEvent($this));
    }

    /**
     * @return Collection|Permission[]
     */
    public function getPermissions(): Collection|array
    {
        if ($this->isSuperAdmin()) {
            return Permission::get();
        }

        return $this->permissions;
    }

    /**
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RolesInterface::ROLES['SUPER_ADMIN']);
    }

    /**
     * @return HasOne
     */
    public function info(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }

    /**
     * @return void
     */
    public function createInfo(): void
    {
        $this->info()->create();
    }
}
