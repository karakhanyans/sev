function add_edit_product(self){
    $('#addEditProduct').find('.modal-title').html('Add Product');
    $('#productsForm').attr('action',$(self).attr('data-url'));
    $('#productsForm').attr('method','POST');
    $('#addEditProduct').modal('show');
}

$().ready(function(){
    $('#productsForm').validate({
        rules: {
            name: 'required',
            quantity: {
                required: true,
                number: true
            },
            price: {
                required: true,
                number: true
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: $(form).serialize(),
                success: function(data){
                    $('.products-table tbody').html('');
                    $.each(data,function(key,value){
                        $('.products-table tbody').append('<tr><td>'+value.name+'</td><td>'+value.quantity+'</td><td>'+value.price+'</td><td>'+value.created_at+'</td><td>'+(value.quantity * value.price)+'</td></tr>')
                    })
                    $('#addEditProduct').modal('hide');

                }
            })
        }
    })
})