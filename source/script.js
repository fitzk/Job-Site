$(document).ready(function(){
	company_form();
	sector_form();
});


function company_form() {
      //clear main
      $('#company').empty();
      var company = document.getElementById("company");
      //create form
	  var form_div = document.createElement('div');
	  form_div.className = "form-group";
      var co_form = document.createElement('form');
      co_form.className = "";
	  co_form.id = "co_form";
      co_form.method = "POST";
      //input for company name
      var co_name = document.createElement('input');
      co_name.className = "form-control";
      co_name.type = "text";
      co_name.name = "co_name";
      co_name.value = "";
      co_name.placeholder = "Ex: TechTrash";
      //input for company size
      var co_size = document.createElement('input');
      co_size.className = "form-control";
      co_size.type = "text";
      co_size.name = "co_size";
      co_size.placeholder = "";
      co_size.value = "";
      //input for company profit
      var co_profit = document.createElement('input');
      co_profit.className = "form-control";
      co_profit.type = "text";
      co_profit.name = "co_profit";
      co_profit.value = "";
      co_profit.placeholder = "";
      //button for submit
      var submit = document.createElement('input');
      submit.type = "submit";
	  submit.className = "btn btn-default";
      //appends each input to form
      var to_append = [co_name, co_size, co_profit, submit];
      to_append.forEach(function(element) {
         co_form.appendChild(element);
      });
      //list.insertBefore(newItem, list.childNodes[0]);
      var co_name_text = document.createTextNode("Name");
      var co_size_text = document.createTextNode("Number of Employees");
      var co_profit_text = document.createTextNode("Profit");
	  var co_rating_text = document.createTextNode("Rating");
      co_form.insertBefore(co_name_text, co_name);
      co_form.insertBefore(co_size_text, co_size);
      co_form.insertBefore(co_profit_text, co_profit);
      //append form to section main
	  form_div.appendChild(co_form);
	  company.appendChild(form_div);
	  //ajax request with new task form info
	//if successful, prints message, asks
	//user if they would like to start task
	$('#co_form').submit(function(event) {
		event.preventDefault();
		var co_form_data = $(this).serializeArray();
		var name = co_form_data[0].value;
		var size = co_form_data[1].value;
		var profit = co_form_data[2].value;

		var to_db = {
		   type: "add_company",
		   co_name: name,
		   co_size: size,
		   co_profit: profit
		};
		//ajax request
		$.ajax({
			url: 'handler.php',
			type: "POST",
			async: true,
			data: to_db
		}).done(function(data) {
			console.log(data);
		});
	});
}

function sector_form() {
      //clear main
    //  $('#sector').empty();
      var sector = document.getElementById("sector");
      //create form
	  var form_div = document.createElement('div');
	  form_div.className = "form-group";
	  form_div.id = "sector_div";
      var sector_form = document.createElement('form');
      sector_form.className = "";
	  sector_form.id = "sector_form";
      sector_form.method = "POST";
      //input for sector name
      var sector_name = document.createElement('input');
      sector_name.className = "form-control";
      sector_name.type = "text";
      sector_name.name = "sector_name";
      sector_name.value = "";
      sector_name.placeholder = "";
      //input for sector size
      var sector_description = document.createElement('input');
      sector_description.className = "form-control";
      sector_description.type = "text";
      sector_description.name = "sector_description";
      sector_description.placeholder = "";
      sector_description.value = "";
      //button for submit
      var submit = document.createElement('input');
      submit.type = "submit";
	  submit.className = "btn btn-default";
      //appends each input to form
      var to_append = [sector_name, sector_description, submit];
      to_append.forEach(function(element) {
         sector_form.appendChild(element);
      });
      //list.insertBefore(newItem, list.childNodes[0]);
      var sector_name_text = document.createTextNode("Sector Name");
      var sector_description_text = document.createTextNode("Description");
      sector_form.insertBefore(sector_name_text, sector_name);
      sector_form.insertBefore(sector_description_text, sector_description);
      //append form to section main
	  form_div.appendChild(sector_form);
	  sector.appendChild(form_div);
	  //ajax request with new task form info
	//if successful, prints message, asks
	//user if they would like to start task
	$('#sector_form').submit(function(event) {
		event.preventDefault();
		var sector_form_data = $(this).serializeArray();
		var name = sector_form_data[0].value;
		var description = sector_form_data[1].value;

		var to_db = {
		   type: "add_sector",
		   sector_name: name,
		   sector_description: description
		};
		//ajax request
		$.ajax({
			url: '../server/handler.php',
			type: "POST",
			async: true,
			data: to_db
		}).done(function(data) {
			console.log(data);
		});
	});
}
