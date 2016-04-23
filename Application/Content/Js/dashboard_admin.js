$(document).ready(function(){
    CreateSeeAlsoLinks();
    DeleteSeeAlsoLinks();
});


function CreateSeeAlsoLinks()
{
    $('.see-also-link').on('click', function(event){
        event.preventDefault();

        var form = $(this).closest('form.ajax-form');
        var requestTarget = form.attr('link-target');
        $.post(
            requestTarget,
            form.serialize(),
            function(data){

                var tableRow = $('<tr></tr>');
                var tableColumns = Array();
                for(var i = 0; i < 4; i ++){
                    tableColumns[i] = $('<td></td>');
                }

                tableColumns[0].html(data.Id);
                tableColumns[1].html(data.DisplayName);
                tableColumns[2].html(data.Link);
                var buttonElement = $('<button type="button" class="delete-see-also-link btn btn-md btn-default"> \
                    <span class="glyphicon glyphicon-trash"</span> \
                    </button>\
                ');
                DeleteSeeAlsoLinks(buttonElement);

                tableColumns[3].append(buttonElement);


                for(i = 0; i < 4; i ++){
                    tableRow.append(tableColumns[i]);
                }

                var tableBody = $('tbody.see-also-links-body');
                tableBody.append(tableRow);


                $('#seealsolinkdialog').modal('toggle');
            }
        )
    });
}

function DeleteSeeAlsoLinks(element)
{
    if(element == undefined){
        element = $('.delete-see-also-link')
    }

    element.on('click', function(event) {
        event.preventDefault();

        var buttonElement = $(this);
        if(confirm('Are you sure?')) {
            var requestTarget = $(this).attr('link-target');

            $.post(requestTarget, function(data){
                buttonElement.closest('tr').remove();
            });
        }
    })
}