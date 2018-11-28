<?php
    //$servername = 
    $username = "charles7";
    //$password = 
    $dbname = "charles7db";

    $conn = mysqli_connect($servername, $username, $password,$dbname);
    $path_components = explode('/', $_SERVER['PATH_INFO']);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $theID;
    	$quoteResults = $conn->query('SELECT bID FROM Book where Book.Title ="' . $_POST['chooseBook'] . '";');
    	while($row = $quoteResults->fetch_assoc()) {
    	  	$theID = $row[bID];
		}
		$truepagenum = intval($_POST['pageNumber']);
		$theQuote = $_POST['quote'];
	    $insertString = "INSERT INTO Quote (Text, qBookID, PageNumber) VALUES('$theQuote', '$theID', '$truepagenum')";
		$insertresult = $conn->query($insertString);
    	$returnResult = $conn->query('SELECT * FROM Quote, Book, Author where Quote.qBookID = Book.bID AND Book.AuthorID = Author.aID AND Text = "' . $theQuote . '";');
		$theRes  = array();
    	while($row = $returnResult->fetch_assoc()) {
    	   $theRes[] = $row;
		}
    	print json_encode($theRes);
    }
    else if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $deleteQ = "DELETE FROM Quote where qID = " . $path_components[1] . "";
     	$deleteresult = $conn->query($deleteQ);
     	print(json_encode(true));
     }
    mysqli_close($conn);
?>