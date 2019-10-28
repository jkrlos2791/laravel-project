<!DOCTYPE html> 
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Acceso al sistema</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">	
	<link href="{{ asset('jl/bootstrap4/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('jl/core/styles/signin.css')}}" rel="stylesheet">
  </head>
  <body class="text-center">
    <form method="post" action="{{ url('user/signin')}}" class="form-signin" id="LoginAjax">
      <h1 class="h3 mb-3 font-weight-normal">Acceso al sistema</h1>
      <label for="inputEmail" class="sr-only">Usuario</label>
      <input type="text" id="inputEmail" class="form-control" placeholder="Usuario" name="username" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
</html>