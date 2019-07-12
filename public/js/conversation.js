


$(document).ready(function(){

    // js of toolip over
    $("div").tooltip();

    // chat scroll down 
    var objDiv = document.getElementById("mydiv");
    objDiv.scrollTop = objDiv.scrollHeight;


});


    // form submit on click
$(document).ready(function() {
$('#textarea').keydown(function() {
var message = $("textarea").val();
if (event.keyCode == 13) {
if (message == "") {
alert("Enter Some in input field, ok !!");
} else {

    var _token = $('input[name="_token"]').val();
    var conversation_id = {{ $conversation->id }};


$.ajax({
    url:"{{ route('message.create') }}",
    method:"POST",
    data:{_token:_token, conversation_id:conversation_id, message:message},
    success:function(result)
    {
    }

   })

}
$("textarea").val('');
return false;
}
});
});