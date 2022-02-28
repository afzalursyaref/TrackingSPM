<?php

namespace App\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $event)
    {
        $event->listen(BuildingMenu::class, function(BuildingMenu $event){
            if(auth()->check()){
                $event->menu->add('MAIN NAVIGATION');
                $event->menu->add([
                    'key' => 'dashboard',
                    'text' => 'Dashboard',
                    'url' => 'admin/dashboard',
                    'icon' => 'far fa-fw fa-file',
                ]);

                // dd(auth()->user()->hasRole('admin'));

                // if(auth()->user()->hasRole('admin')){
                //     $event->menu->add([
                //         'key'       => 'master',
                //         'header'    => 'MASTER'
                //     ]);

                //     $event->menu->add([
                //         'key'  => 'skpk',
                //         'text' => 'SKPK',
                //         'url'  => 'admin/master/skpk',
                //         'icon' => 'fas fa-fw fa-user',
                //         'active'=> ['admin/user/*']
                //     ]);
                // }

                $event->menu->add([
                    'key'       => 'menu',
                    'header'    => 'MENU'
                ]);

                if(auth()->user()->hasRole('front-office')){
                    $event->menu->add([
                        'key'         => 'Agenda',
                        'text'        => 'agenda',
                        'url'         => 'admin/agenda',
                        'icon'        => 'far fa-fw fa-file',
                        'active'      => ['admin/agenda/*']
                    ]);
                }

                if(auth()->user()->hasRole('verifikator-belanja-daerah') || auth()->user()->hasRole('verifikator-penatausahaan')){
                    $event->menu->add([
                        'key'         => 'verifikasi',
                        'text'        => 'Verifikasi',
                        'url'         => 'admin/verifikasi',
                        'icon'        => 'far fa-fw fa-file',
                        'active'      => ['admin/verifikasi/*']
                    ]);
                }

                if(auth()->user()->hasRole('pengelola')){
                    $event->menu->add([
                        'key'         => 'pengelola',
                        'text'        => 'Pengelola',
                        'url'         => 'admin/pengelola',
                        'icon'        => 'far fa-fw fa-file',
                        'active'      => ['admin/pengelola/*']
                    ]);
                }

                if(auth()->user()->hasRole('bud') || auth()->user()->hasRole('kuasa-bud')){
                    $event->menu->add([
                        'key'         => 'bud',
                        'text'        => 'Bud / Kuasa BUD',
                        'url'         => 'admin/bud',
                        'icon'        => 'far fa-fw fa-file',
                        'active'      => ['admin/bud/*']
                    ]);
                }

                $event->menu->add([
                    'key'       => 'laporan',
                    'header'    => 'LAPORAN'
                ]);

                $event->menu->add([
                    'key'  => 'register',
                    'text' => 'Register Agenda',
                    'url'  => 'admin/laporan/register',
                    'icon' => 'fas fa-fw fa-users',
                    'active'=> ['admin/laporan/register']
                ]);


                $event->menu->add([
                    'key'       => 'pengaturan_akun',
                    'header'    => 'PENGATURAN AKUN'
                ]);

                if(auth()->user()->hasRole('admin')){
                    $event->menu->add([
                        'key'  => 'pengguna',
                        'text' => 'pengguna',
                        'url'  => 'admin/user',
                        'icon' => 'fas fa-fw fa-users',
                        'active'=> ['admin/user/*']
                    ]);
                }

                $event->menu->add([
                    'key'  => 'profile',
                    'text' => 'profile',
                    'url'  => 'profile/username',
                    'icon' => 'fas fa-fw fa-user',
                ]);
                $event->menu->add([
                    'key'  => 'change_password',
                    'text' => 'change_password',
                    'url'  => 'profile/change-password',
                    'icon' => 'fas fa-fw fa-lock',
                ]);
            }

            if(!auth()->check()){
                $event->menu->add([
                    'key' => 'tentang',
                    'text' => 'Tentang Aplikasi',
                    'url' => '/',
                    'icon' => 'far fa-fw fa-file',
                ]);

                $event->menu->add([
                    'key' => 'login',
                    'text' => 'Login Admin',
                    'url' => '/login',
                    'icon' => 'fas fa-sign-in-alt',
                ]);
            }

        });

    }
}
