<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yaml;
use Input;

class UrlCheckController extends Controller {

    /**
     * Store uploaded file
     * @param Request $request
     */
    public function uploadFile(Request $request) { 

        if (!$request->hasFile('yaml_file') || !$request->file('yaml_file')->isValid()) {
            return response()->json(['message' => 'Upload error'], 200);
        }
        
        if ($request->file('yaml_file')->getMimeType() !== 'text/plain') {
            return response()->json(['message' => 'File invalid'], 406);
        }
        
        $filename = md5(time()) . '.yml';
        $request->yaml_file->storeAs('local', $filename);
        if($this->saveDataFromYaml(storage_path('app/local/' . $filename))) {
            return response()->json(['message' => 'Success'], 201);
        }
        
        return response()->json(['message' => 'Data invalid'], 406);
        
    }
    /**
     * Stora data from yaml file in database.
     * @param string $filePath yaml file path
     */
    private function saveDataFromYaml($filePath) {
        $urls = $this->getYamlData($filePath);
        if(empty($urls['urls'])) {
            return false;
        }
        foreach ($urls['urls'] as $urlData) {
            $o = new \App\ServerResponse($this->checkServerResponse($urlData['url']));
            $o->save();
        }
        return true;
    }

    /**
     * Get servers url from yaml file.
     * @param string $filePath yaml file path
     * @return array
     */
    private function getYamlData($filePath) {
        try {
            return Yaml::parse(file_get_contents($filePath));
        } catch (\Exception $e) { 
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

}
