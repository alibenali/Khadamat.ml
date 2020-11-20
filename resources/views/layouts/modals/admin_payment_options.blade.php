
<!-- Pending Modal -->
<form method="POST" action="{{ action('Voyager\PaymentController@pending') }}">
@csrf
  <div class="modal fade" id="pending_modal" tabindex="-1" role="dialog" aria-labelledby="pending_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="accept_modal_label">Pending modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Please confirm that you want to make the service in progress.
        </div>
        <div class="modal-footer">
          <input type="hidden" name="payment_id" value="{{ $payment->id }}">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Accept Modal -->
<form method="POST" action="{{ action('Voyager\PaymentController@accept') }}">
@csrf
  <div class="modal fade" id="accept_modal" tabindex="-1" role="dialog" aria-labelledby="accept_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="accept_modal_label">Accept modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Please confirm that you want to accept this payment.
        </div>
        <div class="modal-footer">
          <input type="hidden" name="payment_id" value="{{ $payment->id }}">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</form>



<!-- Refuse Modal -->
<form method="POST" action="{{ action('Voyager\PaymentController@refuse') }}">
@csrf
  <div class="modal fade" id="refuse_modal" tabindex="-1" role="dialog" aria-labelledby="refuse_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="refuse_modal_label">Refuse modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Please confirm that you want to refuse this payment.
          <br>

          <textarea name="raison" class="form-control" id="raison" placeholder="Why you refuse it ?" required></textarea>

        </div>
        <div class="modal-footer">
          <input type="hidden" name="payment_id" value="{{ $payment->id }}">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</form>



<!-- Refund Modal -->
<form method="POST" action="{{ action('Voyager\PaymentController@refund') }}">
@csrf
  <div class="modal fade" id="refund_modal" tabindex="-1" role="dialog" aria-labelledby="refund_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="accept_modal_label">Refund modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Please confirm that you want to refund payment.
        </div>
        <div class="modal-footer">
          <input type="hidden" name="payment_id" value="{{ $payment->id }}">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</form>