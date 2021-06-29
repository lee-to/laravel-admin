<style>
    input[type=range]::-webkit-slider-thumb {
        pointer-events: all;
        width: 24px;
        height: 24px;
        -webkit-appearance: none;
        /* @apply w-6 h-6 appearance-none pointer-events-auto; */
    }
</style>

<div class="">
    <div x-data="range_{{ $attr["originalName"] }}()" x-init="mintrigger(); maxtrigger()" class="relative max-w-xl w-full">
        <div>
            <input type="range"
                   step="{{ $attr["step"] }}"
                   x-bind:min="min" x-bind:max="max"
                   x-on:input="mintrigger"
                   x-model="minValue"
                   class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

            <input type="range"
                   step="{{ $attr["step"] }}"
                   x-bind:min="min" x-bind:max="max"
                   x-on:input="maxtrigger"
                   x-model="maxValue"
                   class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

            <div class="relative z-10 h-2">
                <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>
                <div class="absolute z-20 top-0 bottom-0 rounded-md bg-blue-300" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>
                <div class="absolute z-30 w-6 h-6 top-0 left-0 bg-blue-300 rounded-full -mt-2 -ml-1" x-bind:style="'left: '+minthumb+'%'"></div>
                <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-blue-300 rounded-full -mt-2 -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>
            </div>

        </div>

        <div class="flex justify-between items-center py-5">
            <div>
                <input name="{{ $attr["minName"] }}" type="text" maxlength="5" x-on:input="mintrigger" x-model="minValue" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
            </div>
            <div>
                <input name="{{ $attr["maxName"] }}" type="text" maxlength="5" x-on:input="maxtrigger" x-model="maxValue" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
            </div>
        </div>

    </div>

    <script>
        function range_{{ $attr["originalName"] }}() {
            return {
                minValue: parseInt('{{ $attr["minValue"] ?? $attr["min"] }}'),
                maxValue: parseInt('{{ $attr["maxValue"] ?? $attr["max"] }}'),
                min: parseInt('{{ $attr["min"] }}'),
                max: parseInt('{{ $attr["max"] }}'),
                step: parseInt('{{ $attr["step"] }}'),
                minthumb: 0,
                maxthumb: 0,

                mintrigger() {
                    this.minValue = Math.min(this.minValue, this.maxValue - this.step);
                    this.minthumb = ((this.minValue - this.min) / (this.max - this.min)) * 100;
                },

                maxtrigger() {
                    this.maxValue = Math.max(this.maxValue, this.minValue + this.step);
                    this.maxthumb = 100 - (((this.maxValue - this.min) / (this.max - this.min)) * 100);
                },
            }
        }
    </script>
</div>