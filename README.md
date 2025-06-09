![Nova Pennant](https://banners.beyondco.de/Nova%20Pennant.png?theme=light&packageManager=composer+require&packageName=laravel%2Fnova-pennant&pattern=cage&style=style_1&description=A+Pennant+Resource+Tool+for+Laravel+Nova&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

This package makes it easy to view and manage Laravel Pennant features for your Laravel application inside of Nova.

## Installation

You can install the Nova tool via Composer:

```shell
composer require laravel/nova-pennant
```

Next, you must register the tool within the User Resource.

```php
use Laravel\Nova\PennantTool\PennantTool;

/**
 * Get the fields displayed by the resource.
 *
 * @return array
 */
public function fields(NovaRequest $request)
{
    return [
        ID::make()->sortable(),

        Text::make('Name')
            ->sortable()
            ->rules('required', 'max:255'),

        Text::make('Email')
            ->sortable()
            ->rules('required', 'email', 'max:254')
            ->creationRules('unique:users,email')
            ->updateRules('unique:users,email,{{resourceId}}'),

        Password::make('Password')
            ->onlyOnForms()
            ->creationRules('required', Rules\Password::defaults())
            ->updateRules('nullable', Rules\Password::defaults()),

        PennantTool::make(),
    ];
}
```

## Usage

### Authorization to Modify Feature Values

By default, Nova users will not have access to activate or deactivate features when they are authorized to see the resource. You need to use the `canRun()` method to authorize all or specific users.

```php
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Laravel\Nova\PennantTool\PennantTool;

// ...

PennantTool::make()
    ->canRun(fn (NovaRequest $request) => Nova::user($request)->admin),
```

### Password Confirmation

You can also require the user to confirm their password before activating or deactivating a feature by using `requiresConfirmPassword()` method:

```php
use Laravel\Nova\PennantTool\PennantTool;

// ...

PennantTool::make()
    ->requiresConfirmPassword(),
```

### Rich Feature Values

In order to configure rich values Nova would need to depend on a class-based feature and utilize `options(mixed $scope)` method:

```diff
namespace App\Features;

class UserTier 
{
    public $name = 'user-tier';

+   public function options(mixed $scope): array 
+   {
+      return ['solo', 'pro'];
+   }
}
