<!-- Modal -->
<div class="modal fade" id="img-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="img-{{$data->id}}-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header" style="height: 4px;">
        <h5 class="modal-title" id="img-{{$data->id}}-label"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="pt-0 modal-body">
  		<img onclick="window.open('{{ asset('storage/'.$data->img_path.'') }}')" class="border" style="width: 100%" src="{{ asset('storage/'.$data->img_path.'') }}">
      </div>
    </div>
  </div>
</div>
