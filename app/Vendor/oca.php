<?php
class Oca
{
	const VERSION				= '0.1';
	protected $cuit				= '';
	protected $webservice_url	= 'webservice.oca.com.ar';
	
	// =========================================================================
	
	function __construct($params = array())
	{
		foreach ($params as $param => $value)
		{
			$this->{$param} = $value;
		}
	}
	
	// =========================================================================
	
	/**
	 * Sets the useragent for PHP to use
	 * 
	 * @return string
	 */
	public function setUserAgent()
	{
		return 'OCA-PHP-API ' . self::VERSION . ' - github.com/juanchorossi/OCA-PHP-API';
	}
	
	// =========================================================================
	
	/**
	 * Devuelve todos los Centros de Imposición existentes cercanos al CP
	 * 
	 * @param integer $CP Código Postal
	 * @return type 
	 */
	public function getCentrosImposicionPorCP($CP = NULL)
	{
		if ( ! $CP) return;
		
		$ch = curl_init();
		
		curl_setopt_array($ch,	array(	CURLOPT_RETURNTRANSFER	=> TRUE,
										CURLOPT_HEADER			=> FALSE,
										CURLOPT_USERAGENT		=> $this->setUserAgent(),
										CURLOPT_CONNECTTIMEOUT	=> 5,
										CURLOPT_POST			=> TRUE,
										CURLOPT_POSTFIELDS		=> 'CodigoPostal='.(int)$CP,
										CURLOPT_URL				=> "{$this->webservice_url}/oep_tracking/Oep_Track.asmx/GetCentrosImposicionPorCP",
										CURLOPT_FOLLOWLOCATION	=> TRUE));

		$dom = new DOMDocument();
		@$dom->loadXML(curl_exec($ch));
		$xpath = new DOMXpath($dom);
	
		$c_imp = array();
		foreach (@$xpath->query("//NewDataSet/Table") as $ci)
		{
			if(!$ci->getElementsByTagName('Piso')->item(0)){
				CakeLog::write('error', 'http://webservice.oca.com.ar/oep_tracking/Oep_Track.asmx/GetCentrosImposicionPorCP ' . var_export($ci->getAttribute('diffgr:id'), true));
			}
			$c_imp[] = array(	'idCentroImposicion'	=> $ci->getElementsByTagName('idCentroImposicion')->item(0)->nodeValue,
								'IdSucursalOCA'			=> $ci->getElementsByTagName('IdSucursalOCA')->item(0)->nodeValue,
								'Sigla'					=> $ci->getElementsByTagName('Sigla')->item(0)->nodeValue,
								'Descripcion'			=> $ci->getElementsByTagName('Descripcion')->item(0)->nodeValue,
								'Calle'					=> $ci->getElementsByTagName('Calle')->item(0)->nodeValue,
								'Numero'				=> $ci->getElementsByTagName('Numero')->item(0)->nodeValue,
								'Torre'					=> $ci->getElementsByTagName('Torre')->item(0)->nodeValue,
								'Piso'					=> @$ci->getElementsByTagName('Piso')->item(0)->nodeValue,
								'Depto'					=> @$ci->getElementsByTagName('Depto')->item(0)->nodeValue,
								'Localidad'				=> $ci->getElementsByTagName('Localidad')->item(0)->nodeValue,
								'IdProvincia'			=> $ci->getElementsByTagName('IdProvincia')->item(0)->nodeValue,
								'idCodigoPostal'		=> $ci->getElementsByTagName('idCodigoPostal')->item(0)->nodeValue,
								'Telefono'				=> @$ci->getElementsByTagName('Telefono')->item(0)->nodeValue,
								'eMail'					=> $ci->getElementsByTagName('eMail')->item(0)->nodeValue,
								'Provincia'				=> $ci->getElementsByTagName('Provincia')->item(0)->nodeValue,
								'CodigoPostal'			=> $ci->getElementsByTagName('CodigoPostal')->item(0)->nodeValue
							);
		}
		
		return $c_imp;
	}
	
	// =========================================================================
	
