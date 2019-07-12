	function the_quantity(){

	var quantity = document.getElementById("quantity").value;
	var price = {{ $service->price }};
	var acc_bal = {{$balance}};

	var new_price = document.getElementById("price").innerHTML = price*quantity;
	var new_bal= document.getElementById("new_bal").innerHTML = acc_bal-new_price;

		if(new_bal < 0){
			new_bal= document.getElementById("new_bal").innerHTML = "Impossible";
			new_bal= document.getElementById("msj").innerHTML = "Sorry, you don't have enough balance";
			$('button').prop('disabled', true);
		}else{
			new_bal= document.getElementById("msj").innerHTML = "";
			$('button').prop('disabled', false);
		}

	}