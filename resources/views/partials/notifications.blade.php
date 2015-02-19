<div class="alerts">
@if (isset($errors) && count($errors->all()) > 0)
<div class="alert alert-danger styleci-alert">
    <a class="close" data-dismiss="alert">×</a>
    Please check the form below for errors
</div>
@endif

<?php $types = ['success', 'error', 'warning', 'info']; ?>

@foreach ($types as $type)
    @if ($message = Session::get($type))
    <?php if ($type === 'error') $type = 'danger'; ?>
    <div class="alert alert-{{ $type }} styleci-alert">
        <a class="close" data-dismiss="alert">×</a>
        <div class="container">
            @if (is_array($message))
            {!! implode(', ', $message) !!}
            @else
            {!! $message !!}
            @endif
        </div>
    </div>
    @endif
@endforeach
</div>
