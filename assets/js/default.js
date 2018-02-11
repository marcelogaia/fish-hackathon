(function(){
	$("form").submit((evt)=>{
		let vessel = evt.target.elements.vessel;
		let country = evt.target.elements.country;
		let species = evt.target.elements.species;
		let company = evt.target.elements.company;

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
})();