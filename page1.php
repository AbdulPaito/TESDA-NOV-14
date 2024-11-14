<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Define required fields
    $requiredFields = [
        'uli_number', 
        'entry_date', 
        'last_name', 
        'first_name', 
        'middle_name', 
        'address_number_street', 
        'address_barangay', 
        'address_district', 
        'address_city_municipality', 
        'address_province', 
        'address_region', 
        'email_facebook', 
        'contact_no', 
        'nationality'
    ];

    // Check if all required fields are present and not empty
    $isValid = true;
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $isValid = false;
            $_SESSION['errors'][$field] = 'This field is required.';
        } else {
            $_SESSION['errors'][$field] = '';
        }
    }

    if (!$isValid) {
        header('Location: page1.php'); // Redirect back to the form page
        exit();
    }




    
    // Save form data into session variables
    $_SESSION['uli_number'] = $_POST['uli_number'];
    $_SESSION['entry_date'] = $_POST['entry_date'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['middle_name'] = $_POST['middle_name'];
    $_SESSION['address_number_street'] = $_POST['address_number_street'];
    $_SESSION['address_barangay'] = $_POST['address_barangay'];
    $_SESSION['address_district'] = $_POST['address_district'];
    $_SESSION['address_city_municipality'] = $_POST['address_city_municipality'];
    $_SESSION['address_province'] = $_POST['address_province'];
    $_SESSION['address_region'] = $_POST['address_region'];
    $_SESSION['email_facebook'] = $_POST['email_facebook'];
    $_SESSION['contact_no'] = $_POST['contact_no'];
    $_SESSION['nationality'] = $_POST['nationality'];

    // Handle file uploads
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $uploadedFile = $_FILES['profile_image'];
        $uploadDir = 'Upload-image/'; // Ensure this directory exists and is writable
        $uploadFile = $uploadDir . basename($uploadedFile['name']);

        // Validate file type
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            exit();
        }

        // Validate file size (limit to 500KB)
        if ($uploadedFile['size'] > 500000) {
            echo 'Sorry, your file is too large.';
            exit();
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($uploadedFile['tmp_name'], $uploadFile)) {
            $_SESSION['profile_image'] = $uploadFile; // Save file path to session
        } else {
            echo 'File upload failed!';
            exit();
        }
    }

    header('Location: page2.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form - Page 1</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f9;
        }

        .page {
            max-width: auto; /* Adjust as needed */
            height: auto;
            margin: 0 auto;
            padding: 60px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden; /* Prevents overflow from breaking layout */
           
        }

        h2, h1, p {
            text-align: center;
            margin-bottom: 10px;
        }

        form {
            width: 100%;
            margin-top: 20px; /* Provides space between headings and form */
        }

        .image-upload-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-bottom: 2px;
        }

        .image-preview {
            width: 140px;
            height: 120px;
            border: 1px solid #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            margin-top: 10px;
            overflow: hidden;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
        }

        .image-upload-label {
            cursor: pointer;
            height: 0px;
            position: relative;
            top: -30px;
            font-size: 15px;
            text-align: center;
            color: #007bff;
            text-decoration: underline;
        }

        table {
        border-collapse: collapse;
        margin: 0 auto 20px; /* Center the table horizontally */
        width: auto;
   
        }
        
        .tab2{
          text-align: center;
          width: 1000px;
        }

        th, td {
            padding: 3px; /* Adjust the padding size as needed */
            height: 10px;
            border: 1px solid #007bff;
            font-size: 20px;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        td input[type="text"] {
            width: calc(100% - 16px); /* Adjust width to fit table without overflow */
            padding: 6px;
            width: auto;
            border: 1px solid black;
            border-radius: 4px;
            margin-top: 5px;
        }

        .center {
            text-align: center;
            margin-top: 20px; /* Provides space for button */
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
       

        @media (max-width: 768px) {
            .page {
                padding: 20px; /* Adjust padding for smaller screens */
            }

            th, td {
                font-size: 14px;
            }

            button[type="submit"] {
                width: 100%;
                padding: 12px;
            }
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
           
        }

        .header-container img {
            width: 130px; /* Adjust the width as needed */
            height: auto;
        }

        .page {
            max-width: 100%;
            height: auto;
            margin: 10px;
            padding: 1px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden; /* Prevents overflow from breaking layout */
        }

        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                align-items: center;
            }

            .header-container img {
                margin-bottom: 10px;
            }
        }
       
    </style>
