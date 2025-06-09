<?php

namespace Laravel\Nova\PennantTool;

use Closure;
use Laravel\Nova\Nova;
use Laravel\Nova\ResourceTool;
use Stringable;

class PennantTool extends ResourceTool
{
    /**
     * Create a new resource tool instance.
     *
     * @return void
     */
    public function __construct(?string $name = null)
    {
        $this->name = $name ?? Nova::__('Features');

        parent::__construct();
    }

    /**
     * Get the displayable name of the resource tool.
     */
    public function name(): Stringable|string
    {
        return $this->name;
    }

    /**
     * Get the component name for the resource tool.
     */
    public function toolComponent(): string
    {
        return 'nova-pennant-tool';
    }

    /**
     * Set the callback used to determine if the resource tool can be updated.
     *
     * @param  (\Closure(\Laravel\Nova\Http\Requests\NovaRequest):(bool))|bool  $callback
     * @return $this
     */
    public function canRun(Closure|bool $callback = true)
    {
        $this->withMeta(['authorizedToRun' => $callback]);

        return $this;
    }

    /**
     * Set the callback used to determine if the resource tool requires confirm password.
     *
     * @param  (\Closure(\Laravel\Nova\Http\Requests\NovaRequest):(bool))|bool  $callback
     * @return $this
     */
    public function requiresConfirmPassword(Closure|bool $callback = true)
    {
        $this->withMeta(['requiresConfirmPassword' => $callback]);

        return $this;
    }
}
