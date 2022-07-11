$(document).ready(function(){
    $('#add_items').click(function(e){
        e.preventDefault();
        let numItems = $('.extra-item').length;
        let item = '<div class="row m-0 p-0 item_' + numItems + '">';
        item += '<div class="col-xs-12 col-sm-6 col-md-6"><div class="form-group pb-2">';
        item += '<input type="text" name="description_' + numItems + '" class="form-control extra-item" placeholder="Item description" maxlength="100" required /></div></div>';
        item += '<div class="col-xs-12 col-sm-3 col-md-4"><div class="form-group pb-2">';
        item += '<input type="number" name="amount_' + numItems + '" class="form-control" placeholder="Amount" maxlength="10" required /></div></div>';
        item += '<div class="col-xs-12 col-sm-1 col-md-1"><div class="form-check form-switch pt-2">';
        item += '<input type="checkbox" name="is_taxed_' + numItems + '" id="is_taxed_' + numItems + '" class="form-check-input" checked />';
        item += '<label class="form-check-label" for="is_taxed_' + numItems + '">Taxed</label></div></div>';
        item += '<div class="col-xs-12 col-sm-2 col-md-1"><div class="form-group">';
        item += '<button onClick="removeItem(\'.item_' + numItems + '\')" class="btn btn-danger" title="Remove Item"> x </button></div></div></div>';
        $('#more_items').append(item);
    });
    if ($("#pdf-previewer").length > 0) {
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w. ]+$/i.test(value);
        },
        "Please enter only letters, numbers, and spaces!");
        $.validator.addMethod("alphachars", function(value, element) {
            return this.optional(element) || /^[\w ,.:()]+$/i.test(value);
        },
        "Allowed characters are , . : ( )");
        $("#pdf-previewer").validate({
            rules: {
                billing_name: {
                    required: true,
                    alphanumeric: true
                },
                company_name: {
                    required: true,
                    alphachars: true
                },
                street_address: {
                    required: true,
                    alphachars: true
                },
                city: {
                    required: true,
                    alphanumeric: true
                },
                area_code: {
                    required: true,
                },
                phone_number: {
                    required: true,
                },
                description: {
                    required: true,
                    alphachars: true
                },
                amount: {
                    required: true,
                }
            },
            messages: {
                billing_name: {
                    required: "Please enter the billing name!",
                },
                company_name: {
                    required: "Please enter the company name!",
                },
                street_address: {
                    required: "Please enter the street address!",
                },
                city: {
                    required: "Please enter the city!",
                },
                area_code: {
                    required: "Please enter the area code!",
                },
                phone_number: {
                    required: "Please enter the telephone number!",
                },
                description: {
                    required: "Please enter the item description!",
                },
                amount: {
                    required: "Please enter the item amount!",
                }
            },
            success: function(){
                $('#preview').click(function(e){
                    e.preventDefault();
                    $(this).remove();
                    $('#previewing').removeClass('invisible');
                    $('#pdf-previewer').submit();
                });                    
            }
        });
    };
    setTimeout(function(){
        $('table').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true
        });
    }, 500);
});
function removeItem(name){
    $(name).remove();
};
