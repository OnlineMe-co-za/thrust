<table class="list striped">
    <thead>
    @if (! $belongsToManyField->hideName)
        @if ($sortable)
            <th></th>
        @endif
        <th>
            {{ trans_choice(config('thrust.translationsPrefix') . Illuminate\Support\Str::singular($belongsToManyField->field), 1) }}
        </th>
    @endif
    @foreach($belongsToManyField->objectFields as $field)
        <th> {{$field->getTitle()}}</th>
    @endforeach
    @foreach($belongsToManyField->pivotFields as $field)
        @if(!$field->shouldHide($object, 'edit'))
            <th> {{$field->getTitle()}}</th>
        @endif
    @endforeach
    <th></th>
    @if ($belongsToManyField->canEdit())
        <th></th>
    @endif
    </thead>
    <tbody class="@if ($sortable) sortableChild @endif">
    @foreach ($children as $row)
        <tr id="sort_{{$row->pivot->id}}">
            @if ($sortable)
                <td class="sort action hide-mobile"></td>
            @endif
            @if (! $belongsToManyField->hideName)
                <td>
                    {{ $row->{$relationshipDisplayName} }}
                </td>
            @endif
            @foreach($belongsToManyField->objectFields as $field)
                <td>{!! $field->displayInIndex($row)  !!}</td>
            @endforeach
            @foreach($belongsToManyField->pivotFields as $field)
                @if(!$field->shouldHide($object, 'edit'))
                    <td>{!! $field->displayInIndex($row->pivot)  !!}</td>
                @endif
            @endforeach
            @if (app(BadChoice\Thrust\ResourceGate::class)->can($pivotResourceName, 'delete', $row->pivot))
                <td class="action"> <a class="delete-resource" data-delete="confirm resource" href="{{route('thrust.belongsToMany.delete', [$resourceName, $object->id, $belongsToManyField->field, $row->pivot->id])}}"></a></td>
            @endif
            @if (app(BadChoice\Thrust\ResourceGate::class)->can($pivotResourceName, 'edit', $row->pivot) && $belongsToManyField->canEdit())
                <td class="action"> <a class='edit thrust-edit' id="edit_{{$row->pivot->id}}"></a></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
@include('thrust::components.paginator', ["data" => $children, 'popupLinks' => true])
