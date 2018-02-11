(function(){
	let form = document.getElementById("risk");
	let vessel = form.elements.vessel;
	let country = form.elements.country;
	let species = form.elements.species;
	let company = form.elements.company;

	$(form).submit((evt)=>{

		vessel.disabled = true;
		c.disabled = true;
		species.disabled = true;
		company.disabled = true;

		$.get("blacklisted_async.php", {
			"search" : vessel.value
		}, (returnData) => {
			if(returnData == "blacklisted") {
				alert("Blacklisted");
				return;
			}

			$.get("risk_analysis.php", 
				{"country" : country.value},
				(returnData) => {
					let theClass = "";
					if(returnData > 75) theClass = "good";
					else if(returnData > 40 ) theClass = "medium";
					else theClass = "bad";
				}
			);

			if(returnData == "okay") {	
				vessel.disabled = false;
				country.disabled = false;
				species.disabled = false;
				company.disabled = false;
			}
		});
	});


	// AUTOCOMPLETE CANCELLED DUE TO... yeah

	// $(country).autocomplete({
	//     serviceUrl: 'risk_analysis.php',
	//     lookup: { "query": country.value, "type" : "country" },
	//     onSelect: function (suggestion) {
	//         country.value = suggestion.name;
	//     }
	// });


	// $(species).autocomplete({
	//     serviceUrl: 'risk_analysis.php',
	//     lookup: { "query": species.value, "type" : "species" },
	//     onSelect: function (suggestion) {
	//         species.value = suggestion.name;
	//     }
	// });


	// $(company).autocomplete({
	//     serviceUrl: 'risk_analysis.php',
	//     lookup: { "query": company.value, "type" : "company" },
	//     onSelect: function (suggestion) {
	//         company.value = suggestion.name;
	//     }
	// });

})();