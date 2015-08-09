var controller = {
  execute: function(data) {
    throw "Not Implemented yet. (expecting 'execute[Job|Company|Sector|Add[Job|Company|Sector|City]]')";
  },

  /*
   * GET JOB
   */
  executeJob: function(context) {
    var form_data = $(context).serializeArray();
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
      } else if (parsed_data["response"]["code"] == "200") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
        var job_data = parsed_data["data"];
        generate_table(parsed_data, "Company");
        if (typeof(job_data[0]) != 'undefined') {
          generate_table(job_data[0], "Job Information");
        }
      }
    });
  },

  /*
  * GET COMPANY
  */
  executeCompany: function(context) {
    var form_data = $(context).serializeArray();
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
  },

  /*
  * GET SECTOR
  */
  executeSector: function(context) {
    var form_data = $(context).serializeArray();
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

      } else {
        var parsed_data = JSON.parse(data);
        var job_data = parsed_data["job_data"];
        generate_table(parsed_data, "Sector");
        if (typeof(job_data[0]) != 'undefined') {
          generate_table(job_data[0], "Employee Information");
        }
      }
    });
  },

  /*
  * GET CITY
  */
  executeCity: function(context) {
    throw "Note implemented yet."
  },

  /*
   * ADD JOB
   */
  executeAddJob: function(context) {
    var form_data = $(context).serializeArray();
    var n = form_data[0].value;
    var s = form_data[1].value;
    var c = form_data[2].value;
    var l = form_data[3].value;

    var to_db = {
      type: "add_job",
      name: n,
      salary: s,
      company: c,
      location: l
    };
    //ajax request
    $.ajax({
      url: '../server/post.php',
      type: "POST",
      async: true,
      data: to_db
    }).done(function(data) {
      var parsed_data = JSON.parse(data);
      $('#profile_display').empty();
      $('#comment').append(comment);
      var comment = document.createElement('div');
      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
      } else if (parsed_data["response"]["code"] == "200") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
      }
    });
  },

  /*
   * ADD COMPANY
   */
  executeAddCompany: function(context) {
    var form_data = $(context).serializeArray();
    var n = form_data[0].value;
    var s = form_data[1].value;
    var p = form_data[2].value;
    var st = form_data[3].value;
    var cities = [];
    var sectors = [];
    form_data.forEach(function(element) {
      if (element.name == 'cities') {
        cities.push(element.value);
      }
      console.log(cities);
      if (element.name == 'sectors') {
        sectors.push(element.value);
      }
    });
    //addcheck for input after testing
    var to_db = {
      type: "add_company",
      name: n,
      size: s,
      profit: p,
      stock: st,
      cities: cities,
      sectors: sectors
    };
    $.ajax({
      url: '../server/post.php',
      type: "POST",
      async: true,
      data: to_db
    }).done(function(data){
      var parsed_data = JSON.parse(data);
      $('#profile_display').empty();
      var comment = document.createElement('div');
      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment2').append(comment);
      } else if (parsed_data["response"]["code"] == "200") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
      }
    });
  },

  /*
   * ADD SECTOR
   */
  executeAddSector: function(context) {
    throw "Not implemented yet."
  },

  /*
   * ADD CITY
   */
  executeAddCity: function(context) {
    throw "Not implemented yet."
  }
}
