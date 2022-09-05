<?php

namespace Markable\Managers;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Markable\Interfaces\HasViewsInterface;
use Realty\Interfaces\ViewsManagerInterface;

class ViewsManager implements ViewsManagerInterface
{
    private Repository $modules;

    private Request $request;

    public function __construct()
    {
        $this->request = request();
        $this->modules = app()->make('modules');
    }

    /**
     * @param  HasViewsInterface  $model
     * @return void
     */
    public function view(HasViewsInterface $model): void
    {
        $userId = $this->getUserId();
        $guestIdentifier = $this->modules->get('user.userAgentIdentifier');
        $model->view($userId, $guestIdentifier);
    }

    /**
     * @return int|null
     */
    private function getUserId(): null|int
    {
        return $this->request->user()?->id;
    }
}
