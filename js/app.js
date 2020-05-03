$(document).ready(function(){
    var resultArea = $("#results");
    var searchBar = $("#email");
    var searchButton = $("#check");
    var searchUrl = "./search.php";
    var displayResults = function(email) {
      $.ajax({
        url: `${searchUrl}?email=${email}`,
        dataType: 'json',
        beforeSend: function() {
          $('.loader').show();
        },
        success: function(json) {
          $('.loader').hide();
          var msg;
          if (json.success == true) {
            if (json.data.leaked == true) {
                msg = "Email Leaked";
            } else if (json.data.leaked == null) {
                msg = "Invalid";
            } else {
                msg = "Safe";
            }
          } else {
            msg = "No email";
          }
          var elem1 = $('<li>');
          elem1.append($('<h3>').text(msg));
          elem1.append($('<p>').text(json.message));
          resultArea.append(elem1);
        }
      });   
    };

    searchButton.click(function() {
      email = searchBar.val(),
      resultArea.empty();
      displayResults(email);
    });
    
    searchBar.keypress(function(e){
        if(e.keyCode==13)
        $(searchButton).click();
    });
  
  });