<?php
include_once './Common/Classes.php';
include_once './Common/Functions.php';

//GET
if($_SERVER['REQUEST_METHOD'] === "GET")
{
    if (isset($_GET['id']))
    {
        $restaurant = GetRestaurantReviewById($_GET['id']); //get the restaurant by id
        print json_encode($restaurant);                     //respond with the restaurant as json
        exit();
    }
    else if ((isset($_GET['action']) && $_GET['action'] === 'GetRestaurantNames'))
    {
        $names = GetRestaurantNames();      //get a str[] of names
        print json_encode($names);          //respond with the names as json
        exit();
    }
    else
    {
        $reviews = GetAllRestaurantReviews();       //get all the reviews
        if ($reviews){
            $json = json_encode($reviews);          //respond with the reviews as json
            print $json;
            exit();
        }
    }
    loggingToFile("Invalid request made to RestaurantReviews.php");
    http_response_code(400);
    exit();
}

//PUT
else if ($_SERVER['REQUEST_METHOD'] === "PUT")
{
    $requestHeaders = array_change_key_case(getallheaders());           //get the headers and make them all lowercase
    if (isJsonRequest())
    {
        $requestBody = file_get_contents('php://input');
        $updatedData = json_decode($requestBody);                       //decode the json into an array
        if ($updatedData !== null)
        {
            if (UpdateRestaurant($updatedData))                         //update the restaurant
            {
                http_response_code(200);
                exit();
            }
        }
}                                                                       //or don't if the request is invalid
    http_response_code(400);
    loggingToFile("Invalid request made to RestaurantReviews.php");
    logHeaders();
    exit();
}

//DELETE
else if ($_SERVER['REQUEST_METHOD'] === "DELETE")
{
    if (isset($_GET['id']))                                             //if there is an id passed in query string
    {
        if (DeleteRestaurantReviewById($_GET['id']))                    //delete the restaurant
        {
            http_response_code(200);
            exit();
        }
    }                                                                   //or don't if the request is invalid
    http_response_code(400);
    loggingToFile("Invalid request made to RestaurantReviews.php with id: " . $_GET['id']);
    exit(); 
}

//POST
else if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    $requestHeaders = array_change_key_case(getallheaders());           //get the headers and make them all lowercase
    if (isJsonRequest())
    {
        $requestBody = file_get_contents('php://input');        //get the body of the request
        $newRestaurantData = json_decode($requestBody);                 //decode the json into an array
        if ($newRestaurantData !== null)
        {
            if (SaveNewRestaurant($newRestaurantData))                  //save the new restaurant
            {
                http_response_code(200);
                exit();
            }
        }
    }                                                                   //or don't if the request is invalid
    http_response_code(400);
    loggingToFile("Invalid request made to RestaurantReviews.php");
    logHeaders();
    exit();
}


