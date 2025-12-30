@props([
    'modalId' => 'modal-delete',
    'title' => 'Apakah Anda Yakin?',
    'message' => 'Apakah Anda yakin untuk menghapus data ini?',
    'action' => '',
    'confirmText' => 'Ya, Hapus',
    'cancelText' => 'Batal'
])

<div class="modal fade" id="{{ $modalId }}">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ $message }}</p>
                {{ $slot }}
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> {{ $cancelText }}
                </button>
                <a href="{{ $action }}" class="btn btn-danger">
                    <i class="fas fa-trash"></i> {{ $confirmText }}
                </a>
            </div>
        </div>
    </div>
</div>
