<!Doctype HTML>
<HTML lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    

        <title>Login</title>
        <style>
            body {
                background-color: #222F37;
                font-family: Arial, sans-serif;
            }

        .footer {
            background-color: #0A3873;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .card {
            background-color: #FDFDD7;
        }
        .footer .contact {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .footer .contact div {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer .contact img {
            width: 20px;
            height: 20px;
        }
        .footer .logo img {
            width: 100px;
            height: 100px;

        }
        @media (max-width: 600px) {
            .footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }
            .Login {
                width: 400px;
                height: 60px;
                font-size: 16px;
                padding: 10px 10 10;
                margin: 40px 0 0 0;
                border-radius: 10px 10px 10px 10px;
                border-width: 1px;

            }

            .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f5f5dc;
            padding: 10px 20px;
        }
        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5em;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        .logo img {
            height: 40px;
            margin-right: 10px;
        }
        .menu {
            display: flex;
            gap: 20px;
        }
        .menu a {
            text-decoration: none;
            color: black;
            font-size: 1.1em;
        }
        .menu a:hover {
            text-decoration: underline;
        }
        .user-icon {
            font-size: 1.5em;
        }

        /* Hamburger Menu Styles */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-around;
            width: 30px;
            height: 25px;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .hamburger div {
            width: 30px;
            height: 4px;
            background-color: black;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .menu {
                display: none;
                width: 100%;
                flex-direction: column;
                align-items: center;
                gap: 10px;
                padding: 10px;
                background-color: #f5f5dc;
            }

            .menu.active {
                display: flex;
            }

            .hamburger {
                display: flex;
            }
        }
        </style>
    </head>
    <body>
        <center style="margin-top: 150px;">
        <form id="loginForm" method="post">
            @csrf
            <div class="card" style="width: 30rem;  margin-bottom: 100px;border-radius: 20px 20px 20px 20px;">
                <center>  
                    <img width="100px" height="100px" src="{{ asset('storage/Logo.png') }}" style="margin-top: 5%;" alt="Badminton Logo"><br>
                        <label style="font-size:20px; font-weight:bold; padding-top:5%;">Ramos Badminton</label><br>
                            <input type="text" name="name" id="name" placeholder="Nama Pengguna" class="Login" style="background-color: rgba(255, 255, 255, 0.5); padding-left: 20px;" required><br>
                            <input type="password" name="password" id="password" placeholder="Kata Sandi" class="Login" style="background-color: rgba(255, 255, 255, 0.5);padding-left: 20px;" required><br>
                            <button type="submit" class="Login" style="color: #FDFDD7; font-weight: bold; background-color: #222F37;">Masuk</button><br><br>
                            <a href="" style="text-decoration: none; color: #222F37;font-size:15px; font-weight:bold;" >Lupa Kata Sandi?</a><br><br>
                            <p style="font-size: 20px;">Belum punya akun?
                            <a href="{{ url('/') }}" style="text-decoration: none;">Daftar yuk!</a>
                </center>
            </div>
         </form">
    </center>
    <div id="base-url" style="display:none">{{ env('API_BASE_URL') }}</div>

    <script>
    document.getElementById("loginForm").addEventListener("submit", async function(event) {
    event.preventDefault();
    
    console.log("Form submitted!"); // Cek apakah event listener bekerja

    const name = document.getElementById("name").value;
    const password = document.getElementById("password").value;

    console.log("Sending request to API...");

try {
  const baseUrl = document.getElementById('base-url').textContent.trim().replace(/\/+$/, '');

  const response = await fetch(`${baseUrl}/auth/login`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name, password }),
  });

  // lanjutkan proses response...
} catch (error) {
  console.error("Error saat login:", error);
  alert("Terjadi kesalahan, silakan coba lagi.");
}

        const data = await response.json();
        console.log("Response received:", data);

        if (response.ok) {
            alert("Login berhasil!");
            window.location.href = "/"
        } else {
            alert("Error: " + (data.message || "Gagal login"));
        }
    } catch (error) {
        console.error("Fetch error:", error);
        alert("Terjadi kesalahan, cek console untuk detailss.");
    }
});
</script>

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>
</HTML>