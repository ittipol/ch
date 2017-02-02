<?php

namespace App\library;

class Url
{
  private $urls = array();

  public function getUrls() {
    return $this->urls;
  }

  public function setUrl($url,$index) {

    preg_match_all('/{[\w0-9]+}/', $url, $matches);

    $this->urls[$index] = array(
      'url' => url($url),
      'pattern' => $matches[0]
    );
  }

  public function clearUrls() {
    $this->urls = array();
  }

  public function parseUrl($record) {
    $urls = array();

    foreach ($this->urls as $index => $url) {

      foreach ($url['pattern'] as $pattern) {
    
        $field = substr($pattern, 1,-1);

        if(!empty($record[$field])) {
          $url['url'] = str_replace($pattern, $record[$field], $url['url']);
        }

      }

      $urls[$index] = $url['url'];

    }

    return $urls;
  }

}