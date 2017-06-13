<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yaml;

class UrlCheckController extends Controller
{
    /**
     * Get servers url from yaml file.
     * @param string $filePath yaml file path
     * @return array
     */
    private function getYamlData($filePath) {
        try {
            return Yaml::parse(file_get_contents($filePath));
        } catch(\Exception $e) {
            return ['urls' => []];
        }
    }
    /**
     * Check server response time and HTTP code.
     * @param string $url Server URL
     * @return \stdClass
     */
    private function checkServerResponse($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        $result = array();
        $result['url'] = $url;
        $result['http_code'] = $info['http_code'];
        $result['total_time'] = $info['total_time'];
        
        return $result;
    }
    
    public function check() {
        $filePath = public_path('urls.yml');
        $urls = $this->getYamlData($filePath);
        
        foreach($urls['urls'] as $urlData) { 
            $o = new \App\ServerResponse($this->checkServerResponse($urlData['url']));
            $o->save();
        }
        
        
    }
}