	/**
	 * Devuelve todos los Centros de Imposición existentes
	 * 
	 * @return array $c_imp
	 */
	public function getCentrosImposicion()
	{
		$ch = curl_init();
		
		curl_setopt_array($ch,	array(	CURLOPT_RETURNTRANSFER	=> TRUE,
										CURLOPT_HEADER			=> FALSE,
										CURLOPT_CONNECTTIMEOUT	=> 5,
										CURLOPT_USERAGENT		=> $this->setUserAgent(),
										CURLOPT_URL				=> "{$this->webservice_url}/oep_tracking/Oep_Track.asmx/GetCentrosImposicion",
										CURLOPT_FOLLOWLOCATION	=> TRUE));

		$dom = new DOMDocument();
		@$dom->loadXML(curl_exec($ch));
		$xpath = new DOMXpath($dom);
	
		$c_imp = array();
		foreach (@$xpath->query("//NewDataSet/Table") as $ci)
		{
			$c_imp[] = array(	'idCentroImposicion'	=> $ci->getElementsByTagName('idCentroImposicion')->item(0)->nodeValue,
								'Sigla'					=> $ci->getElementsByTagName('Sigla')->item(0)->nodeValue,
								'Descripcion'			=> $ci->getElementsByTagName('Descripcion')->item(0)->nodeValue,
								'Calle'					=> $ci->getElementsByTagName('Calle')->item(0)->nodeValue,
								'Numero'				=> $ci->getElementsByTagName('Numero')->item(0)->nodeValue,
								'Piso'					=> $ci->getElementsByTagName('Piso')->item(0)->nodeValue,
								'Localidad'				=> $ci->getElementsByTagName('Localidad')->item(0)->nodeValue,
							);
		}
		
		return $c_imp;
	}
	
	// =========================================================================

	/**
	 * Tarifar un Envío Corporativo
	 *
	 * @param string $PesoTotal
	 * @param string $VolumenTotal
	 * @param string $CodigoPostalOrigen
	 * @param string $CodigoPostalDestino
	 * @param string $CantidadPaquetes
	 * @param string $ValorDeclarado
	 * @param string $Cuit
	 * @param string $Operativa 
	 *
	 * Resultado: (XML) conteniendo el tipo de tarifador y el precio del envío.
	 */
	public function tarifarEnvioCorporativo($PesoTotal, $VolumenTotal, $CodigoPostalOrigen, $CodigoPostalDestino, $CantidadPaquetes, $ValorDeclarado, $Cuit, $Operativa)
	{
		$_query_string = array(	'PesoTotal'				=> $PesoTotal,
								'VolumenTotal'			=> $VolumenTotal,
								'CodigoPostalOrigen'	=> $CodigoPostalOrigen,
								'CodigoPostalDestino'	=> $CodigoPostalDestino,
								'CantidadPaquetes'		=> $CantidadPaquetes,
								'ValorDeclarado'		=> $ValorDeclarado,
								'Cuit'					=> $Cuit,
								'Operativa'				=> $Operativa);

		$ch = curl_init();
		
		curl_setopt_array($ch,	array(	CURLOPT_RETURNTRANSFER	=> TRUE,
										CURLOPT_HEADER			=> FALSE,
										CURLOPT_USERAGENT		=> $this->setUserAgent(),
										CURLOPT_CONNECTTIMEOUT	=> 5,
										CURLOPT_POST			=> TRUE,
										CURLOPT_POSTFIELDS		=> http_build_query($_query_string),
										CURLOPT_URL				=> "{$this->webservice_url}/epak_tracking/Oep_TrackEPak.asmx/Tarifar_Envio_Corporativo",
										CURLOPT_FOLLOWLOCATION	=> TRUE));

		$dom = new DOMDocument();
		$result = curl_exec($ch);
		@$dom->loadXML($result);
		$xpath = new DOMXpath($dom);

		$e_corp = array();
		foreach (@$xpath->query("//NewDataSet/Table") as $envio_corporativo)
		{
			$e_corp[] = array(	'Tarifador'		=> $envio_corporativo->getElementsByTagName('Tarifador')->item(0)->nodeValue,
								'Precio'		=> $envio_corporativo->getElementsByTagName('Precio')->item(0)->nodeValue,
								'Ambito'		=> $envio_corporativo->getElementsByTagName('Ambito')->item(0)->nodeValue,
								'PlazoEntrega'	=> $envio_corporativo->getElementsByTagName('PlazoEntrega')->item(0)->nodeValue,
								'Adicional'		=> $envio_corporativo->getElementsByTagName('Adicional')->item(0)->nodeValue,
								'Total'			=> $envio_corporativo->getElementsByTagName('Total')->item(0)->nodeValue,
							);
		}
		
		return $e_corp;
	}

