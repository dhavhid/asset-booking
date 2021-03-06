@extends('layouts.admin')
@section('title')
    Settings
@stop
@section('content')
    <h1>Site Settings</h1>
    <hr>
    <div class="globalSettings">
        @foreach($globalSetting as $setting)
            <div class="setting" id="{{$setting->id}}" data-id="{{$setting->id}}" data-type="{{$setting->type}}">
                <label for="{{$setting->slug}}">{{$setting->name}}</label>
                @if($setting->type === "checkbox")
                    @if($setting->adminSetting->value)
                        <input type="checkbox" name="{{$setting->slug}}" id="{{$setting->slug}}" checked="checked" />
                    @else
                        <input type="checkbox" name="{{$setting->slug}}" id="{{$setting->slug}}" />
                    @endif
                @elseif($setting->type === "textbox")
                    <input type="text" class="form-control" name="{{$setting->slug}}" id="{{$setting->slug}}" value="{{$setting->adminSetting->value}}" />
                @elseif($setting->type === "number")
                    <input type="number" class="form-control" name="{{$setting->slug}}" id="{{$setting->slug}}" value="{{$setting->adminSetting->value}}" />
                @elseif($setting->type === "email")
                    <input type="email" class="form-control" name="{{$setting->slug}}" id="{{$setting->slug}}" value="{{$setting->adminSetting->value}}" />
                @endif
            </div>
        @endforeach
    </div>
    <br class="clear">
    <button id="submitGlobal" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Save</button>
    <br class="clear" />
    <div id="globalResponse">

    </div>
    <br class="clear" />
    <br>
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submitGlobal').on('click', function() {
            submitGlobal();
        });
    });

    function submitGlobal() {
        let returnArray = [];
        $('.globalSettings .setting').each(function(elm) {
            let item = {};
            let id = $(this).data('id');
            let type = $(this).data('type');
            let value = false;
            if(type !== 'checkbox') {
                value = $('input', this).val();
            }
            else {
                value = $('input', this).is(':checked');
            }

            item['id'] = id;
            item['type'] = type;
            item['value'] = value;

            returnArray.push(item);
        });
        if(returnArray.length > 0) {
            let dataVal = JSON.stringify(returnArray);

            $.ajax({
                method: "POST",
                url: "{{ url('/admin/settings/global') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'data': dataVal,
                }
            }).done(function( msg ) {
                let res = JSON.parse(msg);
                if(res.status === "Sucesss") {
                 $('#globalResponse').removeClass().addClass('good').html(res.message);
                }
                else {
                 $('#globalResponse').removeClass().addClass('bad').html(res.message);
                }
            });

        }

    }

</script>