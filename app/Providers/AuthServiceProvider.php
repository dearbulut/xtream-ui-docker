<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Admin yetkisi
        Gate::define("admin", function ($user) {
            return $user->hasRole("admin");
        });

        // Moderatör yetkisi
        Gate::define("moderator", function ($user) {
            return $user->hasRole("moderator");
        });

        // Reseller yetkisi
        Gate::define("reseller", function ($user) {
            return $user->hasRole("reseller");
        });

        // Kullanıcı yönetimi
        Gate::define("manage_users", function ($user) {
            return $user->hasPermissionTo("manage_users");
        });

        // Rol yönetimi
        Gate::define("manage_roles", function ($user) {
            return $user->hasPermissionTo("manage_roles");
        });

        // Ayar yönetimi
        Gate::define("manage_settings", function ($user) {
            return $user->hasPermissionTo("manage_settings");
        });

        // Kanal yönetimi
        Gate::define("manage_channels", function ($user) {
            return $user->hasPermissionTo("manage_channels");
        });

        // Kategori yönetimi
        Gate::define("manage_categories", function ($user) {
            return $user->hasPermissionTo("manage_categories");
        });

        // EPG yönetimi
        Gate::define("manage_epg", function ($user) {
            return $user->hasPermissionTo("manage_epg");
        });

        // Bouquet yönetimi
        Gate::define("manage_bouquets", function ($user) {
            return $user->hasPermissionTo("manage_bouquets");
        });

        // Playlist yönetimi
        Gate::define("manage_playlists", function ($user) {
            return $user->hasPermissionTo("manage_playlists");
        });

        // Log görüntüleme
        Gate::define("view_logs", function ($user) {
            return $user->hasPermissionTo("view_logs");
        });
    }
}
