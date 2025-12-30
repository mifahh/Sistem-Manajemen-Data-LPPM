@props([
    'modalId' => 'modal-edit',
    'title' => 'Edit Data',
    'action' => '',
    'size' => 'lg',
    'submitText' => 'Update',
    'cancelText' => 'Batal'
])

<div class="modal fade" id="{{ $modalId }}">
    <div class="modal-dialog modal-{{ $size }}">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" autocomplete="on">
                @csrf
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> {{ $cancelText }}
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-edit"></i> {{ $submitText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
