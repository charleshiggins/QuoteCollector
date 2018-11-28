<?php
    //$servername = 
    $username = "charles7";
    //$password = 
    $dbname = "charles7db";

    $conn = mysqli_connect($servername, $username, $password,$dbname);
    $path_components = explode('/', $_SERVER['PATH_INFO']);
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if ((count($path_components) >= 2) &&($path_components[1] != "")) {
            $quoteResults = $conn->query('SELECT * FROM Author, Book, Quote where Author.aID = Book.AuthorID AND Quote.qBookID = Book.bID AND Author.Name LIKE  "' . $path_components[1] . '"');
            $name_array = array();
            while($row = $quoteResults->fetch_assoc()) {
                $name_array[] = $row;
			}
            print json_encode($name_array);
        }
        else if(count($path_components) == 1){
            $allAuthorQ = $conn->query('SELECT Name FROM Author');
            $author_array = array();
            while($row = $allAuthorQ->fetch_assoc()) {
                $author_array[] = $row;
            }
            print json_encode($author_array);
        }
    }
mysqli_close($conn);
?>