<?php
App::uses('Component', 'Controller');
class OCAComponent extends Component {

	public function __construct(){
		$this->tracking = 'http://webservice.oca.com.ar/oep_tracking/Oep_Track.asmx?WSDL';
	}

	public function tracking($d = array()){
		$requestParams = array(
			// Campos innecesarios
			// 'NroDocumentoCliente' => $d['NroDocumentoCliente'], 
			// 'CUIT' => $d['CUIT'],
			'Pieza' => $d['Pieza']
		);
		$call = new SoapClient($this->tracking);
		$response = $call->Tracking_Pieza($requestParams);
		return $response;
	}
}