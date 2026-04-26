<?php
/**
 * Admin User Management Utility
 * This script helps create admin users and manage passwords
 * Run directly: php create_admin_utility.php
 */

include 'api/db_connect.php';

// Check if this is a CLI request or web request
$is_cli = php_sapi_name() === 'cli';

function create_admin_user($full_name, $email, $password, $conn) {
    $hashed_password = $password;
    
    $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'admin')";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        return "Error preparing statement: " . $conn->error;
    }
    
    $stmt->bind_param("sss", $full_name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        return "✓ Admin user created successfully!\n";
    } else {
        if (strpos($conn->error, 'Duplicate entry') !== false) {
            return "✗ Error: Email already exists in database.\n";
        }
        return "✗ Error creating admin user: " . $conn->error . "\n";
    }
}

function update_user_role_to_admin($email, $conn) {
    $sql = "UPDATE users SET role = 'admin' WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        return "Error preparing statement: " . $conn->error;
    }
    
    $stmt->bind_param("s", $email);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            return "✓ User role updated to admin successfully!\n";
        } else {
            return "✗ No user found with that email.\n";
        }
    } else {
        return "✗ Error updating user: " . $conn->error . "\n";
    }
}

// Handle different operations
if ($is_cli) {
    // CLI mode - interactive
    echo "\n=== YanKicks Admin User Management ===\n\n";
    echo "Options:\n";
    echo "1. Create new admin user\n";
    echo "2. Make existing user an admin\n";
    echo "3. View all admin users\n";
    echo "4. Exit\n\n";
    
    echo "Choose an option (1-4): ";
    $choice = trim(fgets(STDIN));
    
    switch ($choice) {
        case '1':
            echo "\nEnter full name: ";
            $full_name = trim(fgets(STDIN));
            echo "Enter email: ";
            $email = trim(fgets(STDIN));
            echo "Enter password: ";
            $password = trim(fgets(STDIN));
            echo "Confirm password: ";
            $confirm = trim(fgets(STDIN));
            
            if ($password === $confirm) {
                echo "\n" . create_admin_user($full_name, $email, $password, $conn);
                echo "Admin Credentials:\n";
                echo "  Email: $email\n";
                echo "  Password: $password\n";
            } else {
                echo "\n✗ Passwords do not match.\n";
            }
            break;
            
        case '2':
            echo "\nEnter email of existing user: ";
            $email = trim(fgets(STDIN));
            echo "\n" . update_user_role_to_admin($email, $conn);
            break;
            
        case '3':
            $result = $conn->query("SELECT id, full_name, email, created_at FROM users WHERE role = 'admin'");
            echo "\n=== Admin Users ===\n\n";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "ID: {$row['id']}\n";
                    echo "Name: {$row['full_name']}\n";
                    echo "Email: {$row['email']}\n";
                    echo "Created: {$row['created_at']}\n\n";
                }
            } else {
                echo "No admin users found.\n";
            }
            break;
            
        case '4':
            echo "\nExiting...\n";
            break;
            
        default:
            echo "\nInvalid option.\n";
    }
} else {
    // Web mode - form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        header('Content-Type: application/json');
        
        if ($_POST['action'] === 'create') {
            $result = create_admin_user(
                $_POST['full_name'],
                $_POST['email'],
                $_POST['password'],
                $conn
            );
            echo json_encode(['success' => !str_contains($result, '✗'), 'message' => $result]);
        } elseif ($_POST['action'] === 'promote') {
            $result = update_user_role_to_admin($_POST['email'], $conn);
            echo json_encode(['success' => !str_contains($result, '✗'), 'message' => $result]);
        }
        exit;
    }
    
    // Display web interface
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin User Manager - YanKicks</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: Inter, sans-serif; background: #f3f4f6; padding: 20px; }
            .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
            h1 { margin-bottom: 30px; color: #000; font-size: 28px; }
            .tabs { display: flex; gap: 10px; margin-bottom: 30px; border-bottom: 2px solid #e5e7eb; }
            .tab-btn { padding: 10px 20px; background: none; border: none; cursor: pointer; font-weight: 600; border-bottom: 3px solid transparent; transition: all 0.3s; }
            .tab-btn.active { color: #000; border-bottom-color: #000; }
            .tab-btn { color: #9ca3af; }
            .tab-content { display: none; }
            .tab-content.active { display: block; }
            .form-group { margin-bottom: 20px; }
            label { display: block; margin-bottom: 8px; font-weight: 600; color: #374151; }
            input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
            input:focus { outline: none; border-color: #000; ring: 2px solid rgba(0,0,0,0.1); }
            button { width: 100%; padding: 12px; background: #000; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
            button:hover { background: #333; }
            .message { margin-top: 20px; padding: 15px; border-radius: 6px; display: none; }
            .message.success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
            .message.error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
            .admin-list { margin-top: 20px; }
            .admin-item { background: #f9fafb; padding: 15px; border-radius: 6px; margin-bottom: 10px; }
            .admin-item strong { color: #000; }
            .admin-item p { color: #6b7280; font-size: 14px; margin-top: 5px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Admin User Manager</h1>
            
            <div class="tabs">
                <button class="tab-btn active" onclick="switchTab('create')">Create Admin</button>
                <button class="tab-btn" onclick="switchTab('promote')">Promote User</button>
                <button class="tab-btn" onclick="switchTab('view')">View Admins</button>
            </div>
            
            <!-- Create Admin Tab -->
            <div id="create" class="tab-content active">
                <form onsubmit="handleCreate(event)">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <button type="submit">Create Admin User</button>
                </form>
                <div id="createMsg" class="message"></div>
            </div>
            
            <!-- Promote User Tab -->
            <div id="promote" class="tab-content">
                <form onsubmit="handlePromote(event)">
                    <div class="form-group">
                        <label>User Email</label>
                        <input type="email" name="email" placeholder="Email of existing user" required>
                    </div>
                    <button type="submit">Make Admin</button>
                </form>
                <div id="promoteMsg" class="message"></div>
            </div>
            
            <!-- View Admins Tab -->
            <div id="view" class="tab-content">
                <button onclick="loadAdmins()" style="margin-bottom: 20px;">Refresh List</button>
                <div id="adminList" class="admin-list"></div>
            </div>
        </div>
        
        <script>
            function switchTab(tab) {
                document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
                document.getElementById(tab).classList.add('active');
                event.target.classList.add('active');
                
                if (tab === 'view') loadAdmins();
            }
            
            function showMessage(elementId, message, isSuccess) {
                const el = document.getElementById(elementId);
                el.className = 'message ' + (isSuccess ? 'success' : 'error');
                el.textContent = message;
                el.style.display = 'block';
            }
            
            function handleCreate(e) {
                e.preventDefault();
                const formData = new FormData(e.target);
                formData.append('action', 'create');
                
                fetch('', { method: 'POST', body: formData })
                    .then(r => r.json())
                    .then(data => {
                        showMessage('createMsg', data.message, data.success);
                        if (data.success) e.target.reset();
                    });
            }
            
            function handlePromote(e) {
                e.preventDefault();
                const formData = new FormData(e.target);
                formData.append('action', 'promote');
                
                fetch('', { method: 'POST', body: formData })
                    .then(r => r.json())
                    .then(data => {
                        showMessage('promoteMsg', data.message, data.success);
                        if (data.success) e.target.reset();
                    });
            }
            
            function loadAdmins() {
                fetch('?action=list')
                    .then(r => r.text())
                    .then(html => document.getElementById('adminList').innerHTML = html);
            }
        </script>
    </body>
    </html>
    <?php
}

$conn->close();
?>
