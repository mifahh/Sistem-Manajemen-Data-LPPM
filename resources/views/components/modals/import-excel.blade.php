@props([
    'modalId' => 'importExcel',
    'title' => 'Import Data Excel',
    'action' => '',
    'templateUrl' => '#',
    'templateText' => 'Download Template Excel',
    'submitText' => 'Import',
    'cancelText' => 'Batal'
])

<div class="modal fade" id="{{ $modalId }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action={{ $action }} method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if($templateUrl !== '#')
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        Silahkan download template excel terlebih dahulu, isi data sesuai format, lalu upload kembali.
                    </div>
                    <div class="form-group">
                        <a href="{{ $templateUrl }}" class="btn btn-success btn-block" target="_blank">
                            <i class="fas fa-download"></i> {{ $templateText }}
                        </a>
                    </div>
                    <hr>
                    @endif
                    
                    <div class="form-group">
                        <label for="file">Pilih File Excel <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" 
                                   class="custom-file-input" 
                                   id="file" 
                                   name="file" 
                                   accept=".xlsx,.xls,.csv"
                                   required>
                            <label class="custom-file-label" for="file">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Format yang didukung: .xlsx, .xls, .csv
                        </small>
                    </div>

                    {{ $slot }}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> {{ $cancelText }}
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> {{ $submitText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Update custom file input label with filename
$('#{{ $modalId }} .custom-file-input').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
});
</script>
@endpush
