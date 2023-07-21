<?php
include_once './Common/Classes.php';
include_once './Common/Functions.php';


if($_SERVER['REQUEST_METHOD'] === "GET")
{
    //add your code here to process get all restaurant review, get one restaurant review, and get restaurant names.
    if (isset($_GET['id']))
    {
        $restaurant = GetRestaurantReviewById($_GET['id']); //get the restaurant by id
        print json_encode($restaurant);  //respond with the restaurant as json
        exit();
    }
    else if ((isset($_GET['action']) && $_GET['action'] === 'GetRestaurantNames'))
    {
        $names = GetRestaurantNames();   //get a str[] of names
        print json_encode($names);        //respond with the names as json
        exit();
    }
    else
    {
        $reviews = GetAllRestaurantReviews(); //get all the reviews
        if ($reviews){
            $json = json_encode($reviews);  //respond with the reviews as json
            print $json;
            exit();
        }
    }
    loggingToFile("Invalid request made to RestaurantReviews.php");
    http_response_code(400);
    exit();
}

else if ($_SERVER['REQUEST_METHOD'] === "PUT")
{
    //add your code here to modify the given restaurant review

 
    exit();
}
else if ($_SERVER['REQUEST_METHOD'] === "DELETE")
{
    //add your code here to delete the specified restaurant review.

    exit(); 
}
else if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    //add your code here to save the new restaurant review.

    exit();
}


