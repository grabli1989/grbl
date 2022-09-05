<?php

namespace Markable\Traits;

use Markable\Models\View;

trait HasViewsTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function views(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->morphToMany(View::class, 'model', 'model_has_views', 'model_id', 'view_id');
    }

    /**
     * @param  int|null  $userId
     * @param  string|null  $guestIdentifier
     * @return void
     */
    public function view(?int $userId, ?string $userAgentIdentifier): void
    {
        if ($userId === $this->getUserId()) {
            return;
        }

        if (is_null($userAgentIdentifier)) {
            return;
        }

        $view = $this->getViewByUserAgentIdentifier($userAgentIdentifier);

        if ($view && ($userId === $view->user_id)) {
            return;
        }

        if ($view && (is_null($view->user_id) && $userId)) {
            $view->update(['user_id' => $userId]);

            return;
        }

        if ($view && ! is_null($view->user_id)) {
            return;
        }

        if (is_null($view)) {
            $this->createAndAttache($userId, $userAgentIdentifier);
        }
    }

    /**
     * @param  int|null  $userId
     * @param  string|null  $guestIdentifier
     * @return bool
     */
    public function userSeen(?int $userId, ?string $guestIdentifier): bool
    {
        return (bool) $this->getViewByUserId($userId) || (bool) $this->getViewByUserAgentIdentifier($guestIdentifier);
    }

    /**
     * @param  int|null  $userId
     * @return View|null
     */
    public function getViewByUserId(?int $userId): null|View
    {
        return $this->views()->where('user_id', $userId)->first();
    }

    /**
     * @param  string|null  $userAgentIdentifier
     * @return View|null
     */
    public function getViewByUserAgentIdentifier(?string $userAgentIdentifier): null|View
    {
        return $this->views()->where('user_agent_identifier', $userAgentIdentifier)->first();
    }

    /**
     * @param $userId
     * @param  string|null  $guestIdentifier
     * @return void
     */
    public function createAndAttache($userId, ?string $guestIdentifier): void
    {
        $view = View::create(['user_id' => $userId, 'user_agent_identifier' => $guestIdentifier]);
        $this->views()->attach($view);
    }

    /**
     * @param  View  $view
     * @param  string  $guestIdentifier
     * @return void
     */
    public function updateAndRemoveDoubles(View $view, string $guestIdentifier): void
    {
        $this->compareIdentifiers($view, $guestIdentifier) ?? $view->update(['guest_identifier' => $guestIdentifier]);
        $this->removeViewsByIdentifiersWhereUserIdIsNull($guestIdentifier);
    }

    /**
     * @param  string  $guestIdentifier
     * @return void
     */
    public function removeViewsByIdentifiersWhereUserIdIsNull(string $guestIdentifier): void
    {
        $this->views()->where('guest_identifier', $guestIdentifier)->whereNull('user_id')->delete();
    }

    /**
     * @param  View  $view
     * @param  string  $guestIdentifier
     * @return bool
     */
    public function compareIdentifiers(View $view, string $guestIdentifier): bool
    {
        return $view->guest_identifier === $guestIdentifier;
    }
}
