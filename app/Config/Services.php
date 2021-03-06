<?php namespace Config;

use App\Models\ModelFactory;
use App\Models\UserModel;
use CodeIgniter\Config\Services as CoreServices;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Model;
use App\Models\LoginModel;

require_once SYSTEMPATH . 'Config/Services.php';

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends CoreServices
{
    /**
     * Singleton for UserModel
     *
     * @param bool $getShared
     *
     * @return ModelFactory
     */
    public static function models($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('models');
        }

        return new ModelFactory();
    }

    /**
     * Override Authentication lib so that we can use
     * our own UserModel.
     *
     * @param string     $lib
     * @param Model|null $userModel
     * @param Model|null $loginModel
     * @param bool       $getShared
     *
     * @return mixed
     */
    public static function authentication(string $lib = 'local', Model $userModel=null, Model $loginModel=null, bool $getShared = true)
    {
        if ($getShared)
        {
            return self::getSharedInstance('authentication', $lib, $userModel, $loginModel);
        }

        // config() checks first in app/Config
        $config = config('Auth');

        $class = $config->authenticationLibs[$lib];

        $instance = new $class($config);

        if (empty($userModel))
        {
            $userModel = new UserModel();
        }

        if (empty($loginModel))
        {
            $loginModel = new LoginModel();
        }

        return $instance
            ->setUserModel($userModel)
            ->setLoginModel($loginModel);
    }
}
