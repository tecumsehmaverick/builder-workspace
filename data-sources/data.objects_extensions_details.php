<?php

	require_once(TOOLKIT . '/class.datasource.php');

	Class datasourceobjects_extensions_details extends Datasource{

		public $dsParamROOTELEMENT = 'objects-extensions-details';
		public $dsParamURL = 'http://symphony-cms.com/download/extensions/view/{$url-show}/';
		public $dsParamXPATH = '//xhtml:div[@class = \'content\']';
		public $dsParamCACHE = '9999';
		public $dsParamTIMEOUT = '6';

		public $dsParamFILTERS = array(
				'xhtml' => 'http://www.w3.org/1999/xhtml',
		);
		public function __construct(&$parent, $env=NULL, $process_params=true){
			parent::__construct($parent, $env, $process_params);
			$this->_dependencies = array();
		}

		public function about(){
			return array(
					 'name' => 'Objects - Extensions - Details',
					 'author' => array(
							'name' => 'Marco Sampellegrini',
							'email' => 'm@rcosa.mp'),
					 'version' => '1.0',
					 'release-date' => '2010-05-09T08:45:42+00:00');
		}

		public function getSource(){
			return 'dynamic_xml';
		}

		public function allowEditorToParse(){
			return true;
		}

		public function grab(&$param_pool=NULL){
			$result = new XMLElement($this->dsParamROOTELEMENT);

			try{
				include(TOOLKIT . '/data-sources/datasource.dynamic_xml.php');
			}
			catch(FrontendPageNotFoundException $e){
				// Work around. This ensures the 404 page is displayed and
				// is not picked up by the default catch() statement below
				FrontendPageNotFoundExceptionHandler::render($e);
			}
			catch(Exception $e){
				$result->appendChild(new XMLElement('error', $e->getMessage()));
				return $result;
			}

			if($this->_force_empty_result) $result = $this->emptyXMLSet();
			return $result;
		}
	}

