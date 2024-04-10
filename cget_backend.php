<?php

require_once("bouncer.php"); // security: will exit unless security check passes
require_once("db.php"); // database details
require_once("jsonetc.php");
must_post();

$request = get_json_from_post();
if( !isset($request["name"]) ) {
  serve_error_json("noname","No name",400);
}
$name = $request["name"];
if( !preg_match('/^[A-Za-z0-9_]+$/',$name) ) {
  serve_error_json("invalidname","Invalid name",400);
}
if( !isset($request["namespace"]) ) {
  $namespace = "_";
} else {
  $namespace = $request["namespace"];
}
if( !preg_match('/^[A-Za-z0-9_]+$/',$namespace) ) {
  serve_error_json("invalidnamespace","Invlaid namespace",400);
}

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
  serve_error_json("connerror","SQL Connect Error",500);
}

$sql = "SELECT pointers.clipid, clips.value, clips.time 
  FROM pointers JOIN clips 
  ON (pointers.clipid = clips.id) 
  WHERE (
    pointers.namespace = ? AND
    pointers.name = ?
  )";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $namespace,$name);
$error = false;
$found = false;
$output = null;
if( !$stmt->execute() ) {
  serve_error_json("sqlerror","SQL Error",500);
}
$result = $stmt->get_result(); 
while($row = $result->fetch_assoc()) {
  $output = $row['value'];
  break;
}
$conn->close();
if( $output == null ) {
  serve_json([
    "namespace" => $namespace,
    "name" => $name,
    "message" => "not found",
  ],404);
}
serve_json([
  "namespace" => $namespace,
  "name" => $name,
  "message" => "success",
  "value" => $output
],200);
