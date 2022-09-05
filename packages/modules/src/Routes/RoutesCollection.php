<?php

namespace Modules\Routes;

class RoutesCollection
{
    private array $apiRoutes;

    private array $webRoutes;

    /**
     * @param  array  $apiRoutes
     * @param  array  $webRoutes
     */
    public function __construct(array $apiRoutes = [], array $webRoutes = [])
    {
        $this->apiRoutes = $apiRoutes;
        $this->webRoutes = $webRoutes;
    }

    /**
     * @return array
     */
    public function getApiRoutes(): array
    {
        return $this->apiRoutes;
    }

    /**
     * @return array
     */
    public function getWebRoutes(): array
    {
        return $this->webRoutes;
    }
}
