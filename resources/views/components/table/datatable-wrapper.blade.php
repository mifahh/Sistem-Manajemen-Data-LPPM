@props([
    'tableId' => 'dataTable',
    'theadClass' => 'thead-light'
])

<div class="table-responsive">
    <table id="{{ $tableId }}" class="table table-bordered cell-border hover" cellspacing="0" width="100%">
        <thead class="{{ $theadClass }}">
            {{ $thead }}
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
