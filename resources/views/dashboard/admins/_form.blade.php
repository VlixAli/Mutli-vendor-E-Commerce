@if($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occurred!</h3>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <x-form.input label="Admin Name" name="name" :value="$admin->name"/>
</div>
<div class="form-group">
    <x-form.input name="email" label="Email" :value="$admin->email"/>
</div>
<div class="form-group">
    <label for="">Roles</label>
    @foreach($roles as $role)
        <div>
            <input type="checkbox" name="roles[]" value="{{$role->id}}" @checked(in_array($role->id, $admin_roles))>
            {{$role->name}}
        </div>
    @endforeach
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
