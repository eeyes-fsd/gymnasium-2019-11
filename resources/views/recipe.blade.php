<ul>
    @foreach($ingredients as $ingredient)
        <li>{{ App\Models\Ingredient::find($ingredient['id'])->name }} 最少:{{ $ingredient['min'] }}g</li>
    @endforeach
</ul>
