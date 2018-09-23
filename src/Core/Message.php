<?php
namespace FlashPHP\Core;

use FlashPHP\Singleton\Core_Singleton;

class Message {

    public $ENTITY_ALIAS = 'message';

    private $Core;
    private $LanguageData;

	public $Data;

	public function __construct(array $settingsData = null) {

        $this->Core = Core_Singleton::getInstance();
        $Language = $this->Core->getLanguage();

		$this->LanguageData = $Language->getData();


		if ( !is_null($settingsData) ) {
			$this->setMessageConfig($settingsData);
		}
	}

	public function setData($data) {
		$this->Data = $data;
	}

	public function getData() {
		return $this->Data;
	}

	private function setMessageConfig(array $settingsData) {

	}

	public function setMessage($type, $message) {
        $this->Data[$type][] = $this->getMessage($message);
        
        $Security = $this->Core->getSecurity();
        $Security->registerFlashData($this->ENTITY_ALIAS, $this->Data);
	}

    public function getMessage($message) {

		if ( isset($this->LanguageData['message'][$message]) ) {
			return $this->LanguageData['message'][$message];
		} else {
			return $message;
		}
	}
}