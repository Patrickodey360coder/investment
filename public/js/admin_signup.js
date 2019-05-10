function process()
{
    if( $("#p1").val()!='')
    {
      $("#key").val(sha512( sha512($("#p1").val())+sha512($("#form_id").val()) ) );
      $("#p1").val('');
       $("#p2").val('');
     document.getElementById("demo-bvd-notempty").submit();
  }
}