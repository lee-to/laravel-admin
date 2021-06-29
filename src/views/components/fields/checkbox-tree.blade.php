<div x-data="checkboxTree_{{ $attr["originalName"] }}()" x-init="() => { init() }">
    {!! $attr["html"] ?? "" !!}

    <script>
        function checkboxTree_{{ $attr["originalName"] }}() {
            return {
                checked: @json($value->pluck("id")),
                ids: @json($attr["ids"]),
                init() {
                    var refs = this.$refs;
                    var checked = this.checked;

                    this.ids.forEach(function (id) {
                        var input = refs["item_" + id].querySelector("input");

                        checked.forEach(function (c) {
                            if(c == input.value) {
                                input.checked = true;
                            }
                        });
                    });
                }
            }
        }
    </script>
</div>
