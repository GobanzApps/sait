  <style>
    /* Centrar */
    .login-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    
    /* Ventana vidrio pulido */
    .login-box {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(30px);
      -webkit-backdrop-filter: blur(30px);
      border-radius: 25px;
      border: 1px solid rgba(255, 255, 255, 0.25);
      box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.2),
        inset 0 -1px 0 rgba(0, 0, 0, 0.1);
      width: 420px;
      padding: 40px 30px;
      position: relative;
      overflow: hidden;
    }
    
    /* Brillo superior de la ventana */
    .login-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 40%;
      background: linear-gradient(to bottom, 
        rgba(255, 255, 255, 0.15) 0%, 
        transparent 100%);
      border-radius: 25px 25px 0 0;
      pointer-events: none;
    }
    
    /* Logo más grande y centrado */
    .login-logo {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .login-logo img {
      width: 150px;
      height: auto;
      filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
      transition: transform 0.3s ease;
    }
    
    .login-logo img:hover {
      transform: scale(1.05);
    }
    
    .login-box-msg {
      color: white;
      text-align: center;
      font-size: 20px;
      margin-bottom: 30px;
      font-weight: 400;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
      letter-spacing: 0.5px;
    }
    
    .form-group {
      margin-bottom: 25px;
      position: relative;
    }
    
    /* Inputs transparentes */
    .form-control {
      background: rgba(255, 255, 255, 0.08) !important;
      border: 1.5px solid rgba(255, 255, 255, 0.3) !important;
      border-radius: 12px !important;
      color: white !important;
      padding: 12px 45px 12px 20px !important;
      height: 50px !important;
      font-size: 16px !important;
      transition: all 0.3s ease !important;
      box-shadow: none !important;
      letter-spacing: 0.5px;
    }
    
    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.5);
      font-weight: 300;
      letter-spacing: 0.5px;
    }
    
    .form-control:focus {
      background: rgba(255, 255, 255, 0.15) !important;
      border-color: rgba(255, 255, 255, 0.6) !important;
      box-shadow: 0 0 25px rgba(255, 255, 255, 0.15), 
                  inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
      outline: none !important;
    }
    
    /* Iconos que resalten */
    .form-control-feedback {
      color: white !important;
      line-height: 50px !important;
      right: 15px !important;
      font-size: 20px !important;
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
      transition: all 0.3s ease;
    }
    
    .form-control:focus + .form-control-feedback {
      color: #ffffff !important;
      text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
      font-size: 22px !important;
    }
    
    /* Botón */
    .btn-ingresar {
      width: 100%;
      padding: 14px;
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 30px;
      color: white;
      font-size: 16px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 2px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      position: relative;
      overflow: hidden;
    }
    
    .btn-ingresar::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, 
        transparent, 
        rgba(255, 255, 255, 0.2), 
        transparent);
      transition: left 0.5s ease;
    }
    
    .btn-ingresar:hover {
      background: rgba(255, 255, 255, 0.25);
      border-color: rgba(255, 255, 255, 0.5);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
    
    .btn-ingresar:hover::before {
      left: 100%;
    }
    
    .btn-ingresar:active {
      transform: translateY(0);
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .row {
      margin-top: 10px;
    }
  </style>

<div class="login-wrapper">
  
  <div class="login-box">
    
    <!-- Logo más grande y centrado -->
    <div class="login-logo">
      <img src="vistas/img/plantilla/icono-negro.png" alt="Logo">
    </div>

    <form method="post">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="row">
        <button type="submit" class="btn-ingresar">Ingresar</button>
      </div>

      <?php
      $login = new ControladorUsuarios();
      $login -> ctrIngresoUsuario();
      ?>

    </form>
    
  </div>
  
</div>
