<tr>
    <td class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" colspan="{{ count($resource->indexFields())+1 }}">
        <form action="{{ $resource->route("destroy", 1) }}" method="POST">
            @csrf
            @method("delete")
            <input name="ids" type="hidden" value="" class="actionBarIds">

            @if(isset($resource->actions["delete"]))
                <button class="text-indigo-600 hover:text-indigo-900 inline-block">
                    @include("admin::partials.icons.delete", ["size" => 6, "class" => "mr-2", "color" => "red"])
                </button>
            @endif
        </form>


        <script>
            function actionBarHandler() {
                return {
                    actionBarOpen : false,
                    actionBarCheckboxMain : false,
                    actionBar(type) {
                        if(document.querySelector('.actionBarCheckboxMain:checked') != null) {
                            this.actionBarCheckboxMain = true;
                        } else {
                            this.actionBarCheckboxMain = false;
                        }

                        var checkboxes = document.querySelectorAll('.actionBarCheckboxRow');
                        var values = [];

                        for(var i=0, n=checkboxes.length;i<n;i++) {
                            if(type == 'main') {
                                checkboxes[i].checked = this.actionBarCheckboxMain;
                            }

                            if(checkboxes[i].checked && checkboxes[i].value) {
                                values.push(checkboxes[i].value);
                            }
                        }

                        if(document.querySelector('.actionBarCheckboxRow:checked') != null) {
                            this.actionBarOpen = true;
                        } else {
                            this.actionBarOpen = false;
                        }

                        document.querySelector(".actionBarIds").value = values.join (";");
                    }
                };
            }
        </script>
    </td>
</tr>