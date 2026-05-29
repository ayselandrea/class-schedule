<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Class Chronicles</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            margin: 0; padding: 0; font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f0f4f8; display: flex; align-items: center; justify-content: center; min-height: 100vh;
        }
        .split-container {
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    width: 100%; 
    max-width: 900px; 
    min-height: 580px; 
    height: auto;
    background: #fff; 
    border-radius: 20px; 
    overflow: hidden; 
    box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
    margin: 20px;
}

.right-form-box { 
    padding: 2.5rem; 
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
}
        .left-banner {
            background: linear-gradient(135deg, #a0c4ff 0%, #64b5f6 50%, #1e88e5 100%);
            padding: 3rem; display: flex; flex-direction: column; justify-content: center; color: #fff; position: relative;
        }
        .left-banner::before {
            content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.15) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 60%);
            pointer-events: none;
        }
        .left-banner h1 { font-size: 3rem; font-weight: 700; line-height: 1.2; margin: 0; }
        .form-title { font-size: 2rem; font-weight: 700; color: #1a202c; margin-bottom: 0.5rem; }
        .form-subtitle { color: #a0aec0; font-size: 0.9rem; margin-bottom: 1.5rem; }
        .input-group { display: flex; flex-direction: column; gap: 4px; margin-bottom: 1rem; }
        .input-group label { font-size: 0.85rem; color: #718096; font-weight: 500; }
        .input-field { padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; outline: none; }
        .input-field:focus { border-color: #64b5f6; box-shadow: 0 0 0 3px rgba(100, 181, 246, 0.2); }
        .submit-btn { background-color: #42a5f5; color: white; border: none; padding: 14px; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; margin-top: 1rem; }
        .submit-btn:hover { background-color: #1e88e5; }
        .switch-auth-text { text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: #718096; }
        .switch-auth-text a { color: #42a5f5; text-decoration: none; font-weight: 600; }
        .alert-error { background-color: #fff5f5; color: #e53e3e; padding: 10px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1rem; border: 1px solid #fed7d7; }
        @media (max-width: 768px) { .split-container { grid-template-columns: 1fr; height: auto; } .left-banner { display: none; } }
    </style>
</head>
<body>

  <div class="split-container">
    
    <!-- LEFT SIDE: SPLASH BANNER -->
    <div class="left-banner">
      <div style="font-size: 1.5rem; font-weight: 800; margin-bottom: auto;">Class Chronicles</div>
      <h1>Create<br>Account</h1>
      <div style="margin-top: auto; opacity: 0.8; font-size: 0.9rem;">Join us and organize your classes today.</div>
    </div>

    <!-- RIGHT SIDE: FORM -->
    <div class="right-form-box">
      <h2 class="form-title">Sign Up</h2>
      <p class="form-subtitle">Please fill in the details to create an account.</p>

      @if($errors->any())
        <div class="alert alert-error">
          {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('register') }}" method="POST" style="display: flex; flex-direction: column;">
        @csrf
        
        <div class="input-group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" class="input-field" value="{{ old('name') }}" placeholder="Juan Dela Cruz" required autofocus>
        </div>

        <div class="input-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" class="input-field" value="{{ old('email') }}" placeholder="username@gmail.com" required>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="input-field" placeholder="••••••••" required>
        </div>

        <div class="input-group">
          <label for="password_confirmation">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" placeholder="••••••••" required>
        </div>

        <button type="submit" class="submit-btn">Sign Up</button>
      </form>

      <p class="switch-auth-text">Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </div>

  </div>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    @if(session('success'))
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        
        showClass: {
          popup: 'animate__animated animate__bounceInRight' 
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutDown' 
        },
        
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

      Toast.fire({
        icon: 'success',
        title: "{{ session('success') }}"
      });
      @endif
  </script>
</body>
</html>