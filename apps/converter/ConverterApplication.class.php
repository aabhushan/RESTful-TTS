<?php
Library::import('recess.framework.Application');

class ConverterApplication extends Application {
	public function __construct() {
		
		$this->name = 'Text-to-speech';
		
		$this->viewsDir = $_ENV['dir.apps'] . 'converter/views/';
		
		$this->assetUrl = $_ENV['url.base'] . 'apps/converter/public/';
		
		$this->modelsPrefix = 'converter.models.';
		
		$this->controllersPrefix = 'converter.controllers.';
		
		$this->routingPrefix = 'converter/';
				
	}
}
?>