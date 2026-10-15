<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .result {
            margin-top: 20px;
            font-weight: bold;
            color: #ff6600;
        }
    </style>
</head>

<body>

    <h2>Search Form (GET)</h2>
    <form method="GET" action="search.php">
        <label for="q">Search Keyword:</label>
        <input type="text" id="q" name="q" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
        <button type="submit">Search</button>
    </form>

    <?php
    if (isset($_GET['q'])) {
        $searchKeyword = trim($_GET['q']);
        if (!empty($searchKeyword)) {
            echo '<div class="result">Search result for: ' . htmlspecialchars($searchKeyword) . '</div>';
        }
    }
    ?>

</body>

</html>
```[cite: 15]

---

### File 2: `register.php` (Registration Form, Validation, Object, Session, Cookie)
This file handles the complete POST registration workflow, rigorous PHP validation, error display, form value retention,
object instantiation, session saving, and cookie creation[cite: 15, 16, 17].

```php
<?php
session_start();

// Define User Registration Object Class
class UserRegistration
{
    public $name;
    public $email;
    public $mobile;
    public $governorate;
    public $track;
    public $skills;
    public $message;

    public function __construct($name, $email, $mobile, $governorate, $track, $skills, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->governorate = $governorate;
        $this->track = $track;
        $this->skills = $skills;
        $this->message = $message;
    }
}

// Initialize variables
$name = $email = $mobile = $governorate = $track = $message = "";
$skills = [];
$terms = false;
$errors = [];
$successMessage = "";
$registeredObject = null;

