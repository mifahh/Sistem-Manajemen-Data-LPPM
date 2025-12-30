@props([
'title' => '',
'dataTargetImport' => '',
'dataTargetBaru' => '',
'hrefTemplate' => '',
])

<a href="#" class="btn btn-primary" data-toggle="modal" data-target={{ $dataTargetImport }} style="margin: 10px 0 10px;"><i style="padding-right: 10px;"
        class="fas fa-upload"></i>Import Data {{ $title }}</a>
&nbsp
<a href="#" class="btn btn-warning" data-toggle="modal" data-target={{ $dataTargetBaru }} style="margin: 10px 0 10px; color: white;"><i
        style="padding-right: 5px;" class="fas fa-folder-plus"></i>Buat
    Data {{ $title }} Baru</a>
&nbsp
<a href="{{ $hrefTemplate }}"
    target="_blank" class="btn btn-success" style="margin: 10px 0 10px;"><i style="padding-right: 5px;" class="fas fa-file-excel"></i>Template
    Import Data
    {{ $title }}</a>