</head>
<body>
    <div class="page">
    <div class="header-container">
        <img src="Logo-TESDA.jpg" alt="Left Logo">
    <div><h1>Technical Education and Skills Development Authority</h1>
        <h1>Pangasiwaan sa Edukasyong Teknikal at Pagpapaunlad ng Kasanayan</h1>
        <h1>Registration Form - Page 1/4</h1></div>
        <img src="images.jpg" alt="Right Logo">
    </div>
        <form action="" method="post" enctype="multipart/form-data">
        <table class="tab1">
                <tr>
                    <th colspan="2" class="learner">LEARNERS PROFILE FORM</th>
                </tr>
                <tr>
                <td> <div class="image-upload-container">
                <div class="image-preview" id="imagePreview">
                    <?php if (isset($_SESSION['profile_image'])): ?>
                        <img src="<?= $_SESSION['profile_image'] ?>" alt="Profile Image">
                    <?php else: ?>
                        <span>I.D Picture</span>
                        <?php endif; ?>
                    </div>
                    <label class="image-upload-label" for="profile_image">Choose Image</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                   </div></td>
                    <td> 1.1. Unique Learner Identifier (ULI) Number:          
                    <input type="text" name="uli_number" placeholder="(ULI) Number" value="<?= isset($_SESSION['uli_number']) ? htmlspecialchars($_SESSION['uli_number']) : '' ?>">
                    Entry Date:
                    <input type="date" name="entry_date" size="10" placeholder="mm-dd-yy" value="<?= isset($_SESSION['entry_date']) ? htmlspecialchars($_SESSION['entry_date']) : '' ?>"><br>
                     2.1. Name:
                        <input type="text" name="last_name" size="15" placeholder="Last Name, Extension Name (Jr., Sr.)" value="<?= isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : '' ?>">
                        <input type="text" name="first_name" size="15" placeholder="First Name" value="<?= isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : '' ?>">
                        <input type="text" name="middle_name" size="15" placeholder="Middle Name" value="<?= isset($_SESSION['middle_name']) ? htmlspecialchars($_SESSION['middle_name']) : '' ?>">
                    </td>
                </tr>
          <tr>
                    <th colspan="2" >2.2. Complete Permanent Mailing Address:</th>
                </tr>
                    
                
                    <tr>
                        <td colspan="2" class="tab2">
                        <select id="address_city_municipality" name="address_city_municipality" onchange="updateBarangays()">
                        <option value="">Select City/Municipality</option>
                        <option value="Arayat">Arayat</option>
                        <option value="San Vicente">San Vicente</option>
                        <option value="Cabiao">Cabiao</option>
                        <option value="Magalang">Magalang</option>
                        <option value="Magalang">Magalang</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Santa Ana">Santa Ana</option>
                        <option value="San Fernando">San Fernando</option>
                        <option value="Candaba">Candaba</option>
                    </select>


                <select id="address_barangay" name="address_barangay" onchange="updateStreets()" disabled>
                    <option value="">Select Barangay</option>
                    <!-- Barangay options will be populated dynamically -->
                </select>

                <select id="address_number_street" name="address_number_street" onchange="updateDistricts()" disabled>
                    <option value="">Select Number, Street</option>
                    <!-- Number and Street options will be populated dynamically -->
                </select>
                <select id="address_district" name="address_district" onchange="updateProvinces()" disabled>
                    <option value="">Select District</option>
                    <!-- District options will be populated dynamically -->
                </select>
                <select id="address_province" name="address_province" onchange="updateRegions()" disabled>
                    <option value="">Select Province</option>
                    <!-- Province options will be populated dynamically -->
                </select>
                <select id="address_region" name="address_region" onchange="updateNationalities()" disabled>
                    <option value="">Select Region</option>
                    <!-- Region options will be populated dynamically -->
                </select>
                <select id="nationality" name="nationality" disabled>
                    <option value="">Select Nationality</option>
                    <!-- Nationality options will be populated dynamically -->
                </select><br>
                <input type="text" name="email_facebook" size="20" placeholder="Email Address/Facebook Account" value="<?= isset($_SESSION['email_facebook']) ? htmlspecialchars($_SESSION['email_facebook']) : '' ?>">
                <input type="text" name="contact_no" size="20" placeholder="Contact No" value="<?= isset($_SESSION['contact_no']) ? htmlspecialchars($_SESSION['contact_no']) : '' ?>">
                        </td>


                    </tr>
                
            </td>
                </tr>
            </table>
            <div class="center">
                <button type="submit">Next</button>
            </div>
        </form>
    </div>
    <script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imagePreview');
            output.innerHTML = `<img src="${reader.result}" alt="Profile Image">`;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    </script>


