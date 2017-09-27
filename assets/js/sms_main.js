$(function() {
    $('#envoi').on('click', function(){
        var message_text = $('#message-text').val();
        if(message_text !== ''){
            $(".row:last").after('<div class="row"><div class="message message-out pull-right">'+message_text+'</div></div>');
            $('#message-text').val('');
        }
    });
    
    $(document).ready(function(){
        //put yer code in here
       

    });

    
    
});