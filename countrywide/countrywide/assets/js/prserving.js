wow = new WOW(  
{  
    boxClass:     'wow',                        // default  
    animateClass: 'animated',         // default  
    offset:       0,                                // default  
    mobile:       true,                       // default  
    live:         true                           // default  
} )  
wow.init();  
 

// function openNav() {
//     document.getElementById("mySidenav").style.width = "400px";
// }
// function closeNav() {
//     document.getElementById("mySidenav").style.width = "0";
// }

$(function() {
    $("#coupon_question").on("click",function() {
        $(".answer").toggle(this.checked);
    });
});

$(document).ready(function(){
            
    // Initialize select2
    $("#selUser").select2();

    // Read selected option
    $('#but_read').click(function(){
        var username = $('#selUser option:selected').text();
        var userid = $('#selUser').val();
   
        $('#result').html("id : " + userid + ", name : " + username);
    });
});

$(document).ready(function(){
    
    // Initialize select2
    $("#selCounty").select2();

    // Read selected option
    $('#but_read').click(function(){
        var username = $('#selCounty option:selected').text();
        var userid = $('#selCounty').val();
   
        $('#result').html("id : " + userid + ", name : " + username);
    });
});

$(document).ready(function(){
    
    // Initialize select2
    $("#selCourt").select2();

    // Read selected option
    $('#but_read').click(function(){
        var username = $('#selCourt option:selected').text();
        var userid = $('#selCourt').val();
   
        $('#result').html("id : " + userid + ", name : " + username);
    });
});

$(document).ready(function(){
    
    // Initialize select2
    $("#selAgent").select2();

    // Read selected option
    $('#but_read').click(function(){
        var username = $('#selAgent option:selected').text();
        var userid = $('#selAgent').val();
   
        $('#result').html("id : " + userid + ", name : " + username);
    });
});

$(document).ready(function(){
    
    // Initialize select2
    $("#selAccount").select2();

    // Read selected option
    $('#but_read').click(function(){
        var username = $('#selAccount option:selected').text();
        var userid = $('#selAccount').val();
   
        $('#result').html("id : " + userid + ", name : " + username);
    });
});

function showHide(elem) {
    if(elem.selectedIndex !== 0) {
         //hide the divs
         for(var i=0; i < divsO.length; i++) {
             divsO[i].style.display = 'none';
        }
        //unhide the selected div
        document.getElementById(elem.value).style.display = 'block';
    }
}
 
window.onload=function() {
    //get the divs to show/hide
    divsO = document.getElementById("hockey","cash").getElementsByClassName('show-hide');
};

var totalSteps = $(".steps li").length;
$(".submit").on("click", function(){
return false;
});

$(".steps li:nth-of-type(1)").addClass("active");
$(".myContainer .form-container:nth-of-type(1)").addClass("active");

$(".form-container").on("click", ".next", function() {
    $(".steps li").eq($(this).parents(".form-container").index() + 1).addClass("active");
    $(this).parents(".form-container").removeClass("active").next().addClass("active flipInX");
});

$(".form-container").on("click", ".back", function() {
    $(".steps li").eq($(this).parents(".form-container").index() - totalSteps).removeClass("active");
    $(this).parents(".form-container").removeClass("active flipInX").prev().addClass("active flipInY");
});

/*=========================================================
*     If you won't to make steps clickable, Please comment below code
=================================================================*/
$(".steps li").on("click", function() {
    var stepVal = $(this).find("span").text();
    $(this).prevAll().addClass("active");
    $(this).addClass("active");
    $(this).nextAll().removeClass("active");
    $(".myContainer .form-container").removeClass("active flipInX");
    $(".myContainer .form-container:nth-of-type("+ stepVal +")").addClass("active flipInX");
});