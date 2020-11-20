

<!-- Modal -->
<form method="POST" action="{{ action('PaymentController@cancel') }}">
@csrf
<div class="modal fade" id="cancel_payment" tabindex="-1" role="dialog" aria-labelledby="cancel_payment_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancel_payment_label">{{ __('conversation.cancelPaymant') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{{ __('conversation.cancelPaymantConfirmation') }}</p>
        <input type="hidden" name="payment_id" value="{{ $payment->id }}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('conversation.close') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('conversation.confirm') }}</button>
      </div>
    </div>
  </div>
</div>
</form>