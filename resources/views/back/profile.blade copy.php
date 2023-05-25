@extends('layouts.back')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Profile Setting</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </div><!-- /.col -->

@endsection
@section('content')

<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body p-0">
                        @if ($user->id)
                            @if (Auth::user()->id == $user->id)
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-3 profile-sidebar text-white rounded-left-sm-up">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active" data-toggle="pill" href=".edit-profile-tab" role="tab" aria-controls="edit-profile-tab" aria-selected="true">
                                                Avatar
                                            </a>
                                            <a class="nav-link" data-toggle="pill" href=".edit-settings-tab" role="tab" aria-controls="edit-settings-tab" aria-selected="false">
                                                Profile
                                            </a>
                                            <a class="nav-link" data-toggle="pill" href=".edit-account-tab" role="tab" aria-controls="edit-settings-tab" aria-selected="false">
                                                Password
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-8 col-md-9">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active edit-profile-tab" role="tabpanel" aria-labelledby="edit-profile-tab">
                                                <div class="row mb-1">
                                                    <div class="col-sm-12">
                                                        <div id="avatar_container">
                                                            <div class="collapseOne card-collapse collapse @if($user->avatar == null) show @endif">
                                                                <div class="card-body">
                                                                    <img src="{{  Gravatar::get($user->email) }}" alt="{{ $user->name }}" class="user-avatar">
                                                                </div>
                                                            </div>
                                                            <div class="collapseTwo card-collapse collapse @if($user->avatar != null) show @endif">
                                                                <div class="card-body">
                                                                    <div class="dz-preview"></div>
                                                                    {!! Form::open(array('route' => 'back.profile.upload', 'method' => 'POST', 'name' => 'avatarDropzone','id' => 'avatarDropzone', 'class' => 'form single-dropzone dropzone single', 'files' => true)) !!}
                                                                        <img id="user_selected_avatar" class="user-avatar" src="@if ($user->avatar != null) {{ $user->avatar }} @endif" alt="{{ $user->name }}">
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                                
                                <div class="tab-pane fade edit-settings-tab" role="tabpanel" aria-labelledby="edit-settings-tab">
                                             
                                        {!! Form::model($user, array('action' => array('ProfileController@update', $user->id), 'method' => 'PUT', 'id' => 'user_basics_form')) !!}

                                        <div class="pr-3 pl-2 form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                                            {!! Form::label('name','Full name' ,array('class' => 'col-md-3 control-label')); !!}
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    {!! Form::text('name', $user->name, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Full Name')) !!}
                                                    <div class="input-group-append">
                                                        <label class="input-group-text" for="name">
                                                            <i class="fa fa-fw name" aria-hidden="true"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                @if($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="pr-3 pl-2 form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
                                            {!! Form::label('email', 'Username/Email', array('class' => 'col-md-3 control-label')); !!}
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    {!! Form::text('email', $user->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email / Username' , 'disabled'=> true)) !!}
                                                    <div class="input-group-append">
                                                        <label for="email" class="input-group-text">
                                                            <i class="fa fa-fw email" aria-hidden="true"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group has-feedback {{ $errors->has('biography') ? ' has-error ' : '' }}">
                                                {!! Form::label('biography', 'Biography' , array('class' => 'col-12 control-label')); !!}
                                                <div class="col-12 col-md-9">
                                                    {!! Form::textarea('biography', $user->biography, array('id' => 'biography', 'class' => 'form-control', 'placeholder' =>'Enter Biography')) !!}
                                                    <span class="glyphicon glyphicon-pencil form-control-feedback" aria-hidden="true"></span>
                                                    @if ($errors->has('biography'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('biography') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                        </div>

                                        <div class="form-group has-feedback {{ $errors->has('personal_interest') ? ' has-error ' : '' }}">
                                                {!! Form::label('personal_interest', 'Personal Interest' , array('class' => 'col-12 control-label')); !!}
                                                <div class="col-12 col-md-9">
                                                    {!! Form::textarea('personal_interest', $user->personal_interest, array('id' => 'personal_interest', 'class' => 'form-control', 'placeholder' =>'Enter your personal interest')) !!}
                                                    <span class="glyphicon glyphicon-pencil form-control-feedback" aria-hidden="true"></span>
                                                    @if ($errors->has('personal_interest'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('personal_interest') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                        </div>

                                        <div class="pr-3 pl-2 form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                                            {!! Form::label('contact_number','Contact Number' ,array('class' => 'col-md-3 control-label')); !!}
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    {!! Form::text('contact_number', $user->contact_number, array('id' => 'contact_number', 'class' => 'form-control', 'placeholder' => 'Your mobile number')) !!}
                                                    <div class="input-group-append">
                                                        <label class="input-group-text" for="contact_number">
                                                            <i class="fa fa-fw name" aria-hidden="true"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                @if($errors->has('contact_number'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('contact_number') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                  
                                </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-md-9 offset-md-3">
                                        {!! Form::button(
                                            '<i class="fa fa-fw fa-save" aria-hidden="true"></i> ' . trans('profile.submitProfileButton'),
                                                array(
                                                'class'             => 'btn btn-success disabled',
                                                'id'                => 'account_save_trigger',
                                                'disabled'          => true,
                                                'type'              => 'button',
                                                'data-submit'       => trans('profile.submitProfileButton'),
                                                'data-target'       => '#confirmForm',
                                                'data-modalClass'   => 'modal-success',
                                                'data-toggle'       => 'modal',
                                                'data-title'        => trans('modals.edit_user__modal_text_confirm_title'),
                                                'data-message'      => trans('modals.edit_user__modal_text_confirm_message')
                                        )) !!}
                                    </div>
                                    {!! Form::close() !!}  
                                </div>                        
                
                        
                                <!-- end of row -->
                                <div class="tab-pane fade edit-account-tab" role="tabpanel" aria-labelledby="edit-account-tab">
                                                <ul class="account-admin-subnav nav nav-pills nav-justified margin-bottom-3 margin-top-1">
                                                    <li class="nav-item bg-info">
                                                        <a data-toggle="pill" href="#changepw" class="nav-link warning-pill-trigger text-white active" aria-selected="true">
                                                                Reset Password
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="changepw" class="tab-pane fade show active">

                                                        <h3 class="margin-bottom-1 text-center text-warning">
                                                          
                                                        </h3>

                                                        {!! Form::model($user, array('action' => array('ProfileController@updateUserPassword', $user->id), 'method' => 'PUT', 'autocomplete' => 'new-password')) !!}

                                                            <div class="pw-change-container margin-bottom-2">

                                                                <div class="form-group has-feedback row {{ $errors->has('password') ? ' has-error ' : '' }}">
                                                                    {!! Form::label('password', 'New Password', array('class' => 'col-md-3 control-label')); !!}
                                                                    <div class="col-md-9">
                                                                        {!! Form::password('password', array('id' => 'password', 'class' => 'form-control ', 'placeholder' => 'Enter new password', 'autocomplete' => 'new-password')) !!}
                                                                        @if ($errors->has('password'))
                                                                            <span class="help-block">
                                                                                <strong>{{ $errors->first('password') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group has-feedback row {{ $errors->has('password_confirmation') ? ' has-error ' : '' }}">
                                                                    {!! Form::label('password_confirmation', 'Password Confirmation', array('class' => 'col-md-3 control-label')); !!}
                                                                    <div class="col-md-9">
                                                                        {!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => 'Re-enter password')) !!}
                                                                        <span id="pw_status"></span>
                                                                        @if ($errors->has('password_confirmation'))
                                                                            <span class="help-block">
                                                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-9 offset-md-3">
                                                                    {!! Form::button(
                                                                        '<i class="fa fa-fw fa-save" aria-hidden="true"></i> ' . trans('profile.submitPWButton'),
                                                                            array(
                                                                            'class'             => 'btn btn-warning',
                                                                            'id'                => 'pw_save_trigger',
                                                                            'disabled'          => true,
                                                                            'type'              => 'button',
                                                                            'data-submit'       => 'submit-ch-pw',
                                                                            'data-target'       => '#confirmForm',
                                                                            'data-modalClass'   => 'modal-warning',
                                                                            'data-toggle'       => 'modal',
                                                                            'data-title'        => trans('modals.edit_user__modal_text_confirm_title'),
                                                                            'data-message'      => trans('modals.edit_user__modal_text_confirm_message')
                                                                    )) !!}
                                                                </div>
                                                            </div>
                                                        {!! Form::close() !!}

                                                    </div>
                                                </div>
                                    </div>
                            
                            @else
                                <p>---</p>
                            @endif
                        @else
                            <p>--</p>
                        @endif

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
               
            </div>
            <div class="row">
                <div class="col-12">
                    <input type="submit" value="Save Changes" class="btn btn-success float-left">
                </div>
            </div>
        </form>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
<script type="text/javascript">

$(document).ready(function(){
        
        $('.profile-trigger').click(function() {
            $('.panel').alterClass('card-*', 'card-default');
        });
        $('.settings-trigger').click(function() {
            $('.panel').alterClass('card-*', 'card-info');
        });
        $('.admin-trigger').click(function() {
            $('.panel').alterClass('card-*', 'card-warning');
            $('.edit_account .nav-pills li, .edit_account .tab-pane').removeClass('active');
            $('#changepw')
                .addClass('active')
                .addClass('in');
            $('.change-pw').addClass('active');
        });
        $('.warning-pill-trigger').click(function() {
            $('.panel').alterClass('card-*', 'card-warning');
        });
        $('.danger-pill-trigger').click(function() {
            $('.panel').alterClass('card-*', 'card-danger');
        });
        $('#user_basics_form').on('keyup change', 'input, select, textarea', function(){
            $('#account_save_trigger').attr('disabled', false).removeClass('disabled').show();
        });
        // $('#user_profile_form').on('keyup change', 'input, select, textarea', function(){
        //     $('#confirmFormSave').attr('disabled', false).removeClass('disabled').show();
        // });

            $('.btn-change-pw').click(function(event) {
                var pwInput = $('#password');
                var pwInputConf = $('#password_confirmation');
                pwInput.val('').prop('disabled', true);
                pwInputConf.val('').prop('disabled', true);
                $('.pw-change-container').slideToggle(100, function() {
                pwInput.prop('disabled', function () {
                    return ! pwInput.prop('disabled');
                });
                pwInputConf.prop('disabled', function () {
                    return ! pwInputConf.prop('disabled');
                });
                });
            });
            $("input").keyup(function() {
                checkChanged();
            });
            $("select").change(function() {
                checkChanged();
            });
            function checkChanged() {
                var saveBtn = $(".btn-save");
                if(!$('input').val()){
                saveBtn.hide();
                }
                else {
                saveBtn.show();
                }
            }


        $("#password_confirmation").keyup(function() {
            checkPasswordMatch();
        });
        $("#password, #password_confirmation").keyup(function() {
            enableSubmitPWCheck();
        });
        $('#password, #password_confirmation').hidePassword(true);
        $('#password').password({
            shortPass: 'The password is too short',
            badPass: 'Weak - Try combining letters & numbers',
            goodPass: 'Medium - Try using special charecters',
            strongPass: 'Strong password',
            containsUsername: 'The password contains the username',
            enterPass: false,
            showPercent: false,
            showText: true,
            animate: true,
            animateSpeed: 50,
            username: false, // select the username field (selector or jQuery instance) for better password checks
            usernamePartialMatch: true,
            minimumLength: 6
        });
        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#password_confirmation").val();
            if (password != confirmPassword) {
                $("#pw_status").html("Passwords do not match!");
            }
            else {
                $("#pw_status").html("Passwords match.");
            }
        }
        function enableSubmitPWCheck() {
            var password = $("#password").val();
            var confirmPassword = $("#password_confirmation").val();
            var submitChange = $('#pw_save_trigger');
            if (password != confirmPassword) {
                submitChange.attr('disabled', true);
            }
            else {
                submitChange.attr('disabled', false);
            }
        }



// file upload
        
Dropzone.autoDiscover = false;
$(function() {
   Dropzone.options.avatarDropzone = {
        paramName: 'file',
        maxFilesize: 1, // MB
        addRemoveLinks: true,
        maxFiles: 1,
        acceptedFiles: ".jpeg,.jpg",
        renameFile: 'avatar.jpg',
        headers: {
            "Pragma": "no-cache"
        },
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                //
            });
            this.on("maxfilesreached", function(file) {
                //
            });
            this.on("uploadprogress", function(file) {
                var html = '<div class="progress">';
                html += '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">';
                html += '</div>';
                html += '</div>';
                $('.dz-message').html(html).show();
            });
            this.on("maxfilesreached", function(file) {});
            this.on("complete", function(file) {
                this.removeFile(file);
            });
            this.on("success", function(file, response) {
                var html = '<div class="progress">';
                html += '<div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
                html += 'Upload Successful...';
                html += '</div>';
                html += '</div>';
                $('.dz-message').html(html).show();
                setTimeout(function() {
                    $('.dz-message').text('Drop files here to upload').show();
                }, 2000);
                $('#user_selected_avatar, .user-avatar-nav').attr('src', '/images/profile/{{ $user->id }}/avatar/avatar.jpg?' + new Date().getTime());
            });
            this.on("error", function(file, res) {
                var html = '<div class="progress">';
                html += '<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
                html += 'Upload Failed...';
                html += '</div>';
                html += '</div>';
                $('.dz-message').html(html).show();
                setTimeout(function() {
                    $('.dz-message').text('Drop files here to upload').show();
                }, 2000);
            });
        }
    };
    var avatarDropzone = new Dropzone("#avatarDropzone");
});

});

    </script>