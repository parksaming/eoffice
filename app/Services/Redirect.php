<?php 
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    // header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


function callApi($link, array $options = array()) {
    if ($options && sizeof($options)) {
        $opts = [
            'http' => [
                'method' => isset($options['method'])?  $options['method'] : 'GET'
            ]
        ];

        if (isset($options['headers'])) {
            $opts['http']['header'] = '';
            for($i = 0, $l = sizeof($options['headers']); $i < $l; $i++) {
                $opts['http']['header'] .= $options['headers'][$i]."\r\n";
            }
        }

        if (isset($options['params'])) {
            if (isset($options['param_type']) && $options['param_type'] == 'form') {// formdata
                $opts['http']['content'] = http_build_query($options['params']);
            }
            else {// default is json
                $opts['http']['header'] = isset($opts['http']['header'])? $opts['http']['header']."Content-Type: application/json\r\n" : "Content-Type: application/json\r\n";
                $opts['http']['content'] = json_encode($options['params'], JSON_NUMERIC_CHECK);
            }
        }

        return file_get_contents($link, false, stream_context_create($opts));
    }
    else {
        return file_get_contents($link);
    }
}

function callApi2($url, $options = []) {
    //create cURL connection
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    // add Referer to header
    if (isset($options['headers']) && sizeof($options['headers'])) {
        $checkReferer = false;
        foreach($options['headers'] as $header) {
            if (strpos($header, 'Referer') !== false) {
                $checkReferer = true;
                break;
            }
        }
        if (!$checkReferer) {
            $options['headers'][] = 'Referer: '.$url;
        }
    }
    else {
        $options['headers'] = ['Referer: '.$url];
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);

    if (isset($options['method']) && $options['method'] === 'POST') {
        // set method is POST
        curl_setopt($ch, CURLOPT_POST, true);

        // set link
        curl_setopt($ch, CURLOPT_URL, $url);

        // set params
        if (isset($options['params']) && sizeof($options['params'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, (isset($options['param_type']) && $options['param_type'] == 'form')? http_build_query($options['params']) : json_encode($options['params'], JSON_NUMERIC_CHECK));
        }
    }
    else {
        // set method is GET
        curl_setopt($ch, CURLOPT_POST, false);

        // set link
        if (isset($options['params']) && sizeof($options['params'])) {
            curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($options['params']));
        }
        else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }

    // send the request
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// get params
$link = isset($_GET['link'])? $_GET['link'] : (isset($_POST['link'])? $_POST['link'] : '');
$method = isset($_GET['method'])? $_GET['method'] : (isset($_POST['method'])? $_POST['method'] : 'GET');
$headers = isset($_GET['headers'])? $_GET['headers'] : (isset($_POST['headers'])? $_POST['headers'] : null);
$params = isset($_GET['params'])? $_GET['params'] : (isset($_POST['params'])? $_POST['params'] : null);
$paramType = isset($_GET['param_type'])? $_GET['param_type'] : (isset($_POST['param_type'])? $_POST['param_type'] : 'json');

// get content
die(callApi2($link, [
    'method'    => $method,
    'headers'   => $headers,
    'params'    => $params,
    'param_type' => $paramType
]));