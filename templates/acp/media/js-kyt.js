
/* =============== Buttons */
$("button, input:button").addClass("btn btn-default");
$("#submit").addClass("btn btn-primary");
/* End Buttons =============== */



/* =============== Form Inputs */
$("form").attr("role","form");
$("input").addClass("form-control").css("width","30%").css("display","inline");
$(":checkbox").removeClass("form-control").css("width","").css("display","inline");;
$(":radio").removeClass("form-control").css("width","").css("display","inline");;
$("select").addClass("form-control").css("width","30%").css("display","inline");
$("textarea").addClass("form-control").css("width","70%");
/* End Form Inputs =============== */



/* =============== Tables */
$("table").addClass("table table-hover table-condensed");
$("table td").css("vertical-align","middle");
/* End Tables =============== */

