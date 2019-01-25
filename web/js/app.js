$(document).ready(function () {
    $('#verify_otp').click(function(e){
     
        var data = {
            name: $("#name").val(),
            email:  $("#email").val(),
            otp: $('#otp').val()
        };
        
        console.log(JSON.stringify(data));
        $.ajax({
            type:'POST',
            url:'/api/verifyotp',
            dataType:'json',
            contentType: "application/json",
            data: data,
            success:function(results){
                // this is where i get the latlng
            }
        });
       
    });
});