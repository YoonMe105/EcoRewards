<?php
session_start();
session_unset();
session_destroy();
header("Location: ../login/login.php");
exit();
?>

// <?php

// include 'dbConn.php';

// // Step 2 - create SQL query to retrieve data
// $query = "SELECT * FROM tblstudents";
// $result = mysqli_query($conn, $query);

// // Step 3 - display the data
// if (mysqli_num_rows($result) > 0) {

//     echo 'record/s found<br>';

//     // Create table header
//     echo '<table border="1">
//         <tr>
//             <th>Student ID</th>
//             <th>First Name</th>
//             <th>Last Name</th>
//             <th>Email</th>
//             <th>Password</th>
//             <th>Gender</th>
//             <th>Country</th>
//             <th colspan="2">Actions</th>
//         </tr>';

//     // Output data of each row
//     while ($row = mysqli_fetch_assoc($result)) {

//         echo '<tr>
//             <td>' . $row['studentid'] . '</td>
//             <td>' . $row['firstname'] . '</td>
//             <td>' . $row['lastname'] . '</td>
//             <td>' . $row['email'] . '</td>
//             <td>' . $row['password'] . '</td>
//             <td>' . $row['gender'] . '</td>
//             <td>' . $row['country'] . '</td>
//             <td>
//                 <a href="editStudent.php?id=' . $row['studentid'] . '">Edit</a>
//             </td>
//             <td>
//                 <a href="deleteStudent.php?studentid=' . $row['studentid'] . '">Delete</a>
//             </td>
//         </tr>';
//     }

//     echo '</table>';

// } else {
//     echo 'no record found<br>';
// }

// // Step 4 - close the connection
// mysqli_close($conn);

// ?>
