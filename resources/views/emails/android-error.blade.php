@extends('emails/layouts/default')

@section('content')
<p>Hello Developers,</p>

<p>We has found error in {!! $phoneModel !!} {!! $androidVersion !!}</p>

<p>{!! $stackTrace !!}</p>

<p>{!! $packageName !!} of version {!! $packageVersion !!}</p>

<p>Best regards,</p>

<p>Error Support</p>
@stop
