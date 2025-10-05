@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Datos</h1>
@stop


@section('content')


    <div class="row">
        <div class="col-md-12">
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">configuracion de la plataforma de tutorias</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
               <div class="for">
                <div class="row">
                  <div class="col-md-4">
                      asdf
                  </div>
                <div class="col-md-8">
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for ="">Nombre completo</label><b>(s)</b>
                              <div class="input-group- mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                                  </div>
                                  <input type="text" class="form-control" value="{{ old('nombre', $configuracion->nombre ?? '') }}"
                                  name="nombre" placeholder="Introduzca el nombre" required>
                              </div>
                              @error('nombre')
                              <small style="color: red">{{$message}}</small>
                              @enderror
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for ="">Descripcion</label><b>()</b>
                          <div class="input-group- mb-3">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                              </div>
                            <input type="text" class="form-control" value="{{ old('descripcion', $configuracion->descripcion ?? '') }}"
                            name="descripcion" placeholder="Describa" required>
                          </div>
                          @error('descripcion')
                          <small style="color: red">{{$message}}</small>
                          @enderror
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
    </div> 

  @stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
  @stop

    
@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
  @stop