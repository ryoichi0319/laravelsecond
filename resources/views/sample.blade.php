@component('components.modal1')
    @slot('modal_id', 'sample_modal')
    @slot('modal_title', 'sampleです')
    @slot('modal_body', '本文です。')
@endcomponent


{{-- <div class="modal" tabindex="-1" role="dialog" id="sample_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">sampleです</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>本文です。</p>
          <p>slotの外に書かれた内容です。</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary">保存</button>
        </div>
      </div>
    </div>
  </div> --}}
  
  