<script>

const data = {
    'Arayat': {
        barangays: [
            'Arenas', 'Baliti', 'Batasan', 'Buensuceso', 'Candating', 'Gatiawin', 
            'Guemasan', 'La Paz (Turu)', 'Lacmit', 'Lacquios', 'Mangga-Cacutud', 
            'Mapalad', 'Panlinlang', 'Paralaya', 'Plazang Luma', 'Poblacion', 
            'San Agustin Norte', 'San Agustin Sur', 'San Antonio', 'San Jose Mesulo', 
            'San Juan Bano', 'San Mateo', 'San Nicolas', 'San Roque Bitas', 
            'Cupang (Santa Lucia)', 'Matamo (Santa Lucia)', 'Santo Niño Tabuan', 
            'Suclayin', 'Telapayong', 'Kaledian (Camba)'
        ],
        streets: [
            'Street 1', 'Street 2', 'Street 3', 'Street 4', 'Street 5', 'Street 6', 
            'Street 7', 'Street 8', 'Street 9', 'Street 10', 'Street 11', 'Street 12', 
            'Street 13', 'Street 14', 'Street 15', 'Street 16', 'Street 17', 'Street 18', 
            'Street 19', 'Street 20'
        ],
        districts: [
            'District 1', 'District 2', 'District 3', 'District 4', 'District 5', 
            'District 6', 'District 7', 'District 8', 'District 9', 'District 10', 
            'District 11', 'District 12', 'District 13', 'District 14', 'District 15', 
            'District 16', 'District 17', 'District 18', 'District 19', 'District 20'
        ],
        provinces: [
            'Pampanga'
        ],
        regions: [
            'Region 1', 'Region 2', 'Region 3', 'Region 4', 'Region 5', 
            'Region 6', 'Region 7', 'Region 8', 'Region 9', 'Region 10', 
            'Region 11', 'Region 12', 'Region 13', 'Region 14', 'Region 15', 
            'Region 16', 'Region 17', 'Region 18'
        ],
        nationalities: ['Filipino', 'Chinese', 'Japanese', 'Korean', 'Foreigner', 'American', 
            'British', 'Australian', 'Canadian', 'German', 'French', 'Italian', 
            'Russian', 'Indian', 'Mexican', 'Brazilian', 'Thai', 'Indonesian', 
            'Vietnamese', 'South African']
    },
    'San Vicente': {
        barangays: [
            'Aplaya', 'Bagong Sikat', 'Bunga', 'Calabangan', 'Catug-a', 'Concepcion',
            'Dalan Bago', 'Dapdap', 'Gapan', 'Iba', 'Labi', 'Lakas', 'Labi-Labi', 
            'Lagundian', 'Ligtong', 'Magsaysay', 'Maligaya', 'Magsaysay Norte', 'Pias',
            'San Jose', 'San Vicente', 'Santo Domingo', 'Santo Niño', 'Silangan', 'Suyoc'
        ],
        streets: [
            'Street 1', 'Street 2', 'Street 3', 'Street 4', 'Street 5', 'Street 6', 
            'Street 7', 'Street 8', 'Street 9', 'Street 10', 'Street 11', 'Street 12', 
            'Street 13', 'Street 14', 'Street 15', 'Street 16', 'Street 17', 'Street 18', 
            'Street 19', 'Street 20'
        ],
        districts: [
            'District 1', 'District 2', 'District 3', 'District 4', 'District 5', 
            'District 6', 'District 7', 'District 8', 'District 9', 'District 10', 
            'District 11', 'District 12', 'District 13', 'District 14', 'District 15', 
            'District 16', 'District 17', 'District 18', 'District 19', 'District 20'
        ],
        provinces: [
            'Nueva Ecija'
        ],
        regions: [
            'Region 1', 'Region 2', 'Region 3', 'Region 4', 'Region 5', 
            'Region 6', 'Region 7', 'Region 8', 'Region 9', 'Region 10', 
            'Region 11', 'Region 12', 'Region 13', 'Region 14', 'Region 15', 
            'Region 16', 'Region 17', 'Region 18'
        ],
        nationalities: ['Filipino', 'Chinese', 'Japanese', 'Korean', 'Foreigner', 'American', 
            'British', 'Australian', 'Canadian', 'German', 'French', 'Italian', 
            'Russian', 'Indian', 'Mexican', 'Brazilian', 'Thai', 'Indonesian', 
            'Vietnamese', 'South African']
    },
    'Cabiao': {
        barangays: [
            'Bagong Buhay ("Lote")', 'Bagong Sikat', 'Bagong Silang', 'Concepcion', 'Entablado', 
            'Maligaya', 'Natividad North (Pob.)', 'Natividad South (Pob.)', 'Palasinan', 
            'San Antonio ("Pantalan")', 'San Fernando Norte', 'San Fernando Sur', 'San Gregorio',
            'San Juan North (Pob.)', 'San Juan South (Pob.)', 'San Roque', 'San Vicente', 
            'Santa Rita', 'Sinipit', 'Polilio', 'San Carlos', 'Santa Isabel', 'Santa Ines'
        ],
        streets: [
            'Street 1', 'Street 2', 'Street 3', 'Street 4', 'Street 5', 'Street 6', 
            'Street 7', 'Street 8', 'Street 9', 'Street 10', 'Street 11', 'Street 12', 
            'Street 13', 'Street 14', 'Street 15', 'Street 16', 'Street 17', 'Street 18', 
            'Street 19', 'Street 20'
        ],
        districts: [
            'District 1', 'District 2', 'District 3', 'District 4', 'District 5', 
            'District 6', 'District 7', 'District 8', 'District 9', 'District 10', 
            'District 11', 'District 12', 'District 13', 'District 14', 'District 15', 
            'District 16', 'District 17', 'District 18', 'District 19', 'District 20'
        ],
        provinces: [
            'Nueva Ecija'
        ],
        regions: [
            'Region 1', 'Region 2', 'Region 3', 'Region 4', 'Region 5', 
            'Region 6', 'Region 7', 'Region 8', 'Region 9', 'Region 10', 
            'Region 11', 'Region 12', 'Region 13', 'Region 14', 'Region 15', 
            'Region 16', 'Region 17', 'Region 18'
        ],
        nationalities: ['Filipino', 'Chinese', 'Japanese', 'Korean', 'Foreigner', 'American', 
            'British', 'Australian', 'Canadian', 'German', 'French', 'Italian', 
            'Russian', 'Indian', 'Mexican', 'Brazilian', 'Thai', 'Indonesian', 
            'Vietnamese', 'South African']
    },
    'Magalang': {
        barangays: [
            'Amsic', 'Ayala', 'Bagong Sikat', 'Bano', 'Bulaon', 'Calumpang', 'Cutud', 
            'Del Carmen', 'Dela Paz', 'Gugo', 'Laug', 'Longos', 'Macabulos', 'Magsaysay',
            'Mamag', 'Pandacaqui', 'Poblacion', 'San Agustin', 'San Isidro', 'San Jose',
            'San Pedro', 'Santo Domingo', 'Santo Rosario', 'Sapang Maisac', 'San Vicente'
        ],
        streets: [
            'Street 1', 'Street 2', 'Street 3', 'Street 4', 'Street 5', 'Street 6', 
            'Street 7', 'Street 8', 'Street 9', 'Street 10', 'Street 11', 'Street 12', 
            'Street 13', 'Street 14', 'Street 15', 'Street 16', 'Street 17', 'Street 18', 
            'Street 19', 'Street 20'
        ],
        districts: [
           'District 1', 'District 2', 'District 3', 'District 4', 'District 5', 
            'District 6', 'District 7', 'District 8', 'District 9', 'District 10', 
            'District 11', 'District 12', 'District 13', 'District 14', 'District 15', 
            'District 16', 'District 17', 'District 18', 'District 19', 'District 20'
        ],
        provinces: [
            'Pampanga'
        ],
        regions: [
           'Region 1', 'Region 2', 'Region 3', 'Region 4', 'Region 5', 
            'Region 6', 'Region 7', 'Region 8', 'Region 9', 'Region 10', 
            'Region 11', 'Region 12', 'Region 13', 'Region 14', 'Region 15', 
            'Region 16', 'Region 17', 'Region 18'
        ],
        nationalities: ['Filipino', 'Chinese', 'Japanese', 'Korean', 'Foreigner', 'American', 
            'British', 'Australian', 'Canadian', 'German', 'French', 'Italian', 
            'Russian', 'Indian', 'Mexican', 'Brazilian', 'Thai', 'Indonesian', 
            'Vietnamese', 'South African']
    },
    'Mexico': {
        barangays: [
           'Bagong Bario', 'Bulaon', 'Calumpang', 'Dela Paz', 'Del Rosario', 'Lagundi', 
           'Longos', 'Magalang', 'Mabalacat', 'Matapat', 'Magsaysay', 'San Antonio',
            'San Jose', 'San Miguel', 'San Vicente', 'Santa Monica', 'Santo Niño', 
            'Santo Rosario'
        ],
        streets: [
            'Street 1', 'Street 2', 'Street 3', 'Street 4', 'Street 5', 'Street 6', 
            'Street 7', 'Street 8', 'Street 9', 'Street 10', 'Street 11', 'Street 12', 
            'Street 13', 'Street 14', 'Street 15', 'Street 16', 'Street 17', 'Street 18', 
            'Street 19', 'Street 20'
        ],
        districts: [
            'District 1', 'District 2', 'District 3', 'District 4', 'District 5', 
            'District 6', 'District 7', 'District 8', 'District 9', 'District 10', 
            'District 11', 'District 12', 'District 13', 'District 14', 'District 15', 
            'District 16', 'District 17', 'District 18', 'District 19', 'District 20'
        ],
        provinces: [
            'Pampanga'
        ],
        regions: [
           'Region 1', 'Region 2', 'Region 3', 'Region 4', 'Region 5', 
            'Region 6', 'Region 7', 'Region 8', 'Region 9', 'Region 10', 
            'Region 11', 'Region 12', 'Region 13', 'Region 14', 'Region 15', 
            'Region 16', 'Region 17', 'Region 18'
        ],
        nationalities: ['Filipino', 'Chinese', 'Japanese', 'Korean', 'Foreigner', 'American', 
            'British', 'Australian', 'Canadian', 'German', 'French', 'Italian', 
            'Russian', 'Indian', 'Mexican', 'Brazilian', 'Thai', 'Indonesian', 
            'Vietnamese', 'South African']
 },
    'Santa Ana': {
        barangays: [
            'Babo Pangulo', 'Bagumbayan', 'Bulaon', 'Dela Paz', 'Dulong Bayan', 
            'Lubao', 'Manibaug', 'Pambuan', 'Poblacion', 'San Antonio', 'San Pedro', 
            'San Vicente', 'Santa Cruz', 'Santa Rita', 'Santo Domingo'
        ],
        streets: [
           'Street 1', 'Street 2', 'Street 3', 'Street 4', 'Street 5', 'Street 6', 
            'Street 7', 'Street 8', 'Street 9', 'Street 10', 'Street 11', 'Street 12', 
            'Street 13', 'Street 14', 'Street 15', 'Street 16', 'Street 17', 'Street 18', 
            'Street 19', 'Street 20'
        ],
        districts: [
            'District 1', 'District 2', 'District 3', 'District 4', 'District 5', 
            'District 6', 'District 7', 'District 8', 'District 9', 'District 10', 
            'District 11', 'District 12', 'District 13', 'District 14', 'District 15', 
            'District 16', 'District 17', 'District 18', 'District 19', 'District 20'
        ],
        provinces: [
            'Pampanga'
        ],
        regions: [
            'Region 1', 'Region 2', 'Region 3', 'Region 4', 'Region 5', 
            'Region 6', 'Region 7', 'Region 8', 'Region 9', 'Region 10', 
            'Region 11', 'Region 12', 'Region 13', 'Region 14', 'Region 15', 
            'Region 16', 'Region 17', 'Region 18'
        ],
        nationalities: ['Filipino', 'Chinese', 'Japanese', 'Korean', 'Foreigner', 'American', 
            'British', 'Australian', 'Canadian', 'German', 'French', 'Italian', 
            'Russian', 'Indian', 'Mexican', 'Brazilian', 'Thai', 'Indonesian', 
            'Vietnamese', 'South African']
    },
    'San Fernando': {
        barangays: [
            'Baliti', 'Bulaon', 'Del Pilar', 'Dolores', 'Dela Paz Norte', 'Dela Paz Sur',
             'Guembe', 'Lagundian', 'San Agustin', 'San Isidro', 'San Jose', 'San Juan', 
             'San Nicolas', 'Santo Rosario', 'San Pedro', 'San Vicente', 'Santo Tomas',
              'Santa Lucia', 'Santa Teresita'
        ],
        streets: [
          'Street 1', 'Street 2', 'Street 3', 'Street 4', 'Street 5', 'Street 6', 
            'Street 7', 'Street 8', 'Street 9', 'Street 10', 'Street 11', 'Street 12', 
            'Street 13', 'Street 14', 'Street 15', 'Street 16', 'Street 17', 'Street 18', 
            'Street 19', 'Street 20'
        ],
        districts: [
            'District 1', 'District 2', 'District 3', 'District 4', 'District 5', 
            'District 6', 'District 7', 'District 8', 'District 9', 'District 10', 
            'District 11', 'District 12', 'District 13', 'District 14', 'District 15', 
            'District 16', 'District 17', 'District 18', 'District 19', 'District 20'
        ],
        provinces: [
            'Pampanga'
        ],
        regions: [
            'Region 1', 'Region 2', 'Region 3', 'Region 4', 'Region 5', 
            'Region 6', 'Region 7', 'Region 8', 'Region 9', 'Region 10', 
            'Region 11', 'Region 12', 'Region 13', 'Region 14', 'Region 15', 
            'Region 16', 'Region 17', 'Region 18'
        ],
        nationalities: ['Filipino', 'Chinese', 'Japanese', 'Korean', 'Foreigner', 'American', 
            'British', 'Australian', 'Canadian', 'German', 'French', 'Italian', 
            'Russian', 'Indian', 'Mexican', 'Brazilian', 'Thai', 'Indonesian', 
            'Vietnamese', 'South African']
    },
    'Candaba': {
        barangays: [
            'Abar 1st', 'Abar 2nd', 'Bacolor', 'Bagang', 'Banga', 'Bulaon', 'Calumpang',
             'Concepcion', 'Dela Paz', 'Del Rosario', 'Dolores', 'Laoang', 'Longos',
              'Mangga', 'Mangunang', 'Masamat', 'Minalin', 'Paguet', 'Poblacion',
            'San Antonio', 'San Bartolome', 'San Isidro', 'San Jose', 'San Luis',
             'San Pedro', 'San Vicente', 'Santo Niño', 'Santo Rosario', 'Santa Teresita'
        ],
        streets: [
            'Street 1', 'Street 2', 'Street 3', 'Street 4', 'Street 5', 'Street 6', 
            'Street 7', 'Street 8', 'Street 9', 'Street 10', 'Street 11', 'Street 12', 
            'Street 13', 'Street 14', 'Street 15', 'Street 16', 'Street 17', 'Street 18', 
            'Street 19', 'Street 20'
        ],
        districts: [
            'District 1', 'District 2', 'District 3', 'District 4', 'District 5', 
            'District 6', 'District 7', 'District 8', 'District 9', 'District 10', 
            'District 11', 'District 12', 'District 13', 'District 14', 'District 15', 
            'District 16', 'District 17', 'District 18', 'District 19', 'District 20'
        ],
        provinces: [
            'Pampanga'
        ],
        regions: [
            'Region 1', 'Region 2', 'Region 3', 'Region 4', 'Region 5', 
            'Region 6', 'Region 7', 'Region 8', 'Region 9', 'Region 10', 
            'Region 11', 'Region 12', 'Region 13', 'Region 14', 'Region 15', 
            'Region 16', 'Region 17', 'Region 18'
        ],
        nationalities: ['Filipino', 'Chinese', 'Japanese', 'Korean', 'Foreigner', 'American', 
            'British', 'Australian', 'Canadian', 'German', 'French', 'Italian', 
            'Russian', 'Indian', 'Mexican', 'Brazilian', 'Thai', 'Indonesian', 
            'Vietnamese', 'South African']
    }
};