	/**
	 * Obtener lista de Provincias 
	 * Resultado: array $e_prov
	 */
	public function getProvincias()
	{
		$ch = curl_init();
		curl_setopt_array($ch,	array(	CURLOPT_RETURNTRANSFER	=> TRUE,
						CURLOPT_HEADER		=> FALSE,
						CURLOPT_CONNECTTIMEOUT	=> 5,
						CURLOPT_USERAGENT	=> $this->setUserAgent(),
						CURLOPT_URL		=> "{$this->webservice_url}/oep_tracking/Oep_Track.asmx/GetProvincias",
						CURLOPT_FOLLOWLOCATION	=> TRUE));
		$dom = new DOMDocument();
		@$dom->loadXml(curl_exec($ch));
		$xpath = new DOMXPath($dom);
		
		$e_prov = array();
		foreach (@$xpath->query("//Provincias/Provincia") as $provincia) {
			$e_prov[] = array( 
				'id' => $provincia->getElementsByTagName('IdProvincia')->item(0)->nodeValue,
				'provincia' => $provincia->getElementsByTagName('Descripcion')->item(0)->nodeValue, 
			);
		}
		
		return $e_prov;
	}

	/**
	 * Lista de localidades de una provincia
	 * @param string $idProvincia
	 */
	public function getLocalidadesByProvincia($idProvincia)
	{
		$_query_string = array(	'idProvincia' => $idProvincia );
		
		$ch = curl_init();
		curl_setopt_array($ch,	array(	CURLOPT_RETURNTRANSFER	=> TRUE,
						CURLOPT_HEADER		=> FALSE,
						CURLOPT_CONNECTTIMEOUT	=> 5,
						CURLOPT_POSTFIELDS	=> http_build_query($_query_string),
						CURLOPT_USERAGENT	=> $this->setUserAgent(),
						CURLOPT_URL		=> "{$this->webservice_url}/oep_tracking/Oep_Track.asmx/GetLocalidadesByProvincia",
						CURLOPT_FOLLOWLOCATION	=> TRUE));
		$dom = new DOMDocument();
		$dom->loadXml(curl_exec($ch));
		$xpath = new DOMXPath($dom);
		
		$e_loc = array();
		foreach (@$xpath->query("//Localidades/Provincia") as $provincia) {
			$e_loc[] = array( 'localidad'=> $provincia->getElementsByTagName('Nombre')->item(0)->nodeValue );
		}
		return $e_loc;
	}

	private function normaliza($cadena){
	    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	    $cadena = utf8_decode($cadena);
	    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
	    $cadena = strtolower($cadena);
	        $cadena = preg_replace('/[^a-z0-9 -]+/', '', $cadena);

	    return utf8_encode($cadena);
	}

	public function ingresoOR($nroremito,$apellido,$nombre,$calle,$nro,$piso,$depto,$cp,$localidad,$provincia,$telefono,$email,$alto,$ancho,$largo,$peso,$valor){
		$apellido 	= $this->normaliza($apellido);
		$nombre 	= $this->normaliza($nombre);
		$calle 		= $this->normaliza($calle);
		$depto 		= $this->normaliza($depto);
		$localidad 	= $this->normaliza($localidad);
		$provincia 	= $this->normaliza($provincia);
		$email 		= $this->normaliza($email);
		$idOperativa = 396726; //396726;  96637;
		$XML_Retiro = '<ROWS><cabecera ver="1.0" nrocuenta="187915/000" /><retiro calle="9 DE JULIO" nro="234" piso="-" depto="-" cp="1708" localidad="MORON" provincia="BUENOS AIRES" contacto="PAOLA BLANCO" email="ventasonline@chatelet.com.ar" solicitante="PAOLA BLANCO" observaciones="Ninguna" centrocosto="0" /><envios><envio idoperativa="'.$idOperativa.'" nroremito="'.$nroremito.'"><destinatario apellido="'.$apellido.'" nombre="'.$nombre.'" calle="'.$calle.'" nro="'.$nro.'" piso="'.$piso.'" depto="'.$depto.'" cp="'.$cp.'" localidad="'.$localidad.'" provincia="'.$provincia.'" telefono="'.$telefono.'" email="'.$email.'" idci="0" celular="'.$telefono.'"/><paquetes><paquete alto="'.$alto.'" ancho="'.$ancho.'" largo="'.$largo.'" peso="'.$peso.'" valor="'.$valor.'" cant="1"/></paquetes></envio></envios></ROWS>';
		$query_data = "usr=ventasonline@chatelet.com.ar&psw=provee004&XML_Retiro=$XML_Retiro&ConfirmarRetiro=True&DiasRetiro=14&FranjaHoraria=1";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://webservice.oca.com.ar/epak_tracking/Oep_TrackEPak.asmx/IngresoORMultiplesRetiros");
		curl_setopt($ch, CURLOPT_POST, 1);	                            
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		//

		$xml = curl_exec($ch);
		$OrdenRetiro = @$this->getTextBetweenTags( 'OrdenRetiro' , $xml , 1 );
		
		return $OrdenRetiro;
	}

