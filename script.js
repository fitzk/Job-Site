$(document).ready(function(){
	company_form();
});


function company_form() {
      //clear main
      $('#company').empty();
      var company = document.getElementById("company");
      var header = document.createElement("header");
      var h_text = document.createTextNode("Company");
      header.appendChild(h_text);
      company.appendChild(header);
      //create form
      var co_form = document.createElement('form');
      co_form.className = "f_a";
      co_form.method = "POST";
      //input for company name
      var co_name = document.createElement('input');
      co_name.className = "inputField";
      co_name.type = "text";
      co_name.name = "co_name";
      co_name.value = "";
      co_name.placeholder = "Ex: TechTrash";
      //input for company size
      var co_size = document.createElement('input');
      co_size.className = "inputField";
      co_size.type = "text";
      co_size.name = "co_size";
      co_size.placeholder = "Ex: 500";
      co_size.value = "";
      //input for company profit
      var co_profit = document.createElement('input');
      co_profit.className = "inputField";
      co_profit.type = "text";
      co_profit.name = "co_profit";
      co_profit.value = "";
      co_profit.placeholder = "Ex: 2 Billion Annually";
	  //input for company rating
      var co_rating = document.createElement('input');
      co_rating.className = "inputField";
      co_rating.type = "text";
      co_rating.name = "co_profit";
      co_rating.value = "";
      co_rating.placeholder = "cool";
      //button for submit
      var submit = document.createElement('input');
      submit.type = "submit";
      //appends each input to form
      var to_append = [co_name, co_size, co_profit, co_rating,submit];
      to_append.forEach(function(element) {
         co_form.appendChild(document.createElement("br"));
         co_form.appendChild(element);
         co_form.appendChild(document.createElement("br"));
      });
      //list.insertBefore(newItem, list.childNodes[0]);
      var co_name_text = document.createTextNode("Name");
      var b1 = document.createElement("br");
      var co_size_text = document.createTextNode("Number of Employees");
      var co_profit_text = document.createTextNode("Profit");
	  var co_rating_text = document.createTextNode("Rating");
      co_form.insertBefore(co_name_text, co_form.childNodes[0]);
      co_form.insertBefore(co_size_text, co_form.childNodes[4]);
      co_form.insertBefore(co_profit_text, co_form.childNodes[8]);
	  co_form.insertBefore(co_rating_text, co_form.childNodes[12]);
      //append form to section main
      company.appendChild(co_form);
      //ajax request with new task form info
      //if successful, prints message, asks
      //user if they would like to start task
     /*  $('#newTask').submit(function(event) {
         event.preventDefault();
         var taskData = $(this).serializeArray();
         //	console.log(taskData);
         var t = taskData[0].value;
         var c = taskData[1].value;
         var est = taskData[2].value;
         var tsk = {
               type: "postTask",
               //      email: sessionStorage.getItem('email'),
               task: t,
               co_size: c,
               co_profit: est
            };
            //ajax request
         $.ajax({
            url: "main.php",
            type: "POST",
            async: true,
            data: tsk
         }).done(function(data) {
            var company = document.getElementById('company');
			var succ = document.getElementById('success');
			if(succ) succ.parentNode.removeChild(succ);
            var p = document.createElement('p');
			p.id="success";
            p.appendChild(document.createTextNode(
               'Your task '+t+' has been added!'));
            company.appendChild(p);
         });
         $(this).closest('form').find(
            "input[type=text], textarea").val("");
      }); */
   }