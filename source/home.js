$(document).ready(function(){
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
      city_name.className = "form-control";
      city_name.type = "text";
      city_name.name = "city_name";
      city_name.value = "";
      city_name.placeholder = "San Jose";

	  //button for submit
      var submit = document.createElement('input');
      submit.type = "submit";
	  submit.className = "btn btn-default";

	  //appends each input to form
      var to_append = [city_name,submit];
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
			console.log(data);
		});
	});
}
