$(document).ready(function(){$("form").submit(function(){var a=$(this).attr("id"),b=$("#"+a);return $.ajax({type:"POST",url:"modalform/mail.php",data:b.serialize(),success:function(a){$(".msgs").html(a),$(".formTitle").css("display","none"),$(b).css("display","none"),setTimeout(function(){$(b).css("display","block"),$(".formTitle").css("display","block"),$(".msgs").html(""),$("input").not(":input[type=submit], :input[type=hidden]").val("")},3e3)},error:function(a,c,d){$(".msgs").html(d),$(".formTitle").css("display","none"),$(b).css("display","none"),setTimeout(function(){$(b).css("display","block"),$(".formTitle").css("display","block"),$(".msgs").html(""),$("input").not(":input[type=submit], :input[type=hidden]").val("")},3e3)}}),!1});var a=$(".form-fieldset > input");a.blur(function(){$(this).toggleClass("filled",!!$(this).val())})});