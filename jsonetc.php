<?php
function get_json_from_post() {
  $body = file_get_contents('php://input');
  try {
    return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
  } catch( Exception $e ) {
    serve_error_json("invalidjson","Invalid request JSON",400,["invalidJson" => $body]);
  }
}
function serve_error_json($type,$message,$response_code,$additional_data = null) {
  $message = str_replace("\\","\\\\",$message);
  $message = str_replace('"',"\\\"",$message);
  $data = [ "status" => "error", "errorType" => $type, "error" => $message ];
  if( ! is_null($additional_data) ) {
    $data = array_merge($data,$additional_data);
  }
  serve_json($data, $response_code);
}
function serve_json($data, $response_code) {
  http_response_code($response_code);
  header("Content-type: application/json");
  echo json_encode($data);
  exit();
}
function must_post($response_code = 400) {
  if( $_SERVER["REQUEST_METHOD"] !== "POST" ) {
    serve_error_json("mustpost","Must POST",400);
    exit();
  }
}
