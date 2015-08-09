$(document).ready(function() {
  //city_search();

  add_job();

  $('#company_location').click(function() {
    add_company();
  });

  $('#job_location').click(function() {
    add_job();
  });
});
/////////////////////////////////////
//
//
////////////////////////////////////
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
//////////////////////////////////////
// function: makes_ddmenu
// function generates a drop down
// menu from a javascript object
//////////////////////////////////////
function makes_ddmenu(data) {
  var btn_group = document.createElement('div');
  var button = document.createElement('button');
  button.className = "btn btn-default dropdown-toggle";
  button.setAttribute(data - toggle, "dropdown");
  button.setAttribute(aria - haspopup, "true");
  button.setAttribute(aria - expanded, "false");
  var caret = document.createElement("span");
  caret.className = "caret";
  var face_text = document.createTextNode(data["header"]);
  button.appendChild(face_text);
  button.appendChild(caret);
  btn_group.appendChild(button);
  var select = document.createElement('select');
  data["data"].forEach(function(object) {
    for (var property in object) {
      if (object.hasOwnProperty(property)) {
        var option = document.createElement('option');
        var content = document.createTextNode(value);
        option.appendChild(content);
        select.appendChild(option);
      }
    }
  });
  return btn_group;
}
//////////////////////////////////////
// add company
//
///////////////////////////////////////
function add_company() {

  var main_div = document.getElementById('form_main');
  main_div.innerHTML = '';
  var async_div = document.getElementById('async');
  async_div.innerHTML = '';
  //create form
  var company_name_div = document.createElement("div");
  company_name_div.className = "";
  var company_name = document.createElement('input');
  company_name.className = "form-control";
  company_name.type = "text";
  company_name.name = "name";
  company_name.value = "";
  company_name.placeholder = "Compani";
  company_name_div.appendChild(company_name);

  var size_div = document.createElement("div");
  size_div.className = "";
  var size = document.createElement('input');
  size.className = "form-control";
  size.type = "text";
  size.name = "size";
  size.value = "";
  size.placeholder = "5000+";
  size_div.appendChild(size);

  var profit_div = document.createElement("div");
  profit_div.className = "";
  var profit = document.createElement('input');
  profit.className = "form-control";
  profit.type = "text";
  profit.name = "profit";
  profit.value = "";
  profit.placeholder = "$2 billion+";
  profit_div.appendChild(profit);

  var stock_symbol_div = document.createElement("div");
  stock_symbol_div.className = "";
  var stock_symbol = document.createElement('input');
  stock_symbol.className = "form-control";
  stock_symbol.type = "text";
  stock_symbol.name = "stock_symbol";
  stock_symbol.placeholder = "STK";
  stock_symbol.value = "";
  stock_symbol_div.appendChild(stock_symbol);

  var company_name_label = document.createElement("label");
  company_name_label.setAttribute('for', 'name');
  company_name_label.className = "control-label";
  var company_name_text = document.createTextNode("Name");
  company_name_label.appendChild(company_name_text);

  var size_label = document.createElement('label');
  size_label.setAttribute('for', 'size');
  size_label.className = "control-label";
  var size_text = document.createTextNode("Number of Employees");
  size_label.appendChild(size_text);

  var profit_label = document.createElement('label');
  profit_label.className = "control-label";
  profit_label.setAttribute('for', 'profit');
  var profit_text = document.createTextNode("Anual Profit");
  profit_label.appendChild(profit_text);

  var stock_symbol_label = document.createElement('label');
  stock_symbol_label.setAttribute('for', 'stock_symbol');
  stock_symbol_label.className = "control-label";
  var stock_symbol_text = document.createTextNode("Stock Symbol");
  stock_symbol_label.appendChild(stock_symbol_text);
  //appends each input to form
  var company_name_group = document.createElement("div");
  company_name_group.className = "form-group";
  company_name_group.appendChild(company_name_label);
  company_name_group.appendChild(company_name_div);

  var size_group = document.createElement("div");
  size_group.className = "form-group";
  size_group.appendChild(size_label);
  size_group.appendChild(size_div);

  var profit_group = document.createElement("div");
  profit_group.className = "form-group";
  profit_group.appendChild(profit_label);
  profit_group.appendChild(profit_div);

  var stock_symbol_group = document.createElement("div");
  stock_symbol_group.className = "form-group";
  stock_symbol_group.appendChild(stock_symbol_label);
  stock_symbol_group.appendChild(stock_symbol_div);

  var to_append = [company_name_group, size_group, profit_group, stock_symbol_group];
  to_append.forEach(function(element) {
    main_div.appendChild(element);
  });

  get_cities();
  get_sectors();
  //button for submit
  controller.execute = controller.executeAddCompany;
}
////////////////////////////////////////
// function: get sectors
// returns a list of current sectors in
// database for reference when a user
// adds a company or another sector
///////////////////////////////////////
function get_sectors() {
  var to_db = {
    type: "sector"
  };
  //ajax request
  $.ajax({
    url: '../server/get.php',
    type: "GET",
    async: true,
    data: to_db
  }).done(function(data) {
    checkboxes(data, "sectors");
  });
}
///////////////////////////////////////
//
//////////////////////////////////////
function get_cities() {
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
    checkboxes(data, "cities");
  });
}
//////////////////////////////////////
//function: add Job
// adds employee to database
////////////////////////////////////
function add_job() {
  //clear main
  //$('#form_jcs').empty();
  var form_area = document.getElementById("form_jcs");
  form_area.firstChild.id = "aj_form";
  var main_div = document.getElementById("form_main");
  main_div.innerHTML = '';
  var async_div = document.getElementById('async');
  async_div.innerHTML = '';

  var name_div = document.createElement("div");
  name_div.className = "";
  var name = document.createElement('input');
  name.className = "form-control";
  name.type = "text";
  name.name = "name";
  name.value = "";
  name.placeholder = "Software Engineer";
  name_div.appendChild(name);

  var salary_div = document.createElement("div");
  salary_div.className = "";
  var salary = document.createElement('input');
  salary.className = "form-control";
  salary.type = "text";
  salary.name = "salary";
  salary.value = "";
  salary.placeholder = "90000";
  salary_div.appendChild(salary);

  var company_div = document.createElement("div");
  company_div.className = "";
  var company = document.createElement('input');
  company.className = "form-control";
  company.type = "text";
  company.name = "company";
  company.value = "";
  company.placeholder = "Intuit";
  company_div.appendChild(company);

  var location_div = document.createElement("div");
  location_div.className = "";
  var location = document.createElement('input');
  location.className = "form-control";
  location.type = "text";
  location.name = "location";
  location.placeholder = "San Jose";
  location.value = "";
  location_div.appendChild(location);
  //button for submit
  var submit_div = document.createElement("div");
  submit_div.className = "text-right";
  var submit = document.createElement('input');
  submit.type = "submit";
  submit.className = "btn btn-default";
  submit_div.appendChild(submit);
  //list.insertBefore(newItem, list.childNodes[0]);
  var name_label = document.createElement("label");
  name_label.setAttribute('for', 'name');
  name_label.className = "control-label";
  var name_text = document.createTextNode("Job Title");
  name_label.appendChild(name_text);

  var company_label = document.createElement('label');
  company_label.setAttribute('for', 'company');
  company_label.className = "control-label";
  var company_text = document.createTextNode("Company Name");
  company_label.appendChild(company_text);

  var location_label = document.createElement('label');
  location_label.setAttribute('for', 'location');
  location_label.className = "control-label";
  var location_text = document.createTextNode("Company Location");
  location_label.appendChild(location_text);

  var salary_label = document.createElement('label');
  salary_label.setAttribute('for', 'salary');
  salary_label.className = "control-label";
  var salary_text = document.createTextNode("Employee Salary");
  salary_label.appendChild(salary_text);
  //appends each input to form
  var name_group = document.createElement("div");
  name_group.className = "form-group";
  name_group.appendChild(name_label);
  name_group.appendChild(name_div);

  var salary_group = document.createElement("div");
  salary_group.className = "form-group";
  salary_group.appendChild(salary_label);
  salary_group.appendChild(salary_div);

  var company_group = document.createElement("div");
  company_group.className = "form-group";
  company_group.appendChild(company_label);
  company_group.appendChild(company_div);

  var location_group = document.createElement("div");
  location_group.className = "form-group";
  location_group.appendChild(location_label);
  location_group.appendChild(location_div);

  var to_append = [name_group, salary_group, company_group, location_group];
  to_append.forEach(function(element) {
    main_div.appendChild(element);
  });
  controller.execute = controller.executeAddJob;
}
///////////////////////////////////////
// params: form object, json object,
// string for checkbox group name
// creates checkboxes and appends to
// form
/////////////////////////////////////
function checkboxes(data, name) {
  var pdata = JSON.parse(data);
  var form = document.getElementById("async");
  var form_group = document.createElement('div');
  form_group.className = 'form-group';
  pdata["data"].forEach(function(object) {
    for (var property in object) {
      if (object.hasOwnProperty(property)) {
        var label = document.createElement("label");
        label.className = "form control";
        var description = document.createTextNode(object[property]);
        var checkbox = document.createElement("input");

        checkbox.type = "checkbox";
        checkbox.className = "form-inline";
        checkbox.name = name;
        checkbox.id = object[property];
        checkbox.value = object[property];

        label.appendChild(checkbox); // add the box to the element
        label.appendChild(description); // add the description to the element
      }
      form_group.appendChild(label);
    }
    form.appendChild(form_group);
  });
}
