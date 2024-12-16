$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').artt('content')

    }
});
function  removeRow(id ,url)
{
    if(confirm('xoa ma khong the khoi phuc ban co chac ?')){
        $.ajax({
            type: 'DELETE',
            datatype : 'JSON',
            data :{id},
            url:url,
            success:function(result){
                console.log(result);
            }
        })
    }
}