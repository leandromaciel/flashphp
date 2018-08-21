<?php
namespace NotifyMe\Core;

use NotifyMe\Singleton\Smarty_Singleton;
use NotifyMe\Singleton\Core_Singleton;

class Router {

	public $ENTITY_ALIAS = 'router';
	
	private $Core;

	protected $Data;
    protected $Settings;

	protected $BaseUrl;
    protected $LastURL;

	protected $ClassPath;
	protected $Controller;
	protected $Method;
	protected $Params = [];

	private $Smarty;

	public function __construct(array $settingsData = null) {

		if ( !is_null($settingsData) ) {

			$this->Core = Core_singleton::getInstance();
			$Language = $this->Core->getLanguage();

			$this->setSettings($settingsData);
			$this->setData($settingsData, $Language);

			$this->Smarty = Smarty_Singleton::getInstance();
			$this->setBaseUrl($this->Smarty->getBaseUrl());
		}
	}

    public function setSettings(array $settingsData) {
        $this->Settings = $settingsData;
    }

    public function getSettings() {
        return $this->Settings;
    }

	public function setData(array $settingsData, Language $Language) {

		/** vars used inside of Routes.php */
		$languageData = $Language->getData();

		$controller = $languageData['router']['controller'];
		$method = $languageData['router']['method'];

		require_once($settingsData['dir'].'Routes.php');

		$this->Data = $routes;

		/** end */
	}

	public function getData() {
		return $this->Data;
	}

	public function setBaseUrl($baseUrl) {
		$this->BaseUrl = $baseUrl;
	}

	public function getBaseUrl() {
		return $this->BaseUrl;
	}

	public function setClassPath($classPath) {
		$this->ClassPath = $classPath;
	}

	public function getClassPath() {
		return $this->ClassPath;
	}

	public function setController($controller) {
		$this->Controller = $controller;
	}

	public function getController() {
		return $this->Controller;
	}

	public function setMethod($method) {
		$this->Method = $method;
	}

	public function getMethod() {
		return $this->Method;
	}

	public function setParams(array $params) {
		krsort($params);
		foreach ( $params as $parameter ) {
			$this->Params[] = $parameter;
		}
	}

	public function getParams() {
		return $this->Params;
	}

    public function configureRoute() {
		$originalRoute = $this->getOriginalRoute();

		$segments = explode('/', $originalRoute);

		$controllerNamespace = '\\NotifyMe\\Controller\\'.APPLICATION.'\\'.$segments[0];
		
		$this->setController($controllerNamespace);
		$this->setMethod($segments[1]);
		$this->setClassPath(CONTROLLER_PATH.$segments[0].'.php');
	}

	public function getOriginalRoute() {

		$this->validateBaseUrl();

        $queryString = $_SERVER['QUERY_STRING'];

		if ( strlen($queryString) > 0 ) {
			$segments = explode('/', $queryString);
			$originalRoute = $this->defineOriginalRoute($segments);

            if ( $originalRoute === NULL ) {
                $settings = $this->getSettings();
                $this->redirect($settings['error_404']);
            }
		} else {
			$originalRoute = DEFAULT_CONTROLLER;
		}

		return $originalRoute;
	}

	public function validateBaseUrl() {

		$requestURI = explode('/', $_SERVER['REQUEST_URI']);

		$baseURL = $_SERVER['HTTP_HOST'].'/'.$requestURI[1].'/';

		if ( strstr($this->getBaseUrl(), $baseURL) === FALSE ) {
			$settings = $this->getSettings();

            $this->redirect($settings['error_403']);
		}

		return true;
	}

	public function defineOriginalRoute(array $segments) {

		$finalSegment = count($segments) - 1;
		$params = [];

		foreach ( $segments as $index => $queryString ) {

			if ( $index >= 1 ) {
				$foundRoute = $this->findOriginalRoute($segments);

				if ( $foundRoute === FALSE ) {
					$params[] = $segments[$finalSegment];
					$segments[$finalSegment] = '(:param)';
					$finalSegment--;
				} else {
					$this->setParams($params);
					return $foundRoute;
				}
			}
		}

		return null;
	}

	public function findOriginalRoute(array $segments) {
		$route = null;

		for ( $i = 1; $i < count($segments); $i++ ) {
			$route.= $segments[$i].'/';
		}

		$route = rtrim($route, '/');

		if ( isset($this->Data[$route]) ) {
			return $this->Data[$route];
		} else {
			return false;
		}
	}

	function redirect($route, $directLocation = false) {

        if ( $directLocation === FALSE ) {
            $foundKey = array_search($route, $this->Data);

            if ( $foundKey !== FALSE ) {
                header("Location: {$this->getBaseUrl()}{$foundKey}", true, 302);
                exit;
            } else {
                header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                exit;
            }
        } else {
            header("Location: {$this->getBaseUrl()}{$route}", true, 302);
            exit;
        }
    }

    function setLastURL() {
		$this->Core = Core_Singleton::getInstance();
		$Security = $this->Core->getSecurity();

        $Security->registerSession($this->ENTITY_ALIAS, array('LastURL' => trim($_SERVER['QUERY_STRING'], '/')));
    }

    function getLastURL() {
		$this->Core = Core_Singleton::getInstance();
		$Security = $this->Core->getSecurity();

        $lastURL = $Security->getSessionData($this->ENTITY_ALIAS, 'LastURL');
        return $lastURL['LastURL'];
    }
}