@if($results->isEmpty())
    <p>Không tìm thấy kết quả nào.</p>
@else
    <ul class="list-group">
        @foreach($results as $result)
            <li class="list-group-item">
                {{ $result->name }} - {{ $result->price }}
            </li>
        @endforeach
    </ul>
@endif