// Check if cookie exists for pre-filling
$cookieTrack = isset($_COOKIE['user_track']) ? $_COOKIE['user_track'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1 & 2. Collect and clean data using trim()
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $governorate = trim($_POST['governorate'] ?? '');
    $track = $_POST['track'] ?? '';
    $skills = $_POST['skills'] ?? [];
    $message = trim($_POST['message'] ?? '');
    $terms = isset($_POST['terms']);

    // 3 & 4. Validate all required fields and record errors
    if (empty($name)) {
        $errors['name'] = "Full Name is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($mobile)) {
        $errors['mobile'] = "Mobile number is required.";
    } elseif (!preg_match('/^[0-9+\-\s()]{8,15}$/', $mobile)) {
        $errors['mobile'] = "Invalid mobile format.";
    }

    if (empty($governorate)) {
        $errors['governorate'] = "Please select a governorate.";
    }

    if (empty($track)) {
        $errors['track'] = "One track option must be selected.";
    }

    if (empty($skills)) {
        $errors['skills'] = "At least one skill should be selected.";
    }

    if (!$terms) {
        $errors['terms'] = "You must accept the Terms & Conditions.";
    }

    // 6. If everything is valid, process registration
    if (empty($errors)) {
        // Create User Object
        $registeredObject = new UserRegistration($name, $email, $mobile, $governorate, $track, $skills, $message);

        // Save in Session
        $_SESSION['user_data'] = [
            'name' => $registeredObject->name,
            'email' => $registeredObject->email,
            'mobile' => $registeredObject->mobile,
            'governorate' => $registeredObject->governorate,
            'track' => $registeredObject->track,
            'skills' => $registeredObject->skills,
            'message' => $registeredObject->message
        ];

        // Save Track in Cookie (expires in 30 days)
        setcookie('user_track', $track, time() + (86400 * 30), "/");

        $successMessage = "Registration successful! Data saved to Object and Session.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            line-height: 1.5;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 2px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            max-width: 400px;
            padding: 8px;
            box-sizing: border-box;
        }

        textarea {
            height: 80px;
        }

        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .object-box {
            background: #f4f4f4;
            padding: 15px;
            border-left: 4px solid #ff6600;
            max-width: 400px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h2>Registration Form (POST)</h2>

    <?php if (!empty($successMessage)): ?>
        <div class="success"><?php echo $successMessage; ?></div>
        <p><a href="profile.php">Go to Profile Page (Session & Cookie View)</a></p>
    <?php endif; ?>

    <!-- 3. Form must use POST -->
    <form method="POST" action="register.php">

        <!-- Full Name -->
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?php echo $errors['name']; ?></div><?php endif; ?>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?php echo $errors['email']; ?></div><?php endif; ?>
        </div>

        <!-- Mobile -->
        <div class="form-group">
            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($mobile); ?>">
            <?php if (isset($errors['mobile'])): ?>
                <div class="error"><?php echo $errors['mobile']; ?></div><?php endif; ?>
        </div>

        <!-- Governorate -->
        <div class="form-group">
            <label for="governorate">Governorate:</label>
            <select id="governorate" name="governorate">
                <option value="">-- Select Governorate --</option>
                <option value="Amman" <?php if ($governorate == 'Amman')
                    echo 'selected'; ?>>Amman</option>
                <option value="Irbid" <?php if ($governorate == 'Irbid')
                    echo 'selected'; ?>>Irbid</option>
                <option value="Zarqa" <?php if ($governorate == 'Zarqa')
                    echo 'selected'; ?>>Zarqa</option>
                <option value="Aqaba" <?php if ($governorate == 'Aqaba')
                    echo 'selected'; ?>>Aqaba</option>
            </select>
            <?php if (isset($errors['governorate'])): ?>
                <div class="error"><?php echo $errors['governorate']; ?></div><?php endif; ?>
        </div>

        <!-- Track -->
        <div class="form-group">
            <label>Track:</label>
            <input type="radio" name="track" value="Full Stack" <?php if ($track == 'Full Stack' || (!empty($cookieTrack) && empty($track) && $cookieTrack == 'Full Stack'))
                echo 'checked'; ?>> Full Stack<br>
            <input type="radio" name="track" value="Front End" <?php if ($track == 'Front End' || (!empty($cookieTrack) && empty($track) && $cookieTrack == 'Front End'))
                echo 'checked'; ?>> Front End<br>
            <input type="radio" name="track" value="Back End" <?php if ($track == 'Back End' || (!empty($cookieTrack) && empty($track) && $cookieTrack == 'Back End'))
                echo 'checked'; ?>> Back End
            <?php if (isset($errors['track'])): ?>
                <div class="error"><?php echo $errors['track']; ?></div><?php endif; ?>
        </div>

        <!-- Skills -->
        <div class="form-group">
            <label>Skills:</label>
            <input type="checkbox" name="skills[]" value="HTML" <?php if (in_array('HTML', $skills))
                echo 'checked'; ?>>
            HTML<br>
            <input type="checkbox" name="skills[]" value="CSS" <?php if (in_array('CSS', $skills))
                echo 'checked'; ?>>
            CSS<br>
            <input type="checkbox" name="skills[]" value="JavaScript" <?php if (in_array('JavaScript', $skills))
                echo 'checked'; ?>> JavaScript<br>
            <input type="checkbox" name="skills[]" value="PHP" <?php if (in_array('PHP', $skills))
                echo 'checked'; ?>>
            PHP
            <?php if (isset($errors['skills'])): ?>
                <div class="error"><?php echo $errors['skills']; ?></div><?php endif; ?>
        </div>

        <!-- Message -->
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message"><?php echo htmlspecialchars($message); ?></textarea>
        </div>

        <!-- Terms & Conditions -->
        <div class="form-group">
            <input type="checkbox" id="terms" name="terms" <?php if ($terms)
                echo 'checked'; ?>>
            <label for="terms" style="display:inline;">I accept the Terms & Conditions</label>
            <?php if (isset($errors['terms'])): ?>
                <div class="error"><?php echo $errors['terms']; ?></div><?php endif; ?>
        </div>

        <!-- Register Button -->
        <button type="submit">Register</button>
    </form>

    <?php if ($registeredObject !== null): ?>
        <div class="object-box">
            <h3>Registered Object Data:</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($registeredObject->name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($registeredObject->email); ?></p>
            <p><strong>Mobile:</strong> <?php echo htmlspecialchars($registeredObject->mobile); ?></p>
            <p><strong>Governorate:</strong> <?php echo htmlspecialchars($registeredObject->governorate); ?></p>
            <p><strong>Track:</strong> <?php echo htmlspecialchars($registeredObject->track); ?></p>
            <p><strong>Skills:</strong> <?php echo htmlspecialchars(implode(', ', $registeredObject->skills)); ?></p>
            <p><strong>Message:</strong> <?php echo htmlspecialchars($registeredObject->message); ?></p>
        </div>
    <?php endif; ?>

</body>

</html>
```[cite: 15, 16, 17]

---

### File 3: `profile.php` (Session & Cookie Display Page)
This page retrieves and displays the user's registration data from the PHP session and pre-fills/displays information
stored in cookies[cite: 17].

```php
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile (Session & Cookie)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
        }

        .box {
            background: #f9f9f9;
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 500px;
            border-radius: 5px;
        }

        h2 {
            color: #ff6600;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>User Profile Page</h2>

        <?php if (isset($_SESSION['user_data'])): ?>
            <h3>Data Retrieved from PHP Session:</h3>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($_SESSION['user_data']['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_data']['email']); ?></p>
            <p><strong>Mobile:</strong> <?php echo htmlspecialchars($_SESSION['user_data']['mobile']); ?></p>
            <p><strong>Governorate:</strong> <?php echo htmlspecialchars($_SESSION['user_data']['governorate']); ?></p>
            <p><strong>Track:</strong> <?php echo htmlspecialchars($_SESSION['user_data']['track']); ?></p>
            <p><strong>Skills:</strong> <?php echo htmlspecialchars(implode(', ', $_SESSION['user_data']['skills'])); ?></p>
            <p><strong>Message:</strong> <?php echo htmlspecialchars($_SESSION['user_data']['message']); ?></p>
        <?php else: ?>
            <p>No active user session found. Please register first at <a href="register.php">register.php</a>.</p>
        <?php endif; ?>

        <hr style="margin: 20px 0;">

        <h3>Data Retrieved from Cookie:</h3>
        <?php if (isset($_COOKIE['user_track'])): ?>
            <p>Saved Preferred Track in Cookie: <strong><?php echo htmlspecialchars($_COOKIE['user_track']); ?></strong></p>
        <?php else: ?>
            <p>No track cookie found.</p>
        <?php endif; ?>

        <p><a href="register.php">Back to Registration Form</a></p>
    </div>

</body>

</html>