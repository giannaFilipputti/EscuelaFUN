<?php
/**
 * Vimeo class to fetch thumbnails
 * @example
 *  $video = new VimeoThumbnail(array(
 *    'video_url' => $url
 *  ));
 *  echo $video->thumbnail;
 */
class VimeoThumbnail {
  public $video_url;
  public $video_id;
  public $api = "http://vimeo.com/api/v2/video/";
  public $thumbnail;
  /**
   * Set up the instance
   * @param array $config
   */
  public function __construct($config) {
    $this->video_url = $config['video_url'];
    $this->video_id = $this->get_video_id();
	  //$this->video_id = "220638318";	 
      $this->thumbnail = $this->get_thumbnail();
  }
  /**
   * Get the thumbnail from a Vimeo ID
   * @return string
   */
  public function get_thumbnail() {
    // ----- http://stackoverflow.com/a/1361192/1291469 ----- //
    $id = $this->video_id;
    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
	//  print_r($hash);
    return $hash[0]['thumbnail_medium']; 
  }
  /**
   * Parses the Vimeo url to get the ID of the video
   * @return int
   */
  public function get_video_id() {
    // ----- http://stackoverflow.com/a/10489007/1291469 ----- //
    $url = (int) substr(parse_url($this->video_url, PHP_URL_PATH), 1);
	  echo $url;
    return $url;
  }
}


?>