<?php
App::uses('Component', 'Controller');
class SQLComponent extends Component {
	private $conn;

	public function __construct() {
		$myServer = "181.164.35.14";
		$myUser = "sa";
		$myPass = "infinixchatelet2011";
		$myDB = "Ventas";

		try {
			$this->conn = new PDO("dblib:host=$myServer;dbname=$myDB", $myUser, $myPass);
		} catch (PDOException $e) {
			echo "Failed to get DB handle: " . $e->getMessage() . "\n";
			exit;
		}
	}
	public function __destruct() {
    	if($this->conn) $this->conn = null;
	}
	public function product_price_by_list($article,$list_code,$list_code_desc)
	{
		
		$stmt = $this->conn->prepare("EXEC pa_datos_articulo '$article','$list_code','$list_code_desc';");
		$stmt->execute();
        
        while ($row = $stmt->fetch()) {  
			if( !empty( $row['codigo'] ) && strpos($row['codigo'], '.0000') && !empty($row['precio1']) ){
            	$precio['precio'] = $row['precio1'];
                $precio['discount'] = $row['precio2'];
			}
				return $precio;
		}
		return false;
	}

	public function product_exists($article,$list_code){
		$minimo = Configure::read('stock_min');
		$stmt = $this->conn->prepare("EXEC pa_datos_articulo @cod_articulo='$article', @cod_lista='$list_code', @minimo='$minimo';");
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			if(!empty($row['codigo'])){
				$params = explode('.', $row['codigo']);
				if(!empty($params[1])){
					return true;
				}
			}
		}

