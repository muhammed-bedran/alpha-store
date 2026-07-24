
<div class="card-body">
    <div class="form-group">
        
        <x-form.input id="name" name="name"  type="text" placeholder="Enter Admin Name" label="Enter Admin Name" :value="$admin->name" />
         
        </div>
    <div class="form-group">
                <x-form.input id="email" name="email" type="email" placeholder="Enter Admin email" label="Enter Admin email" 
                    :value="$admin->email" />


    </div>

    <div class="form-group">
        <x-form.input id="password" name="password" type="password" placeholder="Enter Admin password" label="Enter Admin password"
            :value="$admin->password" />
    
    
    </div>
<div class="form-group">
    <x-form.input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm password"
        label="Confirm password" :value="$admin->password_confirmation" />


</div>
    <x-form.select
    label="Select Category Status"
    name="status"
    :options="[
        'active' => 'Active',
        'inactive' => 'Inactive'
    ]"
       :selected="$category->status ?? 'active'"
    />

</div>

<div class="form-group form-check">
    <input type="hidden"  name="super_admin" value="0">
    <input type="checkbox"  name="super_admin" value="1" {{ old('super_admin', $admin->super_admin) ? 'checked' : '' }}>
    <label for="super_admin">Super Admin</label>
</div>
<div class="form-group">
    <label>Roles</label>
    @php
        $selectedRoles = collect(old('roles',$admin->exists ? $admin->roles->pluck('id')->all() : []));
    @endphp
    @forelse ( $roles as $role )
            <div class="form-check">
        <input
        class="form-check-input"
        type="checkbox"
        name="roles[]"
        value="{{ $role->id }}"
        {{ $selectedRoles->contains($role->id) ? 'checked' : '' }}
        
        >
        <label>{{ $role->name }}</label>
    </div>
    @empty
        <p>No roles found


            <a href="{{ route('role-permession.roles.create') }}">Create a role</a>
        </p>
    @endforelse 
    

   
    
</div>