<?php namespace App\Core;

use App\Theme\MetaCollection;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;

/**
 * Class AdminController
 *
 * Provides a common set of functions that can be used in any controllers
 * that need to display any themed views.
 *
 * Provides a MetaCollection instance for handling the meta tags for the page.
 *
 * @package Bonfire\Controllers
 */
class AdminController extends BaseController
{
    use ThemeTrait;

    /**
     * @var MetaCollection
     */
    protected $meta;

    /**
     * @var Modules
     */
    protected $modules;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Ensure our site-wide helpers are loaded without messing up per-controller settings.
        $this->helpers = array_merge($this->helpers, ['asset', 'auth']);
        $this->meta = new MetaCollection();

        parent::initController($request, $response, $logger);

        // Ensure our menus get built for each module.
        $this->modules = new Modules();
        $this->modules->initAdmin();

        $this->theme = 'admin';
        $this->setVar('currentUser', user());
        $this->setVar('mainMenu', Menus::get('admin'));
    }
}
