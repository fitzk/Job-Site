$(document).ready(function() {
  city_search();
});

function city_search() {

  var city = document.getElementById("city");
  //create form
  var form_div = document.createElement('div');
  		form_div.className = "form-group";
  var city_form = document.createElement('form');
  		city_form.className = "";
  		city_form.id = "city_form";
  		city_form.method = "POST";

  //input for city search
  var city_name = document.createElement('input');
  		city_name.className = "span3";
  		city_name.type = "text";
  		city_name.name = "city_name";
  		city_name.value = "";
  		city_name.placeholder = "San Jose";

  //button for submit
  var submit = document.createElement('input');
  		submit.type = "submit";
  		submit.className = "btn btn-default";

  //appends each input to form
  var to_append = [city_name, submit];
  to_append.forEach(function(element) {
    city_form.appendChild(element);
  });


  var city_name_text = document.createTextNode("Enter a City ");
  		city_form.insertBefore(city_name_text, city_name);
  		city.appendChild(city_form);

  $('#city_form').submit(function(event) {
    event.preventDefault();
    var city_form_data = $(this).serializeArray();
    var name = city_form_data[0].value;

    var to_db = {
      type: 'initial_search',
      city_name: name
    };
    //ajax request
    $.ajax({
      url: '../server/handler.php',
      type: 'POST',
      async: true,
      data: to_db
    }).done(function(data) {
      generate_table(data);
    });
  });
}


function generate_table(data) {

  var table_content = JSON.parse(data);
  var profile_display = document.getElementById('profile_display');
  var outer_div = document.createElement('div');
  		outer_div.className = "span6";
  var profile = document.createElement('table');
  		profile.className = "table table-striped table-condensed";
	var t_body = document.createElement('tbody');
	var	t_head = document.createElement('thead');
	var counter = 0;
	t_body.appendChild(t_head);
	var th_data = document.createElement('td');
	var th_input = document.createTextNode("Companies");
			th_data.appendChild(th_input);
			t_head.appendChild(th_data);

  table_content.forEach(function(object) {
    var table_row = document.createElement('tr');
    for (var property in object) {
      if (object.hasOwnProperty(property)) {
        var table_data = document.createElement('td');
        var value = object[property];
        var table_input = document.createTextNode(value);
        		table_data.appendChild(table_input);
        		table_row.appendChild(table_data);
      }
			t_body.appendChild(table_row);
    }
    profile.appendChild(document.createElement('br'));
    profile.appendChild(document.createElement('br'));
		profile.appendChild(t_body);
		outer_div.appendChild(profile);
		profile_display.appendChild(outer_div);

  });
}
