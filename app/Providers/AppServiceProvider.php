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
                $event->menu->add([
                    'key'       => 'pengaturan_akun',
                    'header'    => 'PENGATURAN AKUN'
                ]);
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


                if(auth()->user()->role == 'admin'){
                    $event->menu->add([
                        'key'       => 'master',
                        'header'    => 'MASTER'
                    ]);

                    $event->menu->addAfter('master', [
                        'key'  => 'skpk',
                        'text' => 'SKPK',
                        'url'  => 'admin/master/skpk',
                        'icon' => 'fas fa-fw fa-user',
                        'active'=> ['admin/user/*']
                    ]);
    
                    $event->menu->addAfter('pengaturan_akun', [
                        'key'  => 'pengguna',
                        'text' => 'pengguna',
                        'url'  => 'admin/user',
                        'icon' => 'fas fa-fw fa-user',
                        'active'=> ['admin/user/*']
                    ]);
                }
    
                if(auth()->user()->role == 'front-office'){
                    $event->menu->addAfter('dashboard', [
                        'key'         => 'Agenda',
                        'text'        => 'agenda',
                        'url'         => 'admin/agenda',
                        'icon'        => 'far fa-fw fa-file',
                        'active'      => ['admin/agenda/*']
                    ]);
                }
    
                if(auth()->user()->role == 'verifikator'){
                    $event->menu->addAfter('dashboard', [
                        'key'         => 'verifikasi',
                        'text'        => 'Verifikasi',
                        'url'         => 'admin/verifikasi',
                        'icon'        => 'far fa-fw fa-file',
                        'active'      => ['admin/verifikasi/*']
                    ]);
                }
    
                if(auth()->user()->role == 'pengelola'){
                    $event->menu->addAfter('dashboard', [
                        'key'         => 'pengelola',
                        'text'        => 'Pengelola',
                        'url'         => 'admin/pengelola',
                        'icon'        => 'far fa-fw fa-file',
                        'active'      => ['admin/pengelola/*']
                    ]);
                }
    
                if(auth()->user()->role == 'bud' || auth()->user()->role == 'kuasa-bud'){
                    $event->menu->addAfter('dashboard', [
                        'key'         => 'bud',
                        'text'        => 'Bud / Kuasa BUD',
                        'url'         => 'admin/bud',
                        'icon'        => 'far fa-fw fa-file',
                        'active'      => ['admin/bud/*']
                    ]);
                }
    
                // if(auth()->user()->role != 'admin'){
                //     $event->menu->remove('master');
                // }
            }else{
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
