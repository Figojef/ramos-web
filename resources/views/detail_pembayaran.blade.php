@extends('layouts.app')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="">

    <title>Jadwal Bermain</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        #judul {
            display: flex; 
            justify-content: center; 
            align-items: center;
        }

        .informasi1 {
            font-size: 25px;
            font-weight: light;
        }

        .informasi2 {
            font-size: 25px;
            font-weight: light;
            margin-bottom: 25px;
        }

        .tombol {
            color: white;
            font-weight: 700;
            background-color: black;
            width: 100%;       
            height: 40px;      
            border-radius: 10px;      
            font-size: 16px;   
        }

        /* Flexbox container to align payment details and countdown side by side */
        .container-flex {
            display: flex;
            justify-content: space-between; /* This will spread the left and right sections */
            margin-bottom: 20px;
            align-items: center; /* This ensures they align at the same height */
        }

        .left-section {
            flex: 1; /* This ensures that the left section takes up as much space as possible */
        }

        .right-section {
            flex: 0.4; /* This gives the right section 40% of the space */
            display: flex;
            justify-content: flex-end; /* Align countdown to the right */
            align-items: center;
        }

        .deadline {
            display: flex;
            align-items: center;
        }

        .deadline-content {
            display: flex;
            align-items: center;
        }

        .icon-deadline {
            margin-right: 10px;
            cursor: pointer; /* To indicate it's clickable */
        }

        /* Optional: Adjust spacing between countdown and payment info */
        .countdown-container .deadline-content p {
            margin-left: 10px;
        }

        .upload-btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #white;
      color: black;
      font-size: 16px;
      cursor: pointer;
      border-radius: 8px;
      border: 2px solid black;
      transition: background-color 0.3s ease;
    }

    .upload-btn:hover {
      background-color: grey;
    }

    #upload-input {
      display: none;
    }

    .preview-image {
    max-width: 80px;
    max-height: 80px;
    border: 1px solid #ccc;
    border-radius: 6px;
    object-fit: cover;
}
    </style>

<body>
    <div class="container mt-4">
        <h2 id="judul">Detail Pembayaran</h2>

        <!-- First <hr> line -->
        <hr style="border: 2px solid #000000; margin: 20px 0;">

        <!-- Flex container holding countdown and payment info -->
        <div class="container-flex">
            <!-- Left Section: Payment Details -->
            <div class="left-section">
                <label class="informasi1">Nomor Rekening</label><br>
                <label class="informasi2" id="rekening">7172 7838 7489234</label> 
                <!-- Salin icon (path updated to public/icons) -->
                <img src="{{ asset('icons/icon_Copy.png') }}" alt="Icon" width="20" height="20" id="copyButton" style="cursor: pointer;" onclick="copyToClipboard()"> <br>

                <label class="informasi1">Atas Nama</label><br>
                <label class="informasi2">Yakop Simatupang</label><br>

                <label class="informasi1">Nominal Transfer</label><br>  
                <label class="informasi2">Rp. 60.000</label><br>

                <form action="/upload_bukti" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="YOUR_CSRF_TOKEN_HERE">
                    <input type="file" name="bukti_transfer" id="upload" class="d-none" accept="image/*,application/pdf" required>


                    <label class="informasi1">Bukti Pembayaran</label><br>  
                    <div class="upload-container">
    <label for="upload-input" class="upload-btn">
        <img src="{{ asset('icons/icon_upload.png') }}" alt="Upload Icon"
             style="width: 20px; vertical-align: middle; margin-right: 8px;">
        Upload
    </label>
    <img id="preview" class="preview-image" src="{{ asset('images/placeholder.png') }}" alt="Preview Gambar">
</div>

<input type="file" id="upload-input" accept="image/*" style="display: none;">

            </div>

            <!-- Right Section: Countdown -->
            <div class="right-section">
                <div class="deadline">
                    <div class="deadline-content">
                        <!-- Deadline icon (path updated to public/icons) -->
                        <img src="{{ asset('icons/icon_Jam.png') }}" alt="Icon" width="30" height="30" class="icon-deadline">
                        <p>Batas Akhir Pembayaran <br>
                        <strong id="countdown"></strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second <hr> line -->
        <hr style="border: 2px solid #000000; margin: 20px 0;">
        <button type="button" onclick="uploadImage()" class="tombol">Konfirmasi Pembayaran</button>
    </div>
<div id="base-url" style="display:none">{{ env('API_BASE_URL') }}</div>
    <script>
  // Ambil data deadline dari session Laravel
  const deadlineString = "{{ session('payment_deadline') }}";  // Format: "YYYY-MM-DD HH:MM:SS"
    const deadlineDate = new Date(deadlineString); // Konversi string ke objek Date

    // Fungsi untuk menghitung countdown
    function updateCountdown() {
        const now = new Date().getTime();
        const timeLeft = deadlineDate - now;

        if (timeLeft <= 0) {
            document.getElementById("countdown").innerHTML = "Waktu Habis";
            clearInterval(countdownInterval);
        } else {
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            document.getElementById("countdown").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
        }
    }

    // Perbarui countdown setiap detik
    const countdownInterval = setInterval(updateCountdown, 1000);

        // Run once to show initial value
        updateCountdown();

        // Function to copy the rekening number to clipboard
        function copyToClipboard() {
            const rekening = document.getElementById("rekening").innerText;
            const copyButton = document.getElementById("copyButton");
            
            // Change the icon to 'copied' icon
            copyButton.src = "{{ asset('icons/icon_Copydone.png') }}"; 

            // Attempt to copy the text to the clipboard
            navigator.clipboard.writeText(rekening).then(() => {
                // Revert the icon after 2 seconds
                setTimeout(() => {
                    copyButton.src = "{{ asset('icons/icon_Copy.png') }}"; // Reset to original icon
                }, 2000);
            }).catch(err => {
            });
        }


        let selectedFile = null; // simpan file yang dipilih

document.getElementById('upload-input').addEventListener('change', function(event) {
    selectedFile = event.target.files[0];
    if (!selectedFile) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview').src = e.target.result;
    };
    reader.readAsDataURL(selectedFile);
});

async function uploadImage() {
    if (!selectedFile) {
        alert('Silakan pilih gambar terlebih dahulu.');
        return;
    }

    const formData = new FormData();
    formData.append('image', selectedFile);

 try {
  const transactionId = '{{ session('transaction_id') }}';
  const baseUrl = document.getElementById('base-url').textContent.trim().replace(/\/+$/, '');
  
  const response = await fetch(`${baseUrl}/transaksi/${transactionId}/bukti-pembayaran`, {
    method: 'POST',
    body: formData
  });

  const result = await response.json();
  console.log(result);

  if (response.ok) {
    alert('Upload berhasil!');
  } else {
    alert('Upload gagal: ' + result.message);
  }
} catch (err) {
  console.error('Error:', err);
  alert('Terjadi kesalahan saat upload');
}
}
    </script>
@endsection
