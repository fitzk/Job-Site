var controller = {
  execute: function(data) {
    throw "Not Implemented yet. (expecting 'execute[Job|Company|Sector|Add[Job|Company|Sector|City]]')";
  },

  /*
   * GET JOB
   */
  executeJob: function(context) {
    $('#profile_display').empty();
    $('#comment').empty();
    var form_data = $(context).serializeArray();
    var n = form_data[0].value;
    var l = form_data[1].value;
    form_data.forEach(function(input) {
      if (input.value === "") {
        var error = document.createElement('div');
        error.appendChild(document.createTextNode("Please fill out all input fields."));
        $("#comment").append(error);
	  return;  
		}
    });

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
      var comment = document.createElement('div');
      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
      } else if (parsed_data["response"]["code"] == "200") {
        comment.innerHTML = '';
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
        var job_data = parsed_data["job_data"];
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
    $('#profile_display').empty();
    $('#comment').empty();
    var form_data = $(context).serializeArray();
    var n = form_data[0].value;
    var l = form_data[1].value;
    form_data.forEach(function(input) {
      if (input.value === "") {
        var error = document.createElement('div');
        error.appendChild(document.createTextNode("Please fill out all input fields."));
        $("#comment").append(error);
		return;
      }
    });

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

      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
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
  },

  /*
   * GET SECTOR
   */
  executeSector: function(context) {
    $('#profile_display').empty();
    $('#comment').empty();
    var form_data = $(context).serializeArray();
    var l = form_data[0].value;
    form_data.forEach(function(input) {
      if (input.value === "") {
        var error = document.createElement('div');
        error.appendChild(document.createTextNode("Please fill out all input fields."));
        $("#comment").append(error);
		return;
      }
    });
    var to_db = {
      type: "sector_city",
      //name: n,
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

      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));

        $('#comment').append(comment);
      } else if (parsed_data["response"]["code"] == "200") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment').append(comment);
        //var company_data = parsed_data["data"];
        generate_table(parsed_data, "Sector");
        //if (typeof(job_data[0]) != 'undefined') {
        //generate_table(job_data[0], "Compan");
        //}
      }
    });
  },

  /*
   * GET CITY
   */
  executeCity: function(context) {
    throw "Not implemented yet."
  },

  /*
   * ADD JOB
   */
  executeAddJob: function(context) {
    $('#profile_display').empty();
    $('#comment2').empty();
    var form_data = $(context).serializeArray();
    var n = form_data[0].value;
    var s = form_data[1].value;
    var c = form_data[2].value;
    var l = form_data[3].value;
	var empty_form = false;
    form_data.forEach(function(input) {
      if (input.value === "") {
        var error = document.createElement('div');
        error.appendChild(document.createTextNode("Please fill out all input fields."));
        $("#comment2").append(error);
		empty_form = true;
      }
    });
	if(empty_form){
		return;
	}
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
      var comment = document.createElement('div');
      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment2').append(comment);
      } else if (parsed_data["response"]["code"] == "200") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment2').append(comment);
      }
    });
  },

  /*
   * ADD COMPANY
   */
  executeAddCompany: function(context) {
    $('#profile_display').empty();
    $('#comment2').empty();
    var form_data = $(context).serializeArray();
    
	var empty_form = false;
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

      if (element.name == 'sectors') {
        sectors.push(element.value);
      }
	});  
	 if (n===""||s===""||p===""||st==""||(cities.length=== 0)|| (sectors.length===0)) {
        var error = document.createElement('div');
        error.appendChild(document.createTextNode("Please fill out all input fields."));
        $("#comment2").append(error);
		return;
      }

    
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
    }).done(function(data) {
      var parsed_data = JSON.parse(data);
      var comment = document.createElement('div');
      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment2').append(comment);
      } else if (parsed_data["response"]["code"] == "200") {

		comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
		$('#comment2').append(comment); 
      }
    });
  },

  /*
   * ADD SECTOR
   */
  executeAddSector: function(context) {
    $('#profile_display').empty();
    $('#comment2').empty();
    var form_data = $(context).serializeArray();
    form_data.forEach(function(input) {
      if (input.value === "") {
        var error = document.createElement('div');
        error.appendChild(document.createTextNode("Please fill out all input fields."));
        $("#comment2").append(error);
		empty_form = true;
      }
    });
	if(empty_form){
		return;
	}
    var n = form_data[0].value;
    var d = form_data[1].value;
    var to_db = {
      type: "add_sector",
      sector_name: n,
      sector_description: d
    };
    //ajax request
    $.ajax({
      url: '../server/post.php',
      type: "POST",
      async: true,
      data: to_db
    }).done(function(data) {
      console.log(data);
      var parsed_data = JSON.parse(data);
      var comment = document.createElement('div');
      $('#comment2').append(comment);
      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment2').append(comment);
      } else if (parsed_data["response"]["code"] == "200") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment2').append(comment);
      }
    });
  },

  /*
   * ADD CITY
   */
  executeAddCity: function(context) {
    $('#profile_display').empty();
    $('#comment2').empty();
    var form_data = $(context).serializeArray();
	var empty_form = false;
    form_data.forEach(function(input) {
      if (input.value === "") {
        var error = document.createElement('div');
        error.appendChild(document.createTextNode("Please fill out all input fields."));
        $("#comment2").append(error);
		empty_form = true;
      }
    });
	if(empty_form){
		return;
	}
    var n = form_data[0].value;
    var to_db = {
      type: "add_city",
      name: n
    };
    //ajax request
    $.ajax({
      url: '../server/post.php',
      type: "POST",
      async: true,
      data: to_db
    }).done(function(data) {
      console.log(data);
      var parsed_data = JSON.parse(data);
      var comment = document.createElement('div');
      $('#comment2').append(comment);
      if (parsed_data["response"]["code"] == "400") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment2').append(comment);
      } else if (parsed_data["response"]["code"] == "200") {
        comment.appendChild(document.createTextNode(parsed_data["response"]["comment"]));
        $('#comment2').append(comment);
      }
    });
  }
}