@foreach($data as $btn)
    <a class="ml-2 bg-blue-500 hover:bg-blue text-white font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded" href="{{ $btn["href"] }}">{{ $btn["title"] }}</a>
@endforeach