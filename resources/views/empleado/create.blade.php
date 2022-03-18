@extends('layouts.app')

@section('content')
<div class="container">

<!-- <h1>Formulario de creacion de empleado </h1>  -->
<form action="{{ url('/empleado') }}" method="post" enctype="multipart/form-data">
@csrf
@include('empleado.form',['modo'=>'Crear'])

</form>
</div>
@endsection