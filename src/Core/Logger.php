<?php
namespace NotifyMe\Core;

class Logger {

	public $Log;
	protected $output;
	protected $file;
	protected $mode;
	protected $timeFormat;

	public function __construct(array $settingsData = null) {

		if ( $settingsData !== NULL ) {
			$this->setOutput($settingsData['output']);
			$this->setFile($settingsData['file_name']);
			$this->setMode($settingsData['mode']);
			$this->setTimeFormat($settingsData['timeFormat']);
		}
	}

	public function setOutput($output) {
		$this->output = $output;
	}

	public function setFile($file) {
		$this->file = $file;
	}

	public function setMode($mode) {
		$this->mode = $mode;
	}

	public function setTimeFormat($timeFormat) {
		$this->timeFormat = $timeFormat;
	}

	public function registerLog ($type, array $logData) {
		$conf = array('mode' => $this->mode, 'timeFormat' => $this->timeFormat);

		$this->Log = \Log::singleton($this->output, LOG_PATH.$this->file, $type, $conf);

		$this->Log->log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>');

		foreach ( $logData as $key => $value ) {
			$this->Log->log("[{$key}] => {$value}");
		}

		$this->Log->log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>');
	}
}