function updateBarangays() {
    const citySelect = document.getElementById('address_city_municipality');
    const barangaySelect = document.getElementById('address_barangay');
    const selectedCity = citySelect.value;

    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
    document.getElementById('address_number_street').innerHTML = '<option value="">Select Number, Street</option>';
    document.getElementById('address_district').innerHTML = '<option value="">Select District</option>';
    document.getElementById('address_province').innerHTML = '<option value="">Select Province</option>';
    document.getElementById('address_region').innerHTML = '<option value="">Select Region</option>';
    document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

    document.getElementById('address_number_street').disabled = true;
    document.getElementById('address_district').disabled = true;
    document.getElementById('address_province').disabled = true;
    document.getElementById('address_region').disabled = true;
    document.getElementById('nationality').disabled = true;

    if (selectedCity) {
        barangaySelect.disabled = false;
        const barangays = data[selectedCity].barangays;

        barangays.forEach(barangay => {
            const option = document.createElement('option');
            option.value = barangay;
            option.text = barangay;
            barangaySelect.appendChild(option);
        });
    } else {
        barangaySelect.disabled = true;
    }
}

function updateStreets() {
    const citySelect = document.getElementById('address_city_municipality');
    const barangaySelect = document.getElementById('address_barangay');
    const streetSelect = document.getElementById('address_number_street');
    const selectedCity = citySelect.value;
    const selectedBarangay = barangaySelect.value;

    streetSelect.innerHTML = '<option value="">Select Number, Street</option>';
    document.getElementById('address_district').innerHTML = '<option value="">Select District</option>';
    document.getElementById('address_province').innerHTML = '<option value="">Select Province</option>';
    document.getElementById('address_region').innerHTML = '<option value="">Select Region</option>';
    document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

    document.getElementById('address_number_street').disabled = true;
    document.getElementById('address_district').disabled = true;
    document.getElementById('address_province').disabled = true;
    document.getElementById('address_region').disabled = true;
    document.getElementById('nationality').disabled = true;

    if (['Arayat', 'San Vicente', 'Cabiao', 'Magalang',  'Mexico', 'Santa Ana', 'San Fernando', 'Candaba'].includes(selectedCity)) {
        streetSelect.disabled = false;
        data[selectedCity].streets.forEach(street => {
            const option = document.createElement('option');
            option.value = street;
            option.text = street;
            streetSelect.appendChild(option);
        });
    }
}

