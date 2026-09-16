<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! App::isProduction());

        // Intercetta la regola 'unique' e tronca il segnaposto :input quando il testo ha troppi caratteri
        Validator::replacer('unique', function ($message, $attribute, $rule, $parameters, $validator) {
            $value = $validator->getValue($attribute);

            if (is_string($value)) {
                // Tronca il testo a 30 caratteri
                $truncated = Str::limit($value, 30, '...');
                return str_replace(':input', $truncated, $message);
            }

            return $message;
        });
    }

}
