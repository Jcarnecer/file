<?php 
if (!defined('BASEPATH')) exit('No direct access allowed');

require 'vendor/autoload.php';

class S3
{
  private $CI;
  private $bucket;
  private $s3Client;
  private $filesDirectory = 'files/';

	public function __construct() {
    $this->CI =& get_instance();

    $this->CI->config->load('s3_config.php');
    $this->bucket = $this->CI->config->item('bucket');

    // INSTANTIATE S3 CLIENT
    $this->s3Client = new Aws\S3\S3Client([
      'version' => 'latest',
      'region'  => 'ap-southeast-1',
      'credentials' => [
        'key' => $this->CI->config->item('key'),
        'secret' => $this->CI->config->item('secret')
      ]
    ]);
  }

  public function uploadFile($path_to_file) {
    // PUT FILE TO S3 BUCKET
    try {
      $file = fopen($path_to_file, 'r');
      $result = $this->s3Client->putObject([
        'Bucket' => $this->bucket,
        'Key' => "files/" . basename($path_to_file),
        'Body' => $file,
        'ACL' => 'public-read',       
      ]);

      $status = [
        'code' => 0,
        'msg' => 'Upload Success',
        'data' => $result->get('ObjectURL')
      ];

    } catch (Aws\S3\Exception\S3Exception $e) {
      $status = [
        'code' => 1,
        'msg' => 'There was an error uploading the file.\n',
        'data' => null
      ];
    }

    fclose($file);

    // print_r($status);
    
    return $status;
  }

  public function binFile($filename) {
    // echo($this->filesDirectory . "--trash-" . $filename);
    try {
      $this->s3Client->copyObject(
        array(
          'Bucket'     => $this->bucket,
          'Key'        => $this->filesDirectory . "--trash-" . $filename,
          'CopySource' => "{$this->bucket}/{$this->filesDirectory}{$filename}"
        )
      );

      $this->s3Client->deleteObject(
        array(
          'Bucket' => $this->bucket,
          'Key' => $this->filesDirectory . $filename
        )
      );
      
      $status = [
        'code' => 0,
        'msg' => 'File Moved to Bin',
        'data' => null
      ];
    } catch (Aws\S3\Exception\S3Exception $e) {
      $status = [
        'code' => 1,
        'msg' => 'There was an error moving the file.\n',
        'data' => null
      ];
    }
  }

  public function restoreFile($filename) {
    // print_r($filename);
    // echo ($this->filesDirectory . "--trash-" . $filename);
    try {
      $this->s3Client->copyObject(
        array(
          'Bucket'     => $this->bucket,
          'Key'        => "{$this->filesDirectory}{$filename}",
          'CopySource' => "{$this->bucket}/{$this->filesDirectory}--trash-{$filename}"
        )
      );

      $this->s3Client->deleteObject(
        array(
          'Bucket' => $this->bucket,
          'Key' => "{$this->filesDirectory}--trash-{$filename}"
        )
      );
      
      $status = [
        'code' => 0,
        'msg' => 'File Restored',
        'data' => null
      ];
    } catch (Aws\S3\Exception\S3Exception $e) {
      $status = [
        'code' => 1,
        'msg' => 'Error Restoring.\n',
        'data' => null
      ];
    }
  }

  public function deleteFile($filename) {
    try {
      $this->s3Client->deleteObject(
        array(
          'Bucket' => $this->bucket,
          'Key' => "{$this->filesDirectory}--trash-{$filename}"
        )
      );
      
      $status = [
        'code' => 0,
        'msg' => 'File Restored',
        'data' => null
      ];
    } catch (Aws\S3\Exception\S3Exception $e) {
      $status = [
        'code' => 1,
        'msg' => 'Error Restoring.\n',
        'data' => null
      ];
    }
  }
}