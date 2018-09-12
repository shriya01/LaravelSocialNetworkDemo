@extends ('layouts.admin')
@section('content')
<div class="col-lg-12">
  <h3 class="page-header"><i class="fa fa-table"></i>{{__('messages.users')}}<a class="btn btn-primary pull-right" href=" {{ url('/') }}/addUser"> {{__('messages.add_user')}}</a></h3>
  <ol class="breadcrumb">
    <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard">{{ __('messages.home') }}</a></li>
    <li><i class="fa fa-th-list"></i>{{ __('messages.users') }}</li>
  </ol>
</div>

    <div class="">
  <div class="col-lg-12">
    <section class="panel">
      @if ($errors->any())
      @foreach ($errors->all() as $error)
      <p class="error alert alert-block alert-danger fade in">
        {{ $error }}
      </p>
      @endforeach
      @endif
      @if(session()->has('message'))
      <div class="alert alert-success">
        {{ session()->get('message') }}
      </div>
      @endif
      <table class="table table-striped table-advance table-hover" id="data-table">
        <thead>
          <tr>
            <th>{{ __('messages.sno') }}</th>
            <th><i class="icon_profile"></i>{{ __('messages.full_name') }}</th>
            <th><i class="icon_mail_alt"></i>{{ __('messages.email') }}</th>
            <th><i class="icon_pin_alt"></i>{{ __('messages.action') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $key => $row)
          <tr>
            <th>{{$key+1}}</th>
            <td>{{$row->user_first_name}} {{$row->user_last_name}}</td>
            <td>{{$row->user_email}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-primary" title="{{__('messages.edit')}}" href="" data-toggle="tooltip">{{__('messages.view')}}</a> &nbsp;&nbsp;&nbsp;
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
</div>
<div class="row">
  <!-- page end-->
</section>
</section>
<!--main content end-->
@endsection