<?php
// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'payment_system';

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];
$name_on_card = $_POST['name_on_card'];
$card_number = $_POST['card_number'];
$exp_month = $_POST['exp_month'];
$exp_year = $_POST['exp_year'];
$cvv = $_POST['cvv'];

// Simpan data ke database
$sql = "INSERT INTO payments (full_name, email, address, city, state, zip_code, name_on_card, card_number, exp_month, exp_year, cvv)
        VALUES ('$full_name', '$email', '$address', '$city', '$state', '$zip_code', '$name_on_card', '$card_number', '$exp_month', '$exp_year', '$cvv')";

if ($conn->query($sql) === TRUE) {
    echo "Payment data saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


// Tutup koneksi
$conn->close();
?>
