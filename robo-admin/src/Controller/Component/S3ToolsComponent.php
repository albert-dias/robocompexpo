<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Cake\Core\Configure;
use Aws\Rekognition\RekognitionClient;

/**
 * S3Tools component
 */
class S3ToolsComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getS3Object() {
        try {
            $this->autoRender = false;
            $s3Credentials    = Configure::read('S3_CREDENTIALS');

            $s3 = S3Client::factory([
                        'credentials' => [
                            'key'    => $s3Credentials['KEY'],
                            'secret' => $s3Credentials['SECRET']
                        ],
                        'region'      => $s3Credentials['REGION'],
                        'version'     => $s3Credentials['VERSION'],
            ]);

            return $s3;
        } catch (S3Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    public function upImage($key, $dir) {
        $s3     = $this->getS3Object();
        $result = $s3->putObject([
            'Bucket'      => 'uzeh',
            'Key'         => $key,
            'SourceFile'  => $dir,
            'ContentType' => 'image/jpeg',
        ]);

        return $result;
    }

    public function upVideo($key, $dir) {
        $s3     = $this->getS3Object();
        $result = $s3->putObject([
            'Bucket'      => 'uzeh',
            'Key'         => $key,
            'SourceFile'  => $dir,
            'ContentType' => 'video/mp4',
        ]);

        return $result;
    }

    public function getImage($key) {
        $s3     = $this->getS3Object();
        $result = $s3->getObject([
            'Bucket' => 'uzeh',
            'Key'    => $key
        ]);

        return $result;
    }

    public function getHead($key) {
        $s3     = $this->getS3Object();
        $result = $s3->headObject([
            'Bucket' => 'uzeh',
            'Key'    => $key
        ]);

        return $result;
    }

    public function getUrlTemp($key, $minutes) {
        $s3 = $this->getS3Object();

        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => 'uzeh',
            'Key'    => $key
        ]);

        $request      = $s3->createPresignedRequest($cmd, "+$minutes minutes");
        $presignedUrl = (string) $request->getUri();

        return $presignedUrl;
    }

    public function checkFaceLogin($imagePath) {
        
        $s3Credentials    = Configure::read('S3_CREDENTIALS');
        
        $rekognition = RekognitionClient::factory(array(
                    'region'      => $s3Credentials['REGION'],
                    'version'     => 'latest',
                    'credentials' => array(
                        'key'    => $s3Credentials['KEY'],
                        'secret' => $s3Credentials['SECRET']
                    )
        ));
        
        $photo    = $imagePath;
        $fp_image = fopen($photo, 'r');
        $image    = fread($fp_image, filesize($photo));
        fclose($fp_image);

        $result = $rekognition->searchFacesByImage([
            'CollectionId'       => 'users',
            'FaceMatchThreshold' => 80,
            'Image'              => [
                'Bytes' => $image
            ],
            'MaxFaces'           => 100,
        ]);

        return $result;
    }
    
    public function addFaceIndex($id, $keyFile) {
        $s3Credentials = Configure::read('S3_CREDENTIALS');

        $rekognition = RekognitionClient::factory(array(
                    'region'      => $s3Credentials['REGION'],
                    'version'     => 'latest',
                    'credentials' => array(
                        'key'    => $s3Credentials['KEY'],
                        'secret' => $s3Credentials['SECRET']
                    )
        ));

        $index = $rekognition->indexFaces([
            'CollectionId'        => 'users',
            'DetectionAttributes' => [
            ],
            'ExternalImageId'     => $id,
            'Image'               => [
                'S3Object' => [
                    'Bucket' => $s3Credentials['BUCKET'],
                    'Name'   => $keyFile,
                ],
            ],
        ]);

        return $index;
    }
    
     public function detectTextImg($keyFile) {
        $s3Credentials = Configure::read('S3_CREDENTIALS');

        $rekognition = RekognitionClient::factory(array(
                    'region'      => $s3Credentials['REGION'],
                    'version'     => 'latest',
                    'credentials' => array(
                        'key'    => $s3Credentials['KEY'],
                        'secret' => $s3Credentials['SECRET']
                    )
        ));

        $result = $rekognition->detectText([
            'Image' => [
                'S3Object' => [
                    'Bucket' => $s3Credentials['BUCKET'],
                    'Name'   => $keyFile,
                ],
            ],
        ]);

        return $result;
    }
    
     public function removeFaceIndex($faceId) {
        $s3Credentials = Configure::read('S3_CREDENTIALS');

        $rekognition = RekognitionClient::factory(array(
                    'region'      => $s3Credentials['REGION'],
                    'version'     => 'latest',
                    'credentials' => array(
                        'key'    => $s3Credentials['KEY'],
                        'secret' => $s3Credentials['SECRET']
                    )
        ));

        $result = $rekognition->deleteFaces([
            'CollectionId'        => 'users',
            'FaceIds' => [$faceId]]);

        return $result;
    }
    
    public function listFaces($collection_id) {
        $s3Credentials = Configure::read('S3_CREDENTIALS');

        $rekognition = RekognitionClient::factory(array(
                    'region'      => $s3Credentials['REGION'],
                    'version'     => 'latest',
                    'credentials' => array(
                        'key'    => $s3Credentials['KEY'],
                        'secret' => $s3Credentials['SECRET']
                    )
        ));

        $result = $rekognition->listFaces([
            'CollectionId' => $collection_id
        ]);
        
        return $result;
    }

}