	public function ingresoORNuevo($nrocuenta, $idoperativa, $usr, $psw, $nroremito,$apellido,$nombre,$calle,$nro,$piso,$depto,$cp,$localidad,$provincia,$telefono,$email,$alto,$ancho,$largo,$peso,$valor) {
		$apellido 	= $this->normaliza($apellido);
		$nombre 	= $this->normaliza($nombre);
		$calle 		= $this->normaliza($calle);
		$depto 		= $this->normaliza($depto);
		$localidad 	= $this->normaliza($localidad);
		$provincia 	= $this->normaliza($provincia);
		$email 		= $this->normaliza($email);

		$XML_Retiro = '<ROWS><cabecera ver="2.0" nrocuenta="'.$nrocuenta.'" /><origenes>';
		$XML_Retiro.= '<origen calle="9 DE JULIO" nro="234" piso="" depto="" cp="1708"';
		$XML_Retiro.= ' localidad="MORON" provincia="BUENOS AIRES" contacto="PAOLA BLANCO"';
		$XML_Retiro.= ' email="ventasonline@chatelet.com.ar" solicitante="PAOLA BLANCO"';
		$XML_Retiro.= ' observaciones="Ninguna" centrocosto="0" idfranjahoraria="1"';
		$XML_Retiro.= ' idcentroimposicionorigen="113" fecha="'.date("Ymd").'"><envios>';
		$XML_Retiro.= ' <envio idoperativa="'.$idoperativa.'" nroremito="'.$nroremito.'">';
		$XML_Retiro.= ' <destinatario apellido="'.$apellido.'" nombre="'.$nombre.'" calle="'.$calle.'"';
		$XML_Retiro.= ' nro="'.$nro.'" piso="'.$piso.'" depto="'.$depto.'" cp="'.$cp.'"';
		$XML_Retiro.= ' localidad="'.$localidad.'" provincia="'.$provincia.'" telefono="'.$telefono.'"';
		$XML_Retiro.= ' email="'.$email.'" idci="113" celular="'.$telefono.'"/><paquetes>';
		$XML_Retiro.= '<paquete alto="'.$alto.'" ancho="'.$ancho.'" largo="'.$largo.'" peso="'.$peso.'"';
		$XML_Retiro.= ' valor="'.$valor.'" cant="1"/></paquetes></envio></envios></origen></origenes></ROWS>';

		$query_data = "usr=".$usr."&psw=".$psw."&xml_Datos=$XML_Retiro&ConfirmarRetiro=True&ArchivoCliente=&ArchivoProceso=";//DiasRetiro=14&FranjaHoraria=1";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://webservice.oca.com.ar/epak_tracking/Oep_TrackEPak.asmx/IngresoORMultiplesRetiros");
		curl_setopt($ch, CURLOPT_POST, 1);	                            
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$xml = curl_exec($ch);
		$OrdenRetiro = @$this->getTextBetweenTags( 'OrdenRetiro' , $xml , 1 );

		$xml = curl_exec($ch); //die($xml);
		$OrdenRetiro = @$this->getTextBetweenTags( 'OrdenRetiro' , $xml , 1 );
		$nroEnvio = @$this->getTextBetweenTags( 'NumeroEnvio' , $xml , 1 );
//              die($nroEnvio);
		return ['retiro'=>$OrdenRetiro, 'tracking'=>$nroEnvio, 'rawXML' => $xml];

	
		
		return $OrdenRetiro;
	}

	private function getTextBetweenTags($tag, $html, $strict=0){
	    /*** a new dom object ***/
	    $dom = new domDocument;

	    /*** load the html into the object ***/
	    if($strict==1)
	    {
	        $dom->loadXML($html);
	    }
	    else
	    {
	        $dom->loadHTML($html);
	    }

	    /*** discard white space ***/
	    $dom->preserveWhiteSpace = false;

	    /*** the tag by its tag name ***/
	    $content = $dom->getElementsByTagname($tag);

	    /*** the array to return ***/
	    $out = array();
	    foreach ($content as $item)
	    {
	        /*** add node value to the out array ***/
	        $out[] = $item->nodeValue;
	    }
	    /*** return the results ***/
	    return $out[0];
	}

}
