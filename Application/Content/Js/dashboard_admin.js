$(document).ready(function(){
    CreateAjaxLink();
});


function CreateAjaxLink()
{
    $('.ajax-link').on('click', function(event){
        event.preventDefault();

        var form = $(this).closest('form.ajax-form');
        var requestTarget = form.attr('link-target');

        $.post(
            requestTarget,
            form.serialize(),
            function(data){
                alert(JSON.stringify(data));
            }
        )
    });
}

//function ConfirmDelete