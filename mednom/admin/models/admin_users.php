<?php

//*******************************  USERS / AUTHENTICATION **********************************

function et_sec_session_start()
{
    $session_name = 'sec_session_id';   // Set a custom session name

    $secure = true;
    $config = get_config();
    if ($config['development_mode']) {
        $secure = false;
    }

    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    // Sets the session name to the one set above.
    session_name($session_name);

    session_start();            // Start the PHP session
    session_regenerate_id();    // regenerated the session, delete the old one.
}


function et_login($username, $password, $mysqli)
{

    // Using prepared statements means that SQL injection is not possible.
    if ($stmt = $mysqli->prepare("SELECT id, email, password, salt 
				  FROM et_users 
                                  WHERE username = ? LIMIT 1")
    ) {
        $stmt->bind_param('s', $username);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $email, $db_password, $salt);
        $stmt->fetch();

        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            if (et_checkbrute($user_id, $mysqli) == true) {
                // Account is locked
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);

                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    if (!$mysqli->query("INSERT INTO et_user_login_attempts(user_id, time) 
                                    VALUES ('$user_id', '$now')")
                    ) {
                        header("Location: error.php?err=Database error: login_attempts");
                        exit();
                    }

                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: error.php?err=Database error: cannot prepare statement");
        exit();
    }
}


function et_checkbrute($user_id, $mysqli)
{
    // Get timestamp of current time
    $now = time();

    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time 
                                  FROM et_user_login_attempts 
                                  WHERE user_id = ? AND time > '$valid_attempts'")
    ) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query.
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: error.php?err=Database error: cannot prepare statement");
        exit();
    }
}


function et_login_check($mysqli)
{

    // Check if all session variables are set
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password 
				      FROM et_users
				      WHERE id = ? LIMIT 1")
        ) {
            // Bind "$user_id" to parameter.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Could not prepare statement
            header("Location: error.php?err=Database error: cannot prepare statement");
            exit();
        }
    } else {
        // Not logged in
        return false;
    }
}

function et_esc_url($url)
{

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string)$url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function et_user_register($mysqli, $username, $email, $password)
{
    $error_msg = '';
    $prep_stmt = "SELECT id FROM et_users WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    }

    // TODO:
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.

    if (empty($error_msg)) {
        // Create a random salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

        // Create salted password
        $password = hash('sha512', $password . $random_salt);

        // Insert the new user into the database
        if ($insert_stmt = $mysqli->prepare("INSERT INTO et_users (username, email, password, salt) VALUES (?, ?, ?, ?)")) {
            $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);
            // Execute the prepared query.
            if (!$insert_stmt->execute()) {
                header('Location: error.php?err=Registration failure: INSERT');
                exit();
            }
        }
        header('Location: register_success.php');
        exit();
    }
    return $error_msg;
}


function et_user_privileges_check($mysqli, $entity_name, $view_name, $privileges = array())
{
    $user = et_get_by_identifier($mysqli, 'et_users', 'username', $_SESSION['username']);
    $user_allowed_privileges = csvline_decode($user['allowed_privileges']);
    $user_disallowed_privileges = csvline_decode($user['disallowed_privileges']);
    $user_groups = csvline_decode($user['user_groups']);
    foreach ($user_groups as $user_group) {
        $user_group_row = et_get_by_identifier($mysqli, 'et_user_groups', 'name', $user_group);
        $user_group_allowed_privileges = csvline_decode($user_group_row['allowed_privileges']);
        $user_group_disallowed_privileges = csvline_decode($user_group_row['disallowed_privileges']);
        $user_allowed_privileges = array_merge($user_allowed_privileges, $user_group_allowed_privileges);
        $user_disallowed_privileges = array_merge($user_disallowed_privileges, $user_group_disallowed_privileges);
    }

    $entity = et_get_by_identifier($mysqli, 'et_entities', 'name', $entity_name);
    $entity_views = json_decode($entity['views'], true);
    $view = $entity_views[$view_name];

    $granted = false;
    $view_privileges = $view['extra_privileges'];
    // to do privileges check
    foreach ($user_allowed_privileges as $user_allowed_privilege) {
        if ($user_allowed_privilege == $view['type'] . '_all' || $user_allowed_privilege == $view['type'] . '_' . $entity_name || $user_allowed_privilege == 'all' || $user_allowed_privilege == $entity_name) {
            $granted = true;
            break;
        } else {
            foreach ($view_privileges as $view_privilege) {
                if ($user_allowed_privilege == $view_privilege) {
                    $granted = true;
                    break;
                }
            }
        }
    }
    foreach ($user_disallowed_privileges as $user_disallowed_privilege) {
        if ($user_allowed_privilege == $view['type'] . '_all' || $user_allowed_privilege == $view['type'] . '_' . $entity_name || $user_disallowed_privilege == 'all' || $user_disallowed_privilege == $entity_name) {
            $granted = false;
            break;
        } else {
            foreach ($view_privileges as $view_privilege) {
                if ($user_disallowed_privilege == $view_privilege) {
                    $granted = false;
                    break;
                }
            }
        }
    }

    return $granted;
}