function updateDistricts() {
    const citySelect = document.getElementById('address_city_municipality');
    const districtSelect = document.getElementById('address_district');
    const selectedCity = citySelect.value;

    districtSelect.innerHTML = '<option value="">Select District</option>';
    document.getElementById('address_province').innerHTML = '<option value="">Select Province</option>';
    document.getElementById('address_region').innerHTML = '<option value="">Select Region</option>';
    document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

    document.getElementById('address_district').disabled = true;
    document.getElementById('address_province').disabled = true;
    document.getElementById('address_region').disabled = true;
    document.getElementById('nationality').disabled = true;

    if (['Arayat', 'San Vicente', 'Cabiao', 'Magalang', 'Mexico', 'Santa Ana', 'San Fernando', 'Candaba'].includes(selectedCity)) {
        districtSelect.disabled = false;
        data[selectedCity].districts.forEach(district => {
            const option = document.createElement('option');
            option.value = district;
            option.text = district;
            districtSelect.appendChild (option);
        });
    }
}

function updateProvinces() {
    const citySelect = document.getElementById('address_city_municipality');
    const provinceSelect = document.getElementById('address_province');
    const selectedCity = citySelect.value;

    provinceSelect.innerHTML = '<option value="">Select Province</option>';
    document.getElementById('address_region').innerHTML = '<option value="">Select Region</option>';
    document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

    document.getElementById('address_province').disabled = true;
    document.getElementById('address_region').disabled = true;
    document.getElementById('nationality').disabled = true;

    if (['Arayat','San Vicente', 'Cabiao', 'Magalang', 'Mexico', 'Santa Ana', 'San Fernando', 'Candaba'].includes(selectedCity)) {
        provinceSelect.disabled = false;
        data[selectedCity].provinces.forEach(province => {
            const option = document.createElement('option');
            option.value = province;
            option.text = province;
            provinceSelect.appendChild(option);
        });
    }
}

