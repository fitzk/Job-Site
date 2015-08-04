$(document).ready(function() {
  //city_search();
  $('#company_location').click(function() {
    company_location_form();
  });

  $('#job_location').click(function() {
    job_location_form();
  });
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
  $('#profile_display').empty();
  var table_content = JSON.parse(data);
  var profile_display = document.getElementById('profile_display');
  var outer_div = document.createElement('div');
  outer_div.className = "span6";
  var profile = document.createElement('table');
  profile.className = "table table-striped table-condensed";
  var t_body = document.createElement('tbody');
  var t_head = document.createElement('thead');
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

function company_location_form() {
  //clear main
  $('#form_jcs').empty();
  var form_area = document.getElementById("form_jcs");
  //create form
  var form_div = document.createElement('div');
  form_div.className = "form-group";
  var form = document.createElement('form');
  form.className = "";
  form.id = "cl_form";
  form.method = "POST";
  //input for company name
  var name = document.createElement('input');
  name.className = "form-control";
  name.type = "text";
  name.name = "name";
  name.value = "";
  name.placeholder = "Company Name";
  //input for company size
  var location = document.createElement('input');
  location.className = "form-control";
  location.type = "text";
  location.name = "location";
  location.placeholder = "City";
  location.value = "";
  //button for submit
  var submit = document.createElement('input');
  submit.type = "submit";
  submit.className = "btn btn-default";
  //appends each input to form
  var to_append = [name, location, submit];
  to_append.forEach(function(element) {
    form.appendChild(element);
  });
  //list.insertBefore(newItem, list.childNodes[0]);
  var name_text = document.createTextNode("Company");
  var location_text = document.createTextNode("City");
  form.insertBefore(name_text, name);
  form.insertBefore(location_text, location);
  //append form to section main
  form_div.appendChild(form);
  form_area.appendChild(form_div);
  //ajax request with new task form info
  //if successful, prints message, asks
  //user if they would like to start task
  $('#cl_form').submit(function(event) {
    event.preventDefault();
    //change to lower case
    var form_data = $(this).serializeArray();
    var n = form_data[0].value;
    var l = form_data[1].value;

    var to_db = {
      type: "search_company_location",
      name: n,
      location: l
    };
    //ajax request
    $.ajax({
      url: '../server/handler.php',
      type: "POST",
      async: true,
      data: to_db
    }).done(function(data) {
      generate_table(data);
    });
  });
}

function job_location_form() {
  //clear main
  $('#form_jcs').empty();
  var form_area = document.getElementById("form_jcs");
  //create form
  var form_div = document.createElement('div');
  form_div.className = "form-group";
  var form = document.createElement('form');
  form.className = "";
  form.id = "jl_form";
  form.method = "POST";
  //input for company name
  var name = document.createElement('input');
  name.className = "form-control";
  name.type = "text";
  name.name = "name";
  name.value = "";
  name.placeholder = "Job Title";
  //input for company size
  var location = document.createElement('input');
  location.className = "form-control";
  location.type = "text";
  location.name = "location";
  location.placeholder = "City";
  location.value = "";
  //button for submit
  var submit = document.createElement('input');
  submit.type = "submit";
  submit.className = "btn btn-default";
  //appends each input to form
  var to_append = [name, location, submit];
  to_append.forEach(function(element) {
    form.appendChild(element);
  });
  //list.insertBefore(newItem, list.childNodes[0]);
  var name_text = document.createTextNode("Job Title");
  var location_text = document.createTextNode("City");
  form.insertBefore(name_text, name);
  form.insertBefore(location_text, location);
  //append form to section main
  form_div.appendChild(form);
  form_area.appendChild(form_div);
  //ajax request with new task form info
  //if successful, prints message, asks
  //user if they would like to start task
  $('#jl_form').submit(function(event) {
    event.preventDefault();
    //change to lower case
    var form_data = $(this).serializeArray();
    var n = form_data[0].value;
    var l = form_data[1].value;

    var to_db = {
      type: "search_job_location",
      name: n,
      location: l
    };
    //ajax request
    $.ajax({
      url: '../server/handler.php',
      type: "POST",
      async: true,
      data: to_db
    }).done(function(data) {
      generate_table(data);
    });
  });
}
