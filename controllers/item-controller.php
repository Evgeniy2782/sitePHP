<?php

include "models/items-model.php";
include "util.php";
include "edit-image.php";
define("ITEMS_FILE", "/home/evgen/workspace/magazin/allItem.json");
define("CART_FILE", "/home/evgen/workspace/magazin/cart.json");
define("USERS_FILE", "/home/evgen/workspace/magazin/allUsers.json");
$pathFile = '/home/evgen/workspace/magazin/uploadsItems';
$file_urlImage = "http://178.72.90.83:8080/uploadsItems/";

if($requestUri == "/addItem"){
    $handleRequest = function() use($user){
    include "addItem.php";
        };

    include "header.php";
    die();
 }

if ($requestUri == "/allItemEdit") {

    $scriptAssets = ["/assets/js/usersView.js"];

  $page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
  $limit = filter_var($_GET['limit'] ?? 6 , FILTER_VALIDATE_INT);
  $url = "/api/items";
  $urlProfile = "/profileItem/";

    $handleRequest = function() use ($url, $urlProfile ,$page, $limit) {
    include "templates/usersView.php";
    };

    include "header.php";
    die();
}

function profileItemEdit($item) {
    $handleRequest = function() use($item){
    include "profileItem.php";
    };

    include "header.php";
    die();
}

if (startsWith($requestUri, "/profileItem/")) {
    $path = explode("/", $requestUri);
    $itemUuid = $path[2];
    $item = getItem($itemUuid);

    if (is_null($item)) {
        http_response_code(404);
        die();
    }
    profileItemEdit($item);
}

if (startsWith($requestUri, "/api/cart/")) {
    header('Content-Type: application/json');
    
    $path = explode("/", $requestUri);
    $itemUuid = $path[count($path) - 1];

    if (is_null($itemUuid)) {
        http_response_code(404);
        die();
    }

     $item = ['uuid' => $path[3]];
   
     createItem($item, CART_FILE);
        die();
    }

    if (startsWith($requestUri, "/api/cartDelete/")) {
        header('Content-Type: application/json');

        if ($requestMethod == "GET") {
        $path = explode("/", $requestUri);
        $itemUuid = $path[count($path) - 1];
        $item[] = ['uuid' => $itemUuid];

        deleteCart(CART_FILE, $item);
        }
    }

if ($requestUri == "/api/items") {
    header('Content-Type: application/json');

    if ($requestMethod == "GET") {
        $limit = filter_var($_GET["limit"], FILTER_VALIDATE_INT);
        $page = filter_var($_GET["page"], FILTER_VALIDATE_INT);

        echo json_encode(getItems($limit, $page));
        die();
    }

    if ($requestMethod == "POST") {
        $name = filter_var($_POST['item'] ,FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'] ,FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'] ,FILTER_SANITIZE_STRING);

        $item = [
        'uuid' => randomUuid(),   
        'item'=> $name,
        'description'=> $description,
        'price'=> $price,
        'active'=> true
        ];

    if (!empty($_FILES)) {
        $item['image'] = editImage($pathFile, $file_urlImage);
    }
          
     createItem($item, ITEMS_FILE);
        die();
    }
}

if (startsWith($requestUri, "/api/items/")) {
    header('Content-Type: application/json');

    $path = explode("/", $requestUri);
    $itemUuid = $path[count($path) - 1];
    $item = getItem($itemUuid);

    if (is_null($item)) {
        http_response_code(404);
        die();
    }

    if ($requestMethod == "GET") {
        echo json_encode(getItem($itemUuid));
        die();
    }
  
    if ($requestMethod == "POST") {
        $item = filter_var($_POST['item'] ,FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'] ,FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'] ,FILTER_SANITIZE_STRING);
        $isActive = filter_var($_POST['active'] ,FILTER_SANITIZE_STRING);
      
        $itemArr = [];
  
    if (!empty($_FILES)) {
        $itemArr['image'] = editImage($pathFile, $file_urlImage);
    }

    if (!empty($item)) {
        $itemArr["item"] = $item;
    }

    if (!empty($description)) {
        $itemArr["description"] = $description;
    }

    if (!empty($price)) {
        $itemArr["price"] = $price;
    }

    if (!empty($isActive)) {
        $itemArr["active"] = $isActive = true;
    }else{
        $itemArr["active"] = $isActive = false;
    }

    editItem($itemUuid, $itemArr);
    die();

}
    if ($requestMethod == "DELETE") {
     deleteItem($userUuid);
    die();

       }
    }



    