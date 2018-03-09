<?php namespace GivingTeam\Auth\Tests;

use App;
use Illuminate\Foundation\AliasLoader;
use PluginTestCase as BasePluginTestCase;
use RainLab\User\Models\Settings as UserSettings;

class PluginTestCase extends BasePluginTestCase
{
    protected $refreshPlugins = [
        'GivingTeam.Auth',
    ];

    public function createApplication()
    {
        $app = parent::createApplication();

        require __DIR__.'/../routes.php';

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        // register the Auth facade in our test environment
        $alias = AliasLoader::getInstance();
        $alias->alias('Auth', 'RainLab\User\Facades\Auth');

        // reset modified settings
        UserSettings::resetDefault();
        UserSettings::set('activate_mode', 'auto');
        UserSettings::set('allow_registration', true);
    
        App::singleton('user.auth', function() {
            return \RainLab\User\Classes\AuthManager::instance();
        });
    }
}