function updateRegions() {
    const citySelect = document.getElementById('address_city_municipality');
    const regionSelect = document.getElementById('address_region');
    const selectedCity = citySelect.value;

    regionSelect.innerHTML = '<option value="">Select Region</option>';
    document.getElementById('nationality').innerHTML = '<option value="">Select Nationality</option>';

    document.getElementById('address_region').disabled = true;
    document.getElementById('nationality').disabled = true;

    if (['Arayat', 'San Vicente', 'Cabiao', 'Magalang', 'Mexico', 'Santa Ana', 'San Fernando', 'Candaba'].includes(selectedCity)) {
        regionSelect.disabled = false;
        data[selectedCity].regions.forEach(region => {
            const option = document.createElement('option');
            option.value = region;
            option.text = region;
            regionSelect.appendChild(option);
        });
    }
}

function updateNationalities() {
    const citySelect = document.getElementById('address_city_municipality');
    const nationalitySelect = document.getElementById('nationality');
    const selectedCity = citySelect.value;

    nationalitySelect.innerHTML = '<option value="">Select Nationality</option>';

    document.getElementById('nationality').disabled = true;

    if (['Arayat', 'San Vicente', 'Cabiao', 'Magalang', 'Mexico', 'Santa Ana', 'San Fernando', 'Candaba'].includes(selectedCity)) {
        nationalitySelect.disabled = false;
        data[selectedCity].nationalities.forEach(nationality => {
            const option = document.createElement('option');
            option.value = nationality;
            option.text = nationality;
            nationalitySelect.appendChild(option);
        });
    }
}

</script>

<script>
document.querySelector('form').addEventListener('submit', function(event) {
    const requiredFields = [
        'uli_number', 
        'entry_date', 
        'last_name', 
        'first_name', 
        'middle_name', 
        'address_number_street', 
        'address_barangay', 
        'address_district', 
        'address_city_municipality', 
        'address_province', 
        'address_region', 
        'email_facebook', 
        'contact_no', 
        'nationality'
    ];

    let isValid = true;

    requiredFields.forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        if (input && !input.value) {
            isValid = false;
            input.style.border = '2px solid red'; // Highlight missing fields
        } else {
            if (input) input.style.border = ''; // Remove highlight if filled
        }
    });

    if (!isValid) {
        alert('Please fill in all required fields.');
        event.preventDefault(); // Prevent form submission if validation fails
    }
});
</script>


</body>
</html>