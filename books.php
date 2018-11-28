<?php
    //$servername = 
    $username = "charles7";
    //$password = 
    $dbname = "charles7db";

    $conn = mysqli_connect($servername, $username, $password,$dbname);
    $path_components = explode('/', $_SERVER['PATH_INFO']);
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
      if ((count($path_components) >= 2) &&($path_components[1] != "")) {
        $quoteResults = $conn->query('SELECT Book.bID, Book.Title, Author.Name, Quote.Text, Quote.PageNumber, Quote.qID FROM Book, Author, Quote where Book.AuthorID = Author.aID AND Quote.qBookID = Book.bID AND Book.Title LIKE  "' . strval($path_components[1]) . '"ORDER BY Quote.PageNumber');
        $name_array = array();
         while($row = $quoteResults->fetch_assoc()) {
            $name_array[] = $row;
            }
          print json_encode($name_array);
    }
      else if(count($path_components) == 1){
        $allBookQ = $conn->query('SELECT Title FROM Book');
        $book_array = array();
         while($row = $allBookQ->fetch_assoc()) {
            $book_array[] = $row;
            }
        print json_encode($book_array);
      }
    }
mysqli_close($conn);
?>