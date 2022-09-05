<?php

namespace Markable\Interfaces;

use Markable\Models\View;

interface HasViewsInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function views(): \Illuminate\Database\Eloquent\Relations\BelongsToMany;

    /**
     * @param  int|null  $userId
     * @param  string|null  $guestIdentifier
     * @return void
     */
    public function view(?int $userId, ?string $guestIdentifier): void;

    /**
     * @param  int|null  $userId
     * @param  string|null  $guestIdentifier
     * @return bool
     */
    public function userSeen(?int $userId, ?string $guestIdentifier): bool;

    /**
     * @param  int|null  $userId
     * @return View|null
     */
    public function getViewByUserId(?int $userId): null|View;

    /**
     * @param  string|null  $userAgentIdentifier
     * @return View|null
     */
    public function getViewByUserAgentIdentifier(?string $userAgentIdentifier): null|View;

    /**
     * @param $userId
     * @param  string|null  $guestIdentifier
     * @return void
     */
    public function createAndAttache($userId, ?string $guestIdentifier): void;

    /**
     * @return int
     */
    public function getUserId(): int;
}