		return false;
	}

	public function product_exists_general($article,$list_code){
		$minimo = Configure::read('stock_min');
		$stmt = $this->conn->prepare("EXEC pa_datos_articulo @cod_articulo='$article', @cod_lista='$list_code', @minimo='$minimo';");
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			if(!empty($row['codigo'])){
				$params = explode('.', $row['codigo']);
				if(!empty($params[1]) && ($params[1] != '0000')){
					return 1;
				}
			}
		}

		return 0;
	}

	//EXAMPLE: I5005/03/02/173
	public function product_stock($article,$size_number,$color_code,$list_code){
		$minimo = Configure::read('stock_min');
		$stmt = $this->conn->prepare("EXEC pa_datos_articulo @cod_articulo='$article', @cod_lista='$list_code', @minimo='$minimo';");
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			if(!empty($row['codigo'])){
				$params = explode('.', $row['codigo']);
				if(!empty($params[1]) && ($params[1] != '0000') && $params[1] == ($size_number.$color_code)){
					return $row['stock'];
				}
			}
		}

		return 0;
	}

	public function product_details($article,$list_code){
		$details = array(
			'sizes' 	=> array(),
			'colors' 	=> array(),
		);

		$colors 		= $this->new_colors();
		$color_codes	= Hash::extract($colors,'{n}.code');

		$stmt = $this->conn->prepare("EXEC pa_datos_articulo @cod_articulo='{$article}', @cod_lista='{$list_code}', @minimo='0';");
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			if( !empty($row['codigo']) ) {
				$params = explode('.', $row['codigo']);
				if( count($params) == 2 && $params[1] != '0000' && strlen($params[1]) == 4 ) {
					$size_number 	= substr($params[1], 0 , 2);
					$color_code 	= substr($params[1], 2 , 2);

					if( !in_array($size_number, $details['sizes']) )
						$details['sizes'][] = $size_number;

					if( !in_array($color_code, $details['colors']) )
						$details['colors'][] = $color_code;
				}
			}
		}		

		return $details; //Key-> size | Values -> colors
	}

	public function test(){
		$stmt = $this->conn->prepare("EXEC pa_datos_articulo @cod_articulo='i5005', @cod_lista='173', @minimo='0';");
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			pr($row);
		}
		die;
	}

	public function chatelet_extras(){
		$stmt = $this->conn->prepare("EXEC pa_datos_articulo @cod_articulo='i5005', @cod_lista='173', @minimo='1';");
		#$stmt = $this->conn->prepare("EXEC pa_datos_articulo");
		#$stmt = $this->conn->prepare("EXEC pa_todos_colores");
		$stmt->execute();
		$results = array();

		while ($row = $stmt->fetch()) {
			pr($row);
		}
		die;
	}

	public function new_colors(){
		$stmt = $this->conn->prepare("EXEC pa_todos_colores");
		$stmt->execute();

		$colors = array();
		while ($row = $stmt->fetch()) {
			$colors[] = array(
				'code' => $row['codigo'],
				'desc' => $row['descripcion']
			);
		}
		unset($stmt);

		return $colors;
	}

	public function seasons() {
		$stmt = $this->conn->prepare("SELECT * FROM Temporadas");
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch()) {
			unset($row['0']);
			unset($row['1']);
			foreach ($row as &$r) {
				$r = utf8_encode($r);
		    }
			$results[] = array(
				'cod_chatelet' => $row['Codigo'],
				'name' => $row['Descripcion']
			);
		}
		unset($stmt);
		return $results;
	}

	public function products($temp = null) {
		$results = array();
		if (empty($temp)) return $results;
		$stmt = $this->conn->prepare("SELECT ArtCod, ArtNom FROM Art WHERE Temporadas='".$temp."'");
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch()) {
			unset($row['0']);
			unset($row['1']);
			foreach ($row as &$r) {
				$r = utf8_encode($r);
		    }
			$results[] = $row;
		}
		unset($stmt);
		return $results;
	}

	public function productsByLisCod($prod_cod, $lis_cod) {
		$results = array();
		if (empty($lis_cod) || empty($prod_cod)) return $results;
	
		$stmt = $this->conn->prepare("
			SELECT a.ArtCod AS codArticulo, 
				   a.ArtNom AS descripcion, 
				   c.descripcion AS colorPrenda, 
				   al.LisCod AS listaPrecio, 
				   al.Precio

			FROM   Art a INNER JOIN
				   ArtLis al ON a.ArtCod = al.ArtCod INNER JOIN
				   Color c ON RIGHT(a.ArtCod, 2) = c.Codigo
			WHERE  (al.LisCod = '".$lis_cod."') AND (a.ArtCod LIKE '".$prod_cod."%')
		");
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch()) {
			unset($row['0']);
			unset($row['1']);
			unset($row['2']);
			unset($row['3']);
			unset($row['4']);
			foreach ($row as &$r) {
				$r = utf8_encode($r);
		    }
			$results[] = $row;
		}
		unset($stmt);
		return $results;
			CakeLog::write('error', var_export($results, true));
	}

	public function product($id = null) {
		$results = array();
		if (empty($id)) return $results;
		$stmt = $this->conn->prepare("
			SELECT TOP 1 Art.ArtCod, Art.ArtNom, ArtLis.LisCod, ArtLis.Precio
			FROM Art
			LEFT JOIN ArtLis
			ON Art.ArtCod = ArtLis.ArtCod
			WHERE Art.ArtCod LIKE '$id%'
			ORDER BY ArtLis.UltMod DESC
		");
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			unset($row['0']);
			unset($row['1']);
		    foreach ($row as &$r) {
				$r = utf8_encode($r);
		    }
			$results[] = array(
				'name' => $row['ArtNom'],
				'cod_chatelet' => $row['ArtCod'],
				'price' => $row['Precio']
			);
		}
		unset($stmt);
		return $results;
	}

	public function colors() {
		$stmt = $this->conn->prepare("SELECT * FROM Color");
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch()) {
			unset($row['0']);
			unset($row['1']);
		    foreach ($row as &$r) {
				$r = utf8_encode($r);
		    }
			$results[] = array(
				'cod_chatelet' => $row['Codigo'],
				'name' => $row['descripcion']
			);
		}
		unset($stmt);
		return $results;
	}

	/**
	 * @param string $article ex. V7113
	 * @return array $name
	 */
	public function product_name_by_article($article)
	{
		$stmt = $this->conn->prepare("EXEC sp_nombreArticulo '$article';");
		$response = $stmt->execute();
		if (!$response) {
		    CakeLog::write('error', 'product_name_by_article ' . var_export($stmt->errorInfo(), true));
		}
		$name = $stmt->fetch();
		//CakeLog::write('error', 'product_name_by_article ' . var_export($row, true));
		return $name;
	}
}