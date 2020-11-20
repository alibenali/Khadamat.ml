<!-- Create offer Modal -->
<form method="POST" action="{{ action('OfferController@store') }}">
  @csrf
<div class="modal fade text-dark" id="offer" tabindex="-1" role="dialog" aria-labelledby="offer_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="offer_label">Create offer Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="mt-2" for="title">Offer Title</label>
          <input type="text" class="form-control" id="title" name="title">

          <label class="mt-2" for="details">Details</label>
          <textarea class="form-control" id="details" name="details"></textarea>

          <label for="p_method">Payment Method</label>
          <select class="form-control dynamic" id="p_method" name="p_method" data-dependent="currency" required>
              <option>Select Payment Method</option>
            @foreach( $payment_methods as $payment_method)
              <option value="{{ $payment_method->name }}">{{ $payment_method->name }}</option>
            @endforeach
          </select>

          <label for="currency">Currency</label>
          <select class="form-control" id="currency" name="currency" required>
            <option>Select Currency</option>
            @foreach( $currencies as $currency)
              <option value="{{ $currency->name }}">{{ $currency->name }}</option>
            @endforeach
          </select>

          <label class="mt-2" for="price">Price</label>
          <input type="number" class="form-control" id="price" name="price">

          <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create offer</button>
      </div>
    </div>
  </div>
</div>
</form>



<script>
$(document).ready(function(){

 $('.dynamic').change(function(){
  if($(this).val() != '')
  {
   var select = $(this).attr("id");
   var value = $(this).val();
   var dependent = $(this).data('dependent');
   var _token = $('input[name="_token"]').val();
   $.ajax({
    url:"{{ route('deposit.fetch') }}",
    method:"POST",
    data:{select:select, value:value, _token:_token, dependent:dependent},
    success:function(result)
    {
     $('#'+dependent).html(result);
    }

   })

   var pic = pic;
   
  if (typeof(pic) != 'undefined' && pic != null){
   if(value == 'ccp'){
    pic.style.visibility='initial';
    pic.style.height='60px';
    pic.style.opacity='3';
  }else{
    pic.style.opacity='0';
    pic.style.height='0px';
    pic.style.visibility='hidden';

  }
}


  }
 });

 $('#p_method').change(function(){
  $('#currency').val('');
 });



});
</script>