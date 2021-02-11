<?php
/* vars for export */
// database record to be exported
$db_record = 'products';
// optional where query
$where = 'WHERE 1 ORDER BY 1';
// filename for export
$csv_filename = 'export_products.csv';

// database variables
$hostname = "localhost";
$user = "root";
$password = "n@XBQVPgb4b4BddJ3D3dns4Xg!";
//$password = "coala090";
$database = "chatelet";

function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}

// Database connecten voor alle services
$link = mysqli_connect($hostname, $user, $password, $database)
or die('Could not connect: ' . mysqli_error($link));
					
// mysqli_select_db($database)
// or die ('Could not select database ' . mysqli_error());

// create var to be filled with export data
$csv_export = '';

// query to get data from database
$query = mysqli_query($link, "SELECT * FROM ".$db_record." ".$where);
$field = mysqli_num_fields($query);

// create line with field names
for($i = 0; $i < $field; $i++) {
  $csv_export.= mysqli_field_name($query,$i).',';
}
// newline (seems to work both on Linux & Windows servers)
$csv_export.= '
';

while($row = mysqli_fetch_array($query)) {
  // create line with field values
  for($i = 0; $i < $field; $i++) {
    $csv_export.= '"'.$row[mysqli_field_name($query,$i)].'",';
  }	
  $csv_export.= '
';	
}

// Export the data and prompt a csv file for download
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);


