<form method='POST' action='{{ action('OfferController@accept') }}'>
  @csrf
<div class='modal fade' id='result.id' tabindex='-1' role='dialog' aria-labelledby='result.id_label' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='result.id_label'>{{ __('conversation.acceptModel') }}</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
        @PHP ($p_method = "+result.pm_slug+")
        @if($balance->$p_method >= result.price)
          @PHP ($button = 'enabled')
          result.price result.currency result.p_method
          {{ __('conversation.cuttedBalance') }}
        @else
          @PHP ($button = 'disabled')
          Sorry You don't have this amount. <br>
          You have <a class='text-danger'>$balance->$p_method result.currency result.p_method </a>
        @endif
      </div>
      <div class='modal-footer'>
        <input type='hidden' name='offer_id' value='result.id'>
        <button type='submit' class='btn btn-secondary' data-dismiss='modal'>{{ __('conversation.close') }}</button>
        <button type='submit' class='btn btn-primary' {{$button}}>{{ __('conversation.confirm') }}</button>
      </div>
    </div>
  </div>
</div>
</form>