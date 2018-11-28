var url_base = "wwwp.cs.unc.edu/Courses/comp426-f17/users/charles7/426final/";

$(document).ready(function () {
  	$.ajax("books.php",
  		{type: "GET",
		dataType: "json",
		success: function(data, status, jqXHR) {
		for (var i=0; i<data.length; i++) {
			$("#chooseBook").append("<option value = '" + data[i].Title + "'>" + data[i].Title + "</option>");
		    }
		} ,
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
        	alert("Status: " + textStatus); alert("Error: " + errorThrown);    
		 }
	     });

	$("#searchControls").submit(function( event ) {
		$("#res").empty();
		thesearch = document.getElementById("searchControls");
  		theSearchQuery = thesearch.elements["searchBar"].value;
  		event.preventDefault();
		if(thesearch.elements["searchSelect"].value == "author"){
			$.ajax("authors.php/" + theSearchQuery,
	       		{type: "GET",
		       dataType: "json",
		       success: function(data, status, jqXHR) {
		       for (var i=0; i<data.length; i++) {
		       	$("#res").append('<div class = "resultDiv" >' + data[i].Text + '<div><span>' + data[i].Title + ' page ' + data[i].PageNumber + ' ' + data[i].Name + '</span><button onclick = deleteQuote(' + data[i].qID + ')>DELETE</button><div></div>');
		       }
                } ,
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                	alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		   		}
	       });
		}
		else if(thesearch.elements["searchSelect"].value == "book"){
			$.ajax("books.php/" + theSearchQuery,
	       		{type: "GET",
		       dataType: "json",
		       success: function(data, status, jqXHR) {
		       for (var i=0; i<data.length; i++) {
		       	$("#res").append('<div class = "resultDiv" >' + data[i].Text + '<div><span>' + data[i].Title + ' page ' + data[i].PageNumber + ' ' + data[i].Name + '</span><div><div><button onclick = deleteQuote(' + data[i].qID + ')>DELETE</button><div></div>');
		       }
		       } ,
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		   }
	       });
		}
	});
	$("#addQuote").submit(function( event ) {
		  event.preventDefault();
		  var formData = $("#addQuote").serialize();
		  console.log(formData);
			$.ajax("quotes.php",
			{type: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(data, status, jqXHR) {
				for (var i=0; i<data.length; i++) {	       	
					$("#res").prepend("Your Newly Added Quote: '<div class = 'resultDiv' >" + data[i].Text + '<div><span>' + data[i].Title + ' page ' + data[i].PageNumber + ' ' + data[i].Name + '</span><div><div><button onclick = deleteQuote(' + data[i].qID + ')>DELETE</button><div></div>');
						      }
						  },
			error: function(jqXHR, status, error) {
				alert(jqXHR.responseText);
			}});
		});
	$("#add").click(function(){
	  	$("#addQuote").toggle();
	});
});
	function deleteQuote(theQID){
		$.ajax("quotes.php/" + theQID,
			{type: "GET",
			dataType: "json",
			success: function(data, status, jqXHR) {
				$("#res").empty();
			    $("#res").prepend("Record Successfully deleted");		
			    } ,
	        error: function(XMLHttpRequest, textStatus, errorThrown) { 
	        	alert("Status: " + textStatus); alert("Error: " + errorThrown);     
			 }
		 });
	}