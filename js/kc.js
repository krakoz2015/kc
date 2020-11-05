
function refresh(page){
	console.log(page);
	$.ajax({
		type:"GET",
		url:"api/rest/users",
		data:{page:page},
		dataType: 'json',
		success:function(data){
			$("body").html(data.html);
		}
	})	
} 

function login(){
	$(".message").html("");
	$.ajax({
		type:"POST",
		url:"api/rest/login",
		data:$("form.sign-in-htm").serialize(),
		dataType: 'json',
		success:function(data){
			if (!data.status){
				$(".message").html(data.message);
				return;
			}else{
				refresh(1);						
			}
		}
	});
}

 $(document).ready(function(){
	refresh(1);
	$( document ).on("click", "ul.pager>li>a", function(){
		refresh($(this).attr("data-n"))
		return false;
	});
	$( document ).on("click", "#logout", function(){
		$.ajax({
			type:"DELETE",
			url:"api/rest/auth",
			success:function(data){
				location.reload();
			}
		});
		return false;
	});
	$( document ).on("click", "#login", function(){
		login();
		return false;
	});
	$( document ).on("submit", "form", function(){
		login();
		return false;
	});
	$( document ).on("click", "#signup", function(){
		$(".message").html("");
		$.ajax({
			type:"POST",
			url:"api/rest/signup",
			data:$("form.sign-in-htm").serialize(),
			dataType: 'json',
			success:function(data){
				if (!data.status){
					$(".message").html(data.message);
					return;
				}
			}
		})
		return false;
	})
})
