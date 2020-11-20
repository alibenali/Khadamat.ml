<!-- Pending Modal -->
<form method="POST" action="{{ action('Voyager\WithdrawController@pending') }}">
  @csrf
<div class="modal fade" id="pending-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="pending_{{ $data->id }}_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pending_{{ $data->id }}_label">Pending Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="Amount">Amount</label>
          <input type="number" class="form-control" id="Amount" name="amount" value="{{ $data->amount }}">
          <input type="hidden" name="id" value="{{ $data->id }}">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- Accept Modal -->
<form method="POST" action="{{ action('Voyager\WithdrawController@accept') }}">
  @csrf
<div class="modal fade" id="accept-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="accept_{{ $data->id }}_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accept_{{ $data->id }}_label">Accept Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="Amount">Amount</label>
          <input type="number" class="form-control" id="Amount" name="amount" value="{{ $data->amount }}">
          <input type="hidden" name="id" value="{{ $data->id }}">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>
</form>



<!-- Refuse Modal -->
<form method="POST" action="{{ action('Voyager\WithdrawController@refuse') }}">
  @csrf
<div class="modal fade" id="refuse-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="refuse_{{ $data->id }}_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="refuse_{{ $data->id }}_label">Refuse Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <input type="hidden" name="id" value="{{ $data->id }}">
        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>
</form>