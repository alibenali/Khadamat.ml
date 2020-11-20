<!-- Accept Modal -->
<form method="POST" action="{{ action('OfferController@accept') }}">
  @csrf
<div class="modal fade" id="{{ $offer[($message->content - 1)]->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $offer[($message->content - 1)]->id }}_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{{ $offer[($message->content - 1)]->id }}_label">{{ __('conversation.acceptModel') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @PHP ($p_method = $offer[($message->content - 1)]->pm_slug)
        @if($balance->$p_method >= $offer[($message->content - 1)]->price)
          @PHP ($button = "enabled")
          {{$offer[($message->content - 1)]->price}} {{$offer[($message->content - 1)]->currency}} {{$offer[($message->content - 1)]->p_method}} 
          {{ __('conversation.cuttedBalance') }}
        @else
          @PHP ($button = "disabled")
          Sorry You don't have this amount. <br>
          You have <a class="text-danger">{{$balance->$p_method}} {{$offer[($message->content - 1)]->currency}}  {{$offer[($message->content - 1)]->p_method}} </a>
        @endif
      </div>
      <div class="modal-footer">
        <input type="hidden" name="offer_id" value="{{ $offer[($message->content - 1)]->id }}">
        <button type="submit" class="btn btn-secondary" data-dismiss="modal">{{ __('conversation.close') }}</button>
        <button type="submit" class="btn btn-primary" {{$button}}>{{ __('conversation.confirm') }}</button>
      </div>
    </div>
  </div>
</div>
</form>