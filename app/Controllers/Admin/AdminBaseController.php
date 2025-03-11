<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class AdminBaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];
    protected $appConfig;
    protected $activeTheme;
    public $data;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data['user_data'] =  getCurrentUser();
        $this->data['breadcrumbs'] = [['name' => lang('Admin.dashboard'), 'url' => site_url()]];
       
    }
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        if (get_setting('developer_mode') == 1) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        } else {
            error_reporting(0);
            ini_set('display_errors', '0');
        }



        parent::initController($request, $response, $logger);

        // Load theme config
        //config('Themes');
        // Preload any models, libraries, etc, here.
        $this->appConfig = config('App');
        // E.g.: $this->session = \Config\Services::session();

    }

    protected function renderThemeView($view, $data = [], $return = false)
    {
        $themeViewPath = ROOTPATH . 'themes/' . ACTIVE_THEME . '/views/' . $view . '.php';
        return view($themeViewPath, $data, ['saveData' => true], $return);
    }
}
