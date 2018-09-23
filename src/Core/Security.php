<?php
namespace FlashPHP\Core;

use Aura\Session\Session;
use Aura\Session\SessionFactory;
use FlashPHP\Singleton\Core_Singleton;
use FlashPHP\Model\Backend\User_Model;

class Security {

	protected $Session_Factory;
	protected $Session;
	protected $Segment;
	protected $csrfTokenName;
	protected $csrfTokenValue;

	protected $SessionName;
	protected $SessionEntity;
	protected $SessionEntityField;

    public function __construct(array $settingsData = null) {

        if ( !is_null($settingsData) ) {
			$this->setup($settingsData);
		}
	}

	public function setup(array $settingsData) {

		$this->setSessionName($settingsData['session_name']);
		$this->setSessionEntity($settingsData['session_entity']);
		$this->setSessionEntityField($settingsData['session_entity_field']);

        $this->setSessionFactory();
        $this->setSession();
        $this->getSegment();

		if ( $settingsData['csrf_token'] === true ) {
			$this->setCsrfTokenName($settingsData['csrf_token_name']);
			$this->setCsrfTokenValue();
		}
	}


	public function setSessionName($name) {
		$this->SessionName = $name;
	}


	public function getSessionName() {
		return $this->SessionName;
	}


	public function setSessionEntity($entity) {
		$this->SessionEntity = $entity;
	}


	public function getSessionEntity() {
		return $this->SessionEntity;
	}


	public function setSessionEntityField($field) {
		$this->SessionEntityField = $field;
	}


	public function getSessionEntityField() {
		return $this->SessionEntityField;
	}


	public function setSessionFactory() {
		$this->Session_Factory = new SessionFactory();
	}


	public function getSessionFactory() {
		if ( $this->Session_Factory instanceof SessionFactory ) {
			return $this->Session_Factory;
		}

		return null;
	}


	public function setSession() {

		$sessionFactory = $this->getSessionFactory();

		if ($sessionFactory !== NULL) {
			$this->Session = $sessionFactory->newInstance($_COOKIE);
		}
	}


	public function getSession() {
		if ( $this->Session instanceof Session) {
			return $this->Session;
		}

		return null;
	}


	public function getSegment() {
        if ( $this->Segment === NULL ) {
            $name = $this->getSessionName();
            $session = $this->getSession();

            if ( $session !== NULL ) {
                $this->Segment = $session->getSegment($name);
                return $this->Segment;
            } else {
                return null;
            }
        } else {
            return $this->Segment;
        }
    }


	public function setCsrfTokenName($name) {
		$this->csrfTokenName = $name;
	}


	public function getCsrfTokenName() {
		return $this->csrfTokenName;
	}


	public function setCsrfTokenValue() {

		if ( $this->getSession() !== NULL ) {
			$this->csrfTokenValue = $this->Session->getCsrfToken()->getValue();
		} else {
			$this->csrfTokenValue = null;
		}
	}


	public function getCsrfTokenValue() {
		return $this->csrfTokenValue;
	}


	public function validateCsrfToken() {

		$validToken = false;

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'DELETE' ) {

			if ( isset($_POST[$this->csrfTokenName]) ) {
				$csrf_value = $_POST[$this->csrfTokenName];

				$validation = $this->Session->getCsrfToken();

				if ( $validation->isValid($csrf_value) ) {
					$validToken =  true;
				}
			}
		}

		if ( $validToken === FALSE ) {
			$Core = Core_Singleton::getInsance();
			$Router = $Core->getRouter();
			
			$routerSettings = $Router->getSettings();
            $Router->redirect($routerSettings['error_403']);
		} else {
			return $validToken;
		}
	}


	public function validateSession($redirect = true, $name = null, $entity = null, $field = null) {
		if ( $name !== NULL ) {
			$this->setSessionName($name);
		}

		if ( $entity !== NULL ) {
			$this->setSessionEntity($entity);
		}

		if ( $field !== NULL ) {
			$this->setSessionEntityField($field);
		}

		$name = $this->getSessionName();
		$entity = $this->getSessionEntity();
		$field = $this->getSessionEntityField();

        $session = $this->getSession();

        if ( $session !== NULL ) {
            $this->Segment = $session->getSegment($name);

            if ($this->Segment !== NULL) {
                $validSession = $this->Segment->get($entity);

                if ( isset($validSession[$field]) ) {
                    return $validSession[$field];
                }
            }
        }

		if ( $redirect === true ) {
			$Core = Core_Singleton::getInsance();
			$Router = $Core->getRouter();
			
			$Router->redirect(DEFAULT_CONTROLLER);
		}

		return null;
	}


	public function registerSession($entity, array $sessionData) {

        $name = $this->getSessionName();

        $session = $this->getSession();

        if ( $session !== NULL ) {
            $this->Segment = $session->getSegment($name);
            $this->Segment->set($entity, $sessionData);
        } else {
            $this->Segment = null;
        }

	}

    public function getSessionData($entity) {
        $name = $this->getSessionName();

        $session = $this->getSession();

        if ( $session !== NULL ) {
            $this->Segment = $session->getSegment($name);
            return $this->Segment->get($entity);
        }

        return null;
    }


	public function destroySession() {
		$session = $this->getSession();
		$session->destroy();

		return true;
	}


	public function clearSession() {
        $this->getSegment();
		$session = $this->getSession();

		$session->clear();

		return true;
	}

    public function registerFlashData($entity, array $sessionData) {

        $name = $this->getSessionName();

        $session = $this->getSession();

        if ( $session !== NULL ) {
            $this->Segment = $session->getSegment($name);
            $this->Segment->setFlash($entity, $sessionData);
        } else {
            $this->Segment = null;
        }
    }

    public function getFlashData($entity) {
        $name = $this->getSessionName();

        $session = $this->getSession();

        if ( $session !== NULL ) {
            $this->Segment = $session->getSegment($name);
            return $this->Segment->getFlash($entity);
        }

        return null;
	}
	
	public function validateRequestMethod(string $requestMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $requestMethod) {
            header("HTTP/1.0 405 Method Not Allowed");
            return false;
        } else {
            return true;
        }    
    }

    public function displayRestHeaders() {
		header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	}
	
	public function validateCredentials() {
		$userData = json_decode(file_get_contents("php://input"));
		$UserModel = new User_Model();

		$isAuthorized = false;

		if ( isset($userData->CSRF_TOKEN_VALUE) ) {
			$isAuthorized = $UserModel->validateSecurityHash($userData);
		}
		
		return $isAuthorized;
	}
}