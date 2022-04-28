<div class="flex flex-col mt-8">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
            <div x-data="handler_{{ $component->originalName() }}()" x-init="handler_init_{{ $component->originalName() }}">
                <table data-relation="{{ $component->relation() }}" class="min-w-full {{ $attr["subItem"] ? 'sub_items' : 'parent_items' }}">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">#</th>

                        @foreach($attr["fields"] as $field)
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ $field->label() }}</th>
                        @endforeach

                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                    </thead>

                    <tbody class="bg-white">
                    <template
                            x-if="items"
                            @if($component->subItem)
                            x-for="(sub_item, sub_index) in items" :key="sub_index"
                            @else
                            x-for="(item, index) in items" :key="index"
                            @endif
                    >
                        <tr :data-id="{{ $component->subItem ? 'sub_item' : 'item' }}.id" class="has_many_extend_{{ $component->relation() }}">
                            <td class="px-6 py-4 whitespace-no-wrap" x-text="{{ $component->subItem ? 'sub_index' : 'index' }} + 1"></td>

                            @foreach($attr["fields"] as $field)
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $resource->component($field, "fields", $emptyValue, true) }}
                                </td>
                            @endforeach

                            <td class="px-6 py-4 whitespace-no-wrap">
                                <input type="hidden" x-model="{{ $component->subItem ? 'sub_item' : 'item' }}.id" />

                                <button @click="removeField({{ $component->subItem ? 'sub_index' : 'index' }})" type="button" class="text-indigo-600 hover:text-indigo-900 inline-block">
                                    @include("admin::partials.icons.delete", ["size" => 6, "color" => "red", "class" => "mr-2"])
                                </button>
                            </td>
                        </tr>
                    </template>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td colspan="{{ count($attr["fields"])+2 }}" class="px-6 py-4 whitespace-no-wrap">
                            <button type="button"
                                    class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                                    @click="addNewField()">
                                Добавить
                            </button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
  function handler_{{ $component->originalName() }}() {
    return {
      handler_init_{{ $component->originalName() }} () {
        this.items = @json($component->jsonValues($resource));

          @if($component->parentRelation())
        var parentId = this.$el.closest(".has_many_extend_{{ $component->parentRelation() }}").dataset.id;
        this.items = this.items[parentId];
          @endif
      },
      items: [],
      addNewField() {
        if(Array.isArray(this.items)) {
          this.items.push(@json($component->jsonValues()));
        } else {
          this.items = [@json($component->jsonValues())];
        }
      },
      removeField(index) {
        this.items.splice(index, 1);
      },
    }
  }
</script>