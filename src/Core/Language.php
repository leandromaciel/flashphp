<?php
namespace NotifyMe\Core;

class Language {

    protected $LanguageFiles;
	protected $Idiom;
    protected $FilePath;
    protected $Data;

    public function __construct(array $settingsData = null, $sessionName) {

		if ( !is_null($settingsData) ) {
            $this->setLanguageFiles($settingsData['files']);
            $this->setIdiom($sessionName);
            $this->defineLanguageData($settingsData['dir']);
        }
	}

	public function setFilePath(string $filePath) {
		$this->FilePath = $filePath;
	}

	public function getFilePath():string {
		return $this->FilePath;
	}

    public function setLanguageFiles(array $files) {
        $this->LanguageFiles = $files;
    }

    public function getLanguageFiles():array {
        return $this->LanguageFiles;
    }

	public function setData(array $data) {
		$this->Data = $data;
	}

	public function getData():array {
		return $this->Data;
	}

    public function setIdiom(string $sessionName) {
        if ( isset($_COOKIE[$sessionName.'_language']) ) {
            $this->Idiom = $_COOKIE[$sessionName.'_language'];
        } else {
            $languageFiles = $this->getLanguageFiles();
            $this->Idiom = $languageFiles[0];
        }
    }

    public function getIdiom():string {
        return $this->Idiom;
    }

	public function defineLanguageData($dir):array {

        $idiom = $this->getIdiom();
		$this->setFilePath($dir.$idiom.'.php');

		require_once($this->getFilePath());

		$this->setData($language);

		return $this->getData();
	}

    public function getSettings(string $setting):string {
        if ( isset($this->Data['settings'][$setting]) ) {
            return $this->Data['settings'][$setting];
        } else {
            return $setting;
        }
    }

	public function getWord(string $word):string {
		if ( isset($this->Data['word'][$word]) ) {
			return $this->Data['word'][$word];
		} else {
			return $word;
		}
	}

	public function getText(string $text):string {
		if ( isset($this->Data['text'][$text]) ) {
			return $this->Data['text'][$text];
		} else {
			return $text;
		}
	}

	public function getAction(string $action):string {
		if ( isset($this->Data['action'][$action]) ) {
			return $this->Data['action'][$action];
		} else {
			return $action;
		}
	}

	public function getMessage(string $message):string {
		if ( isset($this->Data['message'][$message]) ) {
			return $this->Data['message'][$message];
		} else {
			return $message;
		}
	}

	public function getController(string $controller):string {
		if ( isset($this->Data['router']['controller'][$controller]) ) {
			return $this->Data['router']['controller'][$controller];
		} else {
			return $controller;
		}
	}

	public function getMethod(string $method):string {
		if ( isset($this->Data['router']['method'][$method]) ) {
			return $this->Data['router']['method'][$method];
		} else {
			return $method;
		}
	}
}