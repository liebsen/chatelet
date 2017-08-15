<?php
App::uses('CakeLog', 'Utility');
App::uses('Component', 'Controller');
class ResizeImageComponent extends Component
{
    public function resizeByPercentage($nombre_fichero, $porcentaje = 0.5)
    {
        // Tipo de contenido
        header('Content-Type: image/jpeg');

        // Obtener los nuevos tamaños
        list($ancho, $alto) = getimagesize($nombre_fichero);
        $nuevo_ancho = $ancho * $porcentaje;
        $nuevo_alto = $alto * $porcentaje;

        // Cargar
        $thumb = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
        $origen = imagecreatefromjpeg($nombre_fichero);

        // Cambiar el tamaño
        imagecopyresized($thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

        // Imprimir
        imagejpeg($thumb);
    }

    public function resizeByPixel($nombre_fichero, $extension, $target = null)
    {
        try {
            list($width, $height) = getimagesize($nombre_fichero);
            if ($width > $height) {
                if (empty($target)) {
                    $target = 600;
                }
                $percentage = ($target / $width);
            } else {
                if (empty($target)) {
                    $target = 480;
                }
                $percentage = ($target / $height);
            }

            //gets the new value and applies the percentage, then rounds the value
            $new_width = round($width * $percentage);
            $new_height = round($height * $percentage);

            // Cargar
            $thumb = imagecreatetruecolor($new_width, $new_height);
            $origin = null;
            if (strtolower($extension)=='png') {
                $origen = imagecreatefrompng($nombre_fichero);
                imagealphablending( $thumb, false );
                imagesavealpha( $thumb, true );
            } elseif (strtolower($extension)=='jpg' || strtolower($extension)=='jpeg') {
                $origen = imagecreatefromjpeg($nombre_fichero);
            }
            // Cambiar el tamaño
            imagecopyresized($thumb, $origen, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            if (strtolower($extension)=='png') {
                imagepng($thumb, $nombre_fichero, 8);
            } elseif (strtolower($extension)=='jpg' || strtolower($extension)=='jpeg') {
                imagejpeg($thumb);
            }
        } catch (Exception $ex) {
            CakeLog::write('error', $ex->getMessage());
        }
        
    }

    public function thumbnail($nombre_fichero, $newName, $target = null)
    {
        try {
            list($width, $height) = getimagesize($nombre_fichero);
            if ($width > $height) {
                if (empty($target)) {
                    $target = 600;
                }
                $percentage = ($target / $width);
            } else {
                if (empty($target)) {
                    $target = 480;
                }
                $percentage = ($target / $height);
            }

            //gets the new value and applies the percentage, then rounds the value
            $new_width = round($width * $percentage);
            $new_height = round($height * $percentage);

            // Cargar
            $thumb = imagecreatetruecolor($new_width, $new_height);
            $origin = null;
            $extension = pathinfo($newName, PATHINFO_EXTENSION);
            if (strtolower($extension)=='png') {
                $origen = imagecreatefrompng($nombre_fichero);
                imagealphablending( $thumb, false );
                imagesavealpha( $thumb, true );
            } elseif (strtolower($extension)=='jpg' || strtolower($extension)=='jpeg') {
                $origen = imagecreatefromjpeg($nombre_fichero);
            }
            // Cambiar el tamaño
            imagecopyresized($thumb, $origen, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            if (strtolower($extension)=='png') {
                imagepng($thumb, $nombre_fichero, 100);
            } elseif (strtolower($extension)=='jpg' || strtolower($extension)=='jpeg') {
                imagejpeg($thumb, $nombre_fichero, 100);
            }
            return;
        } catch (Exception $ex) {
            CakeLog::write('error', $ex->getMessage());
        }
    }
}