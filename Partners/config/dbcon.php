

    <?php
    //create a connection to the database
    $servername = "127.0.0.1"; //127.0.0.1 //computername
    $username = "root"; //default username admin
    $password = ""; //default password is empty
    $dbname = "ecorewards"; //database name
 
    $conn = mysqli_connect($servername, $username, $password, $dbname) ;
    //check connection
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
    <!-- //step 2 - create SQL query to retrieve data
    $query = "SELECT * FROM tblstudents WHERE firstname LIKE 'el%'"; //SQL query string
    $result = mysqli_query($conn, $query); //execute the query
    //step 3 - display the data
    //3.1 - check if there are records
    if(mysqli_num_rows($result) > 0){
        echo 'record/s found<br>';
        //3.2 - output data of each row
        //create the table header
        echo '<table border="1">
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Gender</th>
                    <th>Country</th>
                </tr>';
        while($row = mysqli_fetch_assoc($result)){
            echo '<tr>
                    <td>' . $row['studentid'] . '</td>
                    <td>' . $row['firstname'] . '</td>
                    <td>' . $row['lastname'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['password'] . '</td>
                    <td>' . $row['gender'] . '</td>
                    <td>' . $row['country'] . '</td>
                 </tr>';
 
            /// id fname lname email
        }
        echo '</table>';
         
    }else{
        echo 'no record found<br>';
    }
 
    //step 4 - close the connection
    mysqli_close($conn);
    ?> -->