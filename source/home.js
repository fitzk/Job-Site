$(document).ready(function() {
  //city_search();
  job_city_form();
  get_average_salary();
  $('#company_city').click(function() {
    company_city_form();
  });

  $('#job_city').click(function() {

    job_city_form();
  });
  $('#sector_city').click(function() {
    $('#profile_display').empty();
    get_sector();
    sector_city_form();
  });
});

function format2currency(n, currency) {

  var pattern = /^[0-9]*$/;
  if (pattern.test(n)) {
    if (typeof(n) == 'string') {
      n = parseInt(n);
    }
    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
  } else {
    return n;
  }
}
////////////////////////////////////////
//
//
//
////////////////////////////////////////
function get_average_salary() {

  var to_db = {
    type: "get_ave",
  };
  $.ajax({
    url: '../server/get.php',
    type: "GET",
    async: true,
    data: to_db
  }).done(function(data) {
    var parsed_data = JSON.parse(data);
    $('#profile_display').empty();
    generate_table(parsed_data, "Salary by Job Title");
  });
}
////////////////////////////////////////////////////
// function: generate table
// paramebers: unparsed JSON object and a
// Title for the Table
////////////////////////////////////////////////////
function generate_table(table_content, text) {
  var profile_display = document.getElementById('profile_display');
  var profile = document.createElement('table');
  profile.className = "table table-striped table-condensed";
  var t_body = document.createElement('tbody');
  var t_head = document.createElement('h3');
  var th_text = document.createTextNode(text);
  t_head.appendChild(th_text);
  profile_display.appendChild(t_head);

  table_content["headers"].forEach(function(header) {
    var table_row = document.createElement('tr');
    for (var property in header) {
      if (header.hasOwnProperty(property)) {
        var row_header = document.createElement('th');
        var value = header[property];
        var table_input = document.createTextNode(value);
        row_header.appendChild(table_input);
        table_row.appendChild(row_header);
      }
      t_body.appendChild(table_row);
    }
  });

  table_content["data"].forEach(function(object) {
    var table_row = document.createElement('tr');
    for (var property in object) {
      if (object.hasOwnProperty(property)) {
        var table_data = document.createElement('td');
        var pre_check = object[property];
        var value = format2currency(pre_check, "$");
        var table_input = document.createTextNode(value);
        table_data.appendChild(table_input);
        table_row.appendChild(table_data);
      }
      t_body.appendChild(table_row);
    }
    // profile.appendChild(document.createElement('br'));
    // profile.appendChild(document.createElement('br'));
    profile.appendChild(t_body);
    profile_display.appendChild(profile);

  });
}
////////////////////////////////////////////////////
// function: company & city
// on click form is generated, takes
// company name and city, returns company, and
// employee information for that company in that
// city
////////////////////////////////////////////////////
function company_city_form() {
  //clear main
  var form=document.getElementById("form_jcs");
  form.firstChild.id='c_form';

  var main_div= document.getElementById('form_main');
  main_div.innerHTML='';
  var async_div=document.getElementById('form_async');
  async_div.innerHTML='';

  var name_div = document.createElement("div");
  name_div.className = "";
  var name = document.createElement('input');
  name.className = "form-control";
  name.type = "text";
  name.name = "name";
  name.value = "";
  name.placeholder = "Company Name";
  name_div.appendChild(name);
  //input for company size
  var location_div = document.createElement("div");
  location_div.className = "";
  var location = document.createElement('input');
  location.className = "form-control";
  location.type = "text";
  location.name = "location";
  location.placeholder = "City";
  location.value = "";
  location_div.appendChild(location);
  //list.insertBefore(newItem, list.childNodes[0]);
  var name_label = document.createElement("label");
  name_label.setAttribute('for', 'name');
  name_label.className = "control-label";
  var name_text = document.createTextNode("Company");
  name_label.appendChild(name_text);

  var location_label = document.createElement('label');
  location_label.setAttribute('for', 'location');
  location_label.className = "control-label";
  var location_text = document.createTextNode("City");
  location_label.appendChild(location_text);
  //appends each input to form
  var to_append = [name_label, name_div, location_label, location_div];
  to_append.forEach(function(element) {
    main_div.appendChild(element);
  });

  //ajax request with new task form info
  //if successful, prints message, asks
  //user if they would like to start task
  $('#c_form').submit(function(event) {
    event.preventDefault();
    //change to lower case
    var form_data = $(this).serializeArray();
    var n = form_data[0].value;
    var l = form_data[1].value;

    var to_db = {
      type: "company_city",
      name: n,
      location: l
    };
    //ajax request
    $.ajax({
      url: '../server/get.php',
      type: "GET",
      async: true,
      data: to_db
    }).done(function(data) {
      var parsed_data = JSON.parse(data);
      var comment = document.createElement('div');
      $('#profile_display').empty();
      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
      } else if(parsed_data["response"]["code"] == "200") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
        var job_data = parsed_data["job_data"];
        generate_table(parsed_data, "Company");
        if (typeof(job_data[0]) != 'undefined') {
          generate_table(job_data[0], "Employee Information");
        }
        generate_table(parsed_data);
      }
    });
  });
}
/////////////////////////////////////////////////////
//function: job & city
// on click form is generated, form takes
// employee title and city, server returns employee
// information for that city and generates
// a table of the information
////////////////////////////////////////////////////
function job_city_form() {
  var form=document.getElementById("form_jcs");
  form.firstChild.id='j_form';

  var main_div= document.getElementById('form_main');
  main_div.innerHTML='';
  var async_div=document.getElementById('form_async');
  async_div.innerHTML='';

  var name_div = document.createElement("div");
  name_div.className = "";
  var name = document.createElement('input');
  name.className = "form-control";
  name.type = "text";
  name.name = "name";
  name.value = "";
  name.placeholder = "Software Engineer";
  name_div.appendChild(name);
  //input for company size
  var location_div = document.createElement("div");
  location_div.className = "";
  var location = document.createElement('input');
  location.className = "form-control";
  location.type = "text";
  location.name = "location";
  location.placeholder = "San Jose";
  location.value = "";
  location_div.appendChild(location);

  //list.insertBefore(newItem, list.childNodes[0]);
  var name_label = document.createElement("label");
  name_label.setAttribute('for', 'name');
  name_label.className = "control-label";
  var name_text = document.createTextNode("Title");
  name_label.appendChild(name_text);

  var location_label = document.createElement('label');
  location_label.setAttribute('for', 'location');
  location_label.className = "control-label";
  var location_text = document.createTextNode("City");
  location_label.appendChild(location_text);
  //appends each input to form
  var to_append = [name_label, name_div, location_label, location_div];
  to_append.forEach(function(element) {
    main_div.appendChild(element);
  });

  //ajax request with new task form info
  //if successful, prints message, asks
  //user if they would like to start task
  $('#j_form').submit(function(event) {
    event.preventDefault();
    //change to lower case
    var form_data = $(this).serializeArray();
    var n = form_data[0].value;
    var l = form_data[1].value;

    var to_db = {
      type: "job_city",
      name: n,
      location: l
    };
    //ajax request
    $.ajax({
      url: '../server/get.php',
      type: "GET",
      async: true,
      data: to_db
    }).done(function(data) {
      var parsed_data = JSON.parse(data);
      $('#profile_display').empty();
      var comment = document.createElement('div');
      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
        error_div.appendChild(error);
        main.appendChild(error_div);
      } else if (parsed_data["response"]["code"] == "200") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
        var job_data = parsed_data["job_data"];
        generate_table(parsed_data, "Company");
        if (typeof(job_data[0]) != 'undefined') {
          generate_table(job_data[0], "Employee Information");
        }
      }
    });
  });
}
/////////////////////////////////////////////////////
//
//
/////////////////////////////////////////////////////
function sector_city_form() {
  var form=document.getElementById("form_jcs");
  form.firstChild.id='s_form';
  var main_div= document.getElementById('form_main');
  main_div.innerHTML='';
  var async_div=document.getElementById('form_async');
  async_div.innerHTML='';

  var name_div = document.createElement("div");
  name_div.className = "";
  var name = document.createElement('input');
  name.className = "form-control";
  name.type = "text";
  name.name = "name";
  name.value = "";
  name.placeholder = "sector Name";
  name_div.appendChild(name);
  //input for sector size
  var location_div = document.createElement("div");
  location_div.className = "";
  var location = document.createElement('input');
  location.className = "form-control";
  location.type = "text";
  location.name = "location";
  location.placeholder = "City";
  location.value = "";
  location_div.appendChild(location);

  //list.insertBefore(newItem, list.childNodes[0]);
  var name_label = document.createElement("label");
  name_label.setAttribute('for', 'name');
  name_label.className = "control-label";
  var name_text = document.createTextNode("sector");
  name_label.appendChild(name_text);

  var location_label = document.createElement('label');
  location_label.setAttribute('for', 'location');
  location_label.className = "control-label";
  var location_text = document.createTextNode("City");
  location_label.appendChild(location_text);
  //appends each input to form
  var to_append = [name_label, name_div, location_label, location_div];
  to_append.forEach(function(element) {
    main_div.appendChild(element);
  });

  //ajax request with new task form info
  //if successful, prints message, asks
  //user if they would like to start task
  $('#s_form').submit(function(event) {
    event.preventDefault();
    //change to lower case
    var form_data = $(this).serializeArray();
    var n = form_data[0].value;
    var l = form_data[1].value;

    var to_db = {
      type: "sector_city",
      name: n,
      location: l
    };
    //ajax request
    $.ajax({
      url: '../server/get.php',
      type: "GET",
      async: true,
      data: to_db
    }).done(function(data) {
        main_div.innerHTML='';
      $('#profile_display').empty();
      if (data == "400") {
        var main = document.getElementById("profile_display");
        var error_div = document.createElement('div');
        error_div.className = "error";
        var error = document.createTextNode("No results match sector or location, please try again.");
        error_div.appendChild(error);
        main.appendChild(error_div);
      } else {
        var parsed_data = JSON.parse(data);
        var job_data = parsed_data["job_data"];
        generate_table(parsed_data, "Sector");
        if (typeof(job_data[0]) != 'undefined') {
          generate_table(job_data[0], "Employee Information");
        }
      }
    });
  });
}
///////////////////////////////////////
//
//////////////////////////////////////
function get_cities(form) {
  var to_db = {
    type: "city"
  };
  //ajax request
  $.ajax({
    url: '../server/get.php',
    type: "GET",
    async: true,
    data: to_db
  }).done(function(data) {
    checkboxes(form, data, "cities");
  });
}
////////////////////////////////////////
// function: get sectors
// returns a list of current sectors in
// database for reference when a user
// adds a company or another sector
///////////////////////////////////////
function get_sector() {
  var to_db = {
    type: "sector2"
  };
  //ajax request
  $.ajax({
    url: '../server/get.php',
    type: "GET",
    async: true,
    data: to_db
  }).done(function(data) {
    var s_data = JSON.parse(data);
    generate_table(s_data, "Active Sectors");
    //  checkboxes(form, data, "sectors");
  });
}
