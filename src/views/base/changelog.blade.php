@if($item->adminChangeLogs)
    <div class="my-6 text-lg">Последнии 5 изменений</div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Пользователь
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Изменения
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Дата
                        </th>
                    </tr>
                    </thead>

                    <tbody class="bg-white">
                    @foreach($item->adminChangeLogs->take(5) as $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $log->adminUser->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Поле
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            До
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            После
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($log->states_after as $changedField => $changedValue)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                {{ $resource->getField($changedField) ? $resource->label($resource->getField($changedField)) : $changedField }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                {{ $log->states_before[$changedField] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                {{ $changedValue }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif