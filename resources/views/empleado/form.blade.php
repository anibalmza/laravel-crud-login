<h2>{{ $modo }} empleado</h2>

@if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="foto">Apellido</label>
    <input type="text" name="apellido" class="form-control" value='{{ isset($empleado->apellido)?$empleado->apellido:old("apellido") }}' placeholder="Apellido"><br>
</div>

<div class="form-group">
<label for="foto">Nombre</label>
<input type="text" name="nombre" class="form-control" value='{{ isset($empleado->nombre)?$empleado->nombre:old("nombre") }}' placeholder="Nombre"><br>
</div>

<div class="form-group">
<label for="foto">email</label>
<input type="email" name="email" class="form-control" value='{{ isset($empleado->email)?$empleado->email:old("email") }}' placeholder="email"><br>
</div>

<div class="form-group">
<label for="foto">Foto</label>
@if(isset($empleado->foto))
    <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->foto }}" width="100" alt="">
@endif
</div>

<input type="file" name="foto" value="">
<br>
<br>

<input type="submit" value="Guardar" class="btn btn-success">

<a href="{{ url('empleado') }}" class="btn btn-primary">Regresar</a>