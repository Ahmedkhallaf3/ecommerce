<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', 'admin');
        }
//ده كود لو ادمن يرجعه علي الداش بورد لو يوزر يرجع علي الهوم
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request) {
                if ($request->user('admin')) {
                //intended=>لو انت في صفحة معينة ووداك تعمل لوجين لما تعمل لوجين هترجع لنفس الصفحة
                //intended=>لو انت في صفحة الوجين علي طول بعد ما تسجل هتروح مباشرة لصفحة الداشبورد
                    return redirect()->intended('admin/dashboard');
                }

                return redirect()->intended('/');
            }
        });

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request) {
                return redirect('/');
            }
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {



        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        if(Config::get('fortify.guard') == 'admin'){
            Fortify::authenticateUsing([new AuthenticateUser, 'authenticate']);
            Fortify::viewPrefix('auth.');
        }else{
            Fortify::viewPrefix('front.auth.');
        }

        //Fortify::loginView('auth.login');
       // Fortify::registerView('auth.register');
    }
}
