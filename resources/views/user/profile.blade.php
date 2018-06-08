@extends('user.layouts')

@section('css')
    <link href="/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('title', trans('home.panel'))
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top: 0px; min-height: 354px;">
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                @if (Session::has('successMsg'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {{Session::get('successMsg')}}
                    </div>
                @endif
                @if (Session::has('errorMsg'))
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <strong>{{trans('home.error')}}：</strong> {{Session::get('errorMsg')}}
                    </div>
                @endif
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light bordered">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">{{trans('home.profile')}}</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1" data-toggle="tab">{{trans('home.password')}}</a>
                                        </li>
                                        <li>
                                            <a href="#tab_2" data-toggle="tab">{{trans('home.contact')}}</a>
                                        </li>
                                        <li>
                                            <a href="#tab_3" data-toggle="tab">{{trans('home.ssr_setting')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            <form action="{{url('user/profile')}}" method="post" enctype="multipart/form-data" class="form-bordered">
                                                <div class="form-group">
                                                    <label class="control-label">{{trans('home.current_password')}}</label>
                                                    <input type="password" class="form-control" name="old_password" id="old_password" autofocus required />
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">{{trans('home.new_password')}}</label>
                                                    <input type="password" class="form-control" name="new_password" id="new_password" required />
                                                </div>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class=" col-md-4">
                                                            <button type="submit" class="btn green">{{trans('home.submit')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="tab_2">
                                            <form id="profile" action="{{url('user/profile')}}" method="post" enctype="multipart/form-data" class="form-bordered">
                                                <div class="form-group">
                                                    <label class="control-label">{{trans('home.username')}}</label>
                                                    <input type="text" class="form-control" name="username" value="{{$info->username}}" id="username" required disabled="disabled"/>
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                </div>
                                                @if($info->u_phone_status == 1)
                                                    1
                                                @else
                                                    <div class="row" style="margin-bottom: 15px">
                                                        <div class="col-sm-8 col-md-8 col-xs-8">
                                                            <label class="control-label">手机号</label>
                                                            <input type="text" class="form-control" name="u_contract_0" value="{{$info->u_contract_0}}" id="u_contract_0" required />
                                                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                        </div>
                                                        <div class="col-sm-4 col-md-4 col-xs-4">
                                                            <div style="height: 23px"></div>
                                                            <button id="send" type="button" class="btn red" onclick="Sms()">点击发送验证码</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">验证码</label>
                                                        <input type="text" class="form-control" name="smscode" value="" id="smscode" required />
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                    </div>
                                                @endif

                                                <div class="form-group">
                                                    <label class="control-label">{{trans('home.wechat')}}</label>
                                                    <input type="text" class="form-control" name="wechat" value="{{$info->wechat}}" id="wechat" required />
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"> QQ </label>
                                                    <input type="text" class="form-control" name="qq" value="{{$info->qq}}" id="qq" required />
                                                </div>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn green">{{trans('home.submit')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="tab_3">
                                            <form action="{{url('user/profile')}}" method="post" enctype="multipart/form-data" class="form-bordered">
                                                <div class="form-group">
                                                    <label class="control-label"> {{trans('home.connection_password')}} </label>
                                                    <input type="text" class="form-control" name="passwd" value="{{$info->passwd}}" id="passwd" required />
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"> {{trans('home.encrpytion')}} </label>
                                                    <select class="form-control" name="method" id="method">
                                                        @foreach ($method_list as $method)
                                                            <option value="{{$method->name}}" @if($method->name == $info->method) selected @endif>{{$method->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"> {{trans('home.protocal')}} </label>
                                                    <select class="form-control" name="protocol" id="protocol">
                                                        @foreach ($protocol_list as $protocol)
                                                            <option value="{{$protocol->name}}" @if($protocol->name == $info->protocol) selected @endif>{{$protocol->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"> {{trans('home.obfs')}} </label>
                                                    <select class="form-control" name="obfs" id="obfs">
                                                        @foreach ($obfs_list as $obfs)
                                                            <option value="{{$obfs->name}}" @if($obfs->name == $info->obfs) selected @endif>{{$obfs->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn green"> {{trans('home.submit')}} </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script type="text/javascript">
        $('#exampleModal').on('show.bs.modal', function (event) {
            var recipient = $("input[name='contract_to']").val();
            if(recipient.length==13 || recipient.indexOf('@'))
            var modal = $(this)
            modal.find('.modal-title').text('验证码');
            modal.find('.modal-body .phone').val(recipient)
            Sms();
        })
        $('#profile').submit(function () {
            var recipient = $("input[name='contract_to']").val();
            // console.log(recipient.indexOf('@') == -1);
            if(recipient.indexOf('@') == -1){
                //手机验证码
                $('#ToSms').click();
                return false;
            }else{
                //邮箱
                return true;
            }

        })

        function Sms() {
            var phone = $("input[name='u_contract_0']").val();
            // console.log(phone)
            $("#send").attr('disabled','disabled');

            $.get('/sendSms',{phone:phone});

            var time = 60;
            var codeTimes=setInterval(function() {
                if(time<=0){
                    clearInterval(codeTimes);
                    $("#send").html("点击获取验证码");
                    $("#send").attr("disabled",false);
                }else{
                    time--;
                    var val=time+'后重获';
                    $("#send").html(val);
                }
            },1000);
        }
    </script>
@endsection