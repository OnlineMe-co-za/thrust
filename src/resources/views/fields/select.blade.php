@component('thrust::components.formField', ["field" => $field, "title" => $title, "description" => $description ?? null, "inline" => $inline])
    <select id="{{$field}}" name="{{$field}}" @if($searchable) class="searchable" @endif {{$attributes ?? ""}}>
        @foreach($options as $key => $optionValue)
            <option @if((! $key && $key === 0) || $key == $value) selected @endif value="{{$key}}">{{$optionValue}}</option>
        @endforeach
    </select>
    @if(isset($inlineCreation) && $inlineCreation)
       @include('thrust::fields.inlineCreation')
    @endif
@endcomponent