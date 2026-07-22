<div class="card-body">
    <div class="form-group">

        <x-form.input id="name" name="name" type="text" placeholder="Enter Name" label="Enter Product Name"
            :value="$member->name" />
    </div>

    <div class="form-group">

        <x-form.input id="email" name="email" type="email" placeholder="Enter Email" label="Email"
            :value="$member->email" />
    </div>
    <div class="form-group">

        <x-form.input id="password" name="password" type="password" placeholder="Enter password" label="Password"
            :value="''" />
    </div>


    <div class="form-group">
    
        <x-form.input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm Password" label="Password"
            :value="''" />
    </div>


</div>