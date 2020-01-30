<ul>
    @foreach($variables as $key => $variable)
        <li>{{ $key }} : {{ $variable }}</li>
    @endforeach
</ul>
