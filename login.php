<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="assets/favicon.ico">
  <title>Enygma</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <main class="container-fluid login">
    <div class="row justify-content-center">
      <div class="col col-sm-7 col-xl-3 bg-white">
        <div class="container">
          <div class="row">
            <h2 class="col">Sign in</h2>
          </div>
          <div class="row">
            <form action="auth/auth" method="POST" class="col">
              <div class="form-group form-row">
                <div class="col">
                  <input type="text" class="form-control" placeholder="Nickname*" id="username" name="nickname" value="" required>
                </div>
              </div>
              <div class="form-group form-row">
                <div class="col">
                  <input type="password" class="form-control" placeholder="Password*" id="password" name="password" required>
                </div>
              </div>
              <div class="form-group form-row">
                <div class="col">
                  <div class="form-check form-control-sm">
                    <input class="form-check-input" type="checkbox" value="" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                  </div>
                </div>
              </div>
              <div class="form-group form-row">
                <div class="col">
                  <button type="submit" class="col form-control btn btn-primary">Sign in</button>
                </div>
              </div>
            </form>
          </div>
          <div class="row register">
            <div class="col form-control-sm">
              <a href="register">Create an account</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="assets/jquery.min.js"></script>
</body>
</html>