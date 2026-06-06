<?php

if( isset( $_REQUEST[ 'Submit' ] ) ) {

    // Mejor usar GET específicamente
    $id = $_GET['id'];

    switch ($_DVWA['SQLI_DB']) {

        case MYSQL:

            //  Prepared statement seguro
            $stmt = mysqli_prepare(
                $GLOBALS["___mysqli_ston"],
                "SELECT first_name, last_name FROM users WHERE user_id = ?"
            );

            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            while( $row = mysqli_fetch_assoc( $result ) ) {
                $first = $row["first_name"];
                $last  = $row["last_name"];

                $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
            }

            mysqli_close($GLOBALS["___mysqli_ston"]);
            break;


        case SQLITE:

            global $sqlite_db_connection;

            //  Prepared statement SQLITE
            $stmt = $sqlite_db_connection->prepare(
                "SELECT first_name, last_name FROM users WHERE user_id = :id"
            );

            $stmt->bindValue(':id', $id, SQLITE3_TEXT);

            $results = $stmt->execute();

            if ($results) {
                while ($row = $results->fetchArray()) {
                    $first = $row["first_name"];
                    $last  = $row["last_name"];

                    $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
                }
            } else {
                echo "Error in fetch";
            }

            break;
    }
}

?>
