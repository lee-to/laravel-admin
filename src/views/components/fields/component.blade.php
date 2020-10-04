@if($component->type() == "hidden")
    <x-field :resource="$resource" :component="$component" :item="$item"></x-field>
@else
    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-2 sm:px-2">
        <dt class="text-sm leading-5 font-medium text-gray-500">
            @include("admin::components.fields.partials.label", ["field" => $component])
        </dt>

        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
            <x-field :resource="$resource" :component="$component" :item="$item"></x-field>
        </dd>
    </div>
@endif