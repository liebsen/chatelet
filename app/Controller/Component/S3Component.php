<?php
require ROOT.'/app/Vendor/aws/aws-autoloader.php';
App::uses('Component', 'Controller');
use Aws\S3\S3Client;
class S3Component extends Component {

    public function __construct(){
        $this->S3 = S3Client::factory(array(
            'key' => Configure::read('S3.accessKey'),
            'secret' => Configure::read('S3.secret')
        )); 
    }

    public function save($filepath, $name){
        $s3Client = $this->S3->upload('chatelet', $name, file_get_contents($filepath), 'public-read');
        return $name;
    }
}