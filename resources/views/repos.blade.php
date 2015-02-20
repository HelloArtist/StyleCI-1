@extends(Config::get('core.default'))

@section('title', 'Repositories')

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>Analysed Repos</h1>
        <p>Here you can see all your analysed repos.</p>
    </div>
</div>
@stop

@section('content')
@forelse($repos as $repo)
<div class="row">
    <div class="col-sm-8">
    <h3>{{ $repo->name }}</h3>
        @if ($commit = $commits->get($repo->id))
        <p class="js-status" style="@if ($commit->status === 1) color:green; @elseif ($commit->status === 2 || $commit->status === 3) color:red; @else color:grey; @endif">
            <strong>{{ $commit->summary }}</strong>
        </p>
        @else
        <p class="js-status">
            <strong>No commits have been pushed to the master yet.</strong>
        </p>
        @endif
    </div>
    <div class="col-sm-4 list-vcenter">
        <a class="btn btn-primary" href="{{ route('repo_path', $repo->id) }}"><i class="fa fa-history"></i> Show Commits</a>
    </div>
</div>
<hr>
@empty
<p class="lead">We haven't analysed anything yet.</p>
<p>You can enable repos on your <a href="{{ route('account_path') }}">account page</a>.</p>
@endforelse
@stop
