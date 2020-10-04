<div class="flex flex-col mt-8">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
            <div x-data="handler()">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">#</th>

                            @foreach($attr["columns"] as $columnName => $columnLabel)
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ $columnLabel }}</th>
                            @endforeach

                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        <template x-for="(field, index) in fields" :key="index">
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap" x-text="index + 1"></td>

                                @foreach($attr["columns"] as $columnName => $columnLabel)
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        @if($attr["types"][$columnName] == "Text")
                                            @include("admin::components.fields.text", ["value" => "", "attr" => [
                                                "type" => "text",
                                                "name" => "{$attr["name"]}[{$columnName}][]",
                                                "required" => false,
                                                "_attr" => "x-model='field.{$columnName}'"
                                            ]])
                                        @elseif($attr["types"][$columnName] == "Select")
                                            @include("admin::components.fields.select", ["value" => "", "attr" => [
                                                "type" => "text",
                                                "name" => "{$attr["name"]}[{$columnName}][]",
                                                "required" => false,
                                                "options" => array_combine($attr["options"][$columnName], $attr["options"][$columnName]),
                                                "_attr" => "x-model='field.{$columnName}'"
                                            ]])
                                        @elseif($attr["types"][$columnName] == "Checkbox")
                                            @include("admin::components.fields.text", ["value" => "1", "attr" => [
                                                "type" => "checkbox",
                                                "name" => "{$attr["name"]}[{$columnName}][]",
                                                "required" => false,
                                                "_attr" => "x-model='field.{$columnName}'",
                                                "class" => "",
                                            ]])
                                        @endif
                                    </td>
                                @endforeach

                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <button @click="removeField(index)" type="button" class="text-indigo-600 hover:text-indigo-900 inline-block">
                                        <svg class="fill-current w-6 h-6 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="{{ count($attr["columns"])+2 }}" class="px-6 py-4 whitespace-no-wrap">
                                <button type="button" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" @click="addNewField()">Добавить</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function handler() {
        return {
            fields: [
                @if($value)
                    @foreach($value as $index => $data)
                    {
                        @foreach($attr["columns"] as $columnName => $columnLabel)
                            @if(isset($data[$columnName]))
                                '{{ $columnName }}': '{{ $data[$columnName] }}',
                            @endif
                        @endforeach
                    },
                    @endforeach
                @endif
            ],
            addNewField() {
                this.fields.push({
                    @foreach($attr["columns"] as $columnName => $columnLabel)
                        '{{ $columnName }}': '',
                    @endforeach
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            }
        }
    }
</script>