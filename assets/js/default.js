(function(){
	let form = document.getElementById("risk");
	let vessel = form.elements.vessel;
	let country = form.elements.country;
	let species = form.elements.species;
	let company = form.elements.company;

	$(form).submit((evt)=>{

		vessel.disabled = true;
		country.disabled = true;
		species.disabled = true;
		company.disabled = true;

		$.get("blacklisted_async.php", {
			"search" : vessel.value
		}, (returnData) => {
			if(returnData == "blacklisted") {
				alert("BlackListed");
				return;
			}

			if(returnData == "okay") {	
				vessel.disabled = false;
				country.disabled = false;
				species.disabled = false;
				company.disabled = false;
			}
		});
	});

	// $(vessel).keyup((evt)=>{
	// 	console.log(evt.target.value);
	// });

	$(country).autocomplete({
	    serviceUrl: 'risk_analysis.php',,
	    lookup: { "country": country.value }
	    onSelect: function (suggestion) {
	        country.value = suggestion.name;
	    }
	});


	$(species).autocomplete({
	    serviceUrl: 'risk_analysis.php',,
	    lookup: { "species": species.value }
	    onSelect: function (suggestion) {
	        species.value = suggestion.name;
	    }
	});


	$(company).autocomplete({
	    serviceUrl: 'risk_analysis.php',,
	    lookup: { "company": company.value }
	    onSelect: function (suggestion) {
	        company.value = suggestion.name;
	    }
	});
	
	// $(country).keyup((evt)=>{
	// 	$.get(
	// 		"risk_analysis.php", 
	// 		{"country": evt.target.value},
	// 		(returnData) => {
	// 			console.log(returnData);
	// 		}
	// 	);
	// });

	// $(species).keyup((evt)=>{
	// 	$.get(
	// 		"risk_analysis.php", 
	// 		{"species": evt.target.value},
	// 		(returnData) => {
	// 			console.log(returnData);
	// 		}
	// 	);
	// });

	// $(company).keyup((evt)=>{
	// 	$.get(
	// 		"risk_analysis.php", 
	// 		{"company": evt.target.value},
	// 		(returnData) => {
	// 			console.log(returnData);
	// 		}
	// 	);
	// });
})();