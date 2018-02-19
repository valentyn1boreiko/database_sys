
<?php
  $user = 'a01503954';
  $pass = 'dbs17';
  $database = 'lab';

  // establish database connection
  $conn = oci_connect($user, $pass, $database);
  if (!$conn) exit;
?>

<html>
<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
  <link href="css/scrolling-nav.css" rel="stylesheet">
</head>
<body id="page-top">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Interest tracker</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#personen">Personen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#figuren">Interesse über Persönlichkeiten</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#ereignisse">Interesse über Ereignisse</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#medien">Medien von Persönlichkeiten</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <header class="bg-primary text-white">
    <div class="container text-center">
      <h1>Project: interest tracking</h1>
      <p class="lead">Find the person that interests you: and we will find the best masterpieces</p>
    </div>
  </header>

  <!-- Personen -->
  <section id="personen">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2>About this page</h2>
          <p class="lead">Hier wir haben Entität Personen</p>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
      <form id='searchform' action='index.php' method='get'>
        <a href='index.php'>Alle Personen</a> ---
        Suche nach Name:
        <input id='search' name='search' type='text' size='20' value='' />
        <input id='submit' type='submit' value='Los!' />
      </form>

  <?php
    // check if search view of list view
    if (isset($_GET['search'])) {
      $sql = "SELECT * FROM Person WHERE Name like '%" . $_GET['search'] . "%'";
    } else {
      $sql = "SELECT * FROM Person";
    }

    // execute sql statement
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
  ?>
    <table style='border: 1px solid #DDDDDD; display: block; height: 400px; overflow-y: scroll;'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Adresse</th>
          <th>Bankdaten</th>
        </tr>
      </thead>
      <tbody>
  <?php
    // fetch rows of the executed sql query
    while ($row = oci_fetch_assoc($stmt)) {
      echo "<tr>";
      echo "<td>" . $row['NAME'] . "</td>";
      echo "<td>" . $row['ADRESSE'] . "</td>";
      echo "<td>" . $row['BANKDATEN']  . "</td>";
      echo "</tr>";
    }
  ?>
      </tbody>
    </table>
  <div>Insgesamt <?php echo oci_num_rows($stmt); ?> Person(en) gefunden!</div>
  <?php  oci_free_statement($stmt); ?>

  <div>
    <form id='insertform' action='index.php' method='get'>
      Neue Person einfuegen:
    <table style='border: 1px solid #DDDDDD'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Adresse</th>
          <th>Bankdaten</th>
        </tr>
      </thead>
      <tbody>
         <tr>
            <td>
               <input id='name' name='name' type='text' size='10' value='' />
                  </td>

      <td>
         <input id='adresse' name='adresse' type='text' size='20' value='' />
      </td>
      <td>
         <input id='bankdaten' name='bankdaten' type='text' size='20' value='' />
      </td>
          </tr>
             </tbody>
          </table>
          <input id='submit' type='submit' value='Insert!' />
    </form>
  </div>


  <?php
    //Handle insert
    if (isset($_GET['name']) && isset($_GET['adresse']) && isset($_GET['bankdaten']))
    {
      //Prepare insert statementd
      $sql = "INSERT INTO Person (Name,Adresse,Bankdaten) VALUES('" . $_GET['name'] . "','"  . $_GET['adresse'] . "','" . $_GET['bankdaten'] . "')";
      //Parse and execute statement
      $insert = oci_parse($conn, $sql);
      oci_execute($insert);
      $conn_err=oci_error($conn);
      $insert_err=oci_error($insert);
      if(!$conn_err & !$insert_err){
    print("Successfully inserted");
    print("<br>");
      }
      //Print potential errors and warnings
      else{
         print($conn_err);
         print_r($insert_err);
         print("<br>");
      }
      oci_free_statement($insert);
    }
  ?>

  <div>
    <form id='insertform' action='index.php' method='get'>
      Person löschen:
    <table style='border: 1px solid #DDDDDD'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Adresse</th>
          <th>Bankdaten</th>
        </tr>
      </thead>
      <tbody>
         <tr>
            <td>
               <input id='name_d' name='name_d' type='text' size='10' value='' />
                  </td>

      <td>
         <input id='adresse_d' name='adresse_d' type='text' size='20' value='' />
      </td>
      <td>
         <input id='bankdaten_d' name='bankdaten_d' type='text' size='20' value='' />
      </td>
          </tr>
             </tbody>
          </table>
          <input id='submit' type='submit' value='Delete!' />
    </form>
  </div>


  <?php
    //Handle insert
    if (isset($_GET['name_d']) && isset($_GET['adresse_d']) && isset($_GET['bankdaten_d']))
    {
      //Prepare insert statementd
        $sql = "DELETE FROM Person WHERE NAME='" . $_GET['name_d'] . "' AND ADRESSE='"  . $_GET['adresse_d'] . "' AND BANKDATEN='" . $_GET['bankdaten_d'] . "'";
      echo " NAME='" . $_GET['name_d'] . "' AND ADRESSE='"  . $_GET['adresse_d'] . "' AND BANKDATEN='" . $_GET['bankdaten_d'] . "'";
      //Parse and execute statement
      $delete = oci_parse($conn, $sql);
      oci_execute($delete);
      $conn_err=oci_error($conn);
      $delete_err=oci_error($delete);
      if(!$conn_err & !$delete_err){
    print("Successfully deleted");
    print("<br>");
      }
      //Print potential errors and warnings
      else{
         print($conn_err);
         print_r($delete_err);
         print("<br>");
      }
      oci_free_statement($delete);
    }
  ?>

  <div>
    <form id='searchabt' action='index.php' method='get'>
      Suche Followers zu bestimmter person (Adresse):
        <input id='adresse_proc' name='adresse_proc' type='text' size='20' value='' />
        <input id='submit' type='submit' value='Aufruf Stored Procedure!' />
    </form>
  </div>

  <?php
    //Handle Stored Procedure
    if (isset($_GET['adresse_proc']))
    {
      //Call Stored Procedure
      $name = $_GET['adresse_proc'];
      $sql = "SELECT ID FROM Person WHERE ADRESSE='$name'";
      $stmt = oci_parse($conn, $sql);
      oci_execute($stmt);
      $id = "";
      while ($row = oci_fetch_assoc($stmt)) {
        $id = $row['ID'];
      }
      oci_free_statement($stmt);
      //$id = oci_fetch_assoc($stmt)['ID'];
      $sproc = oci_parse($conn, 'begin test(:p1, :p2); end;');
      //Bind variables, p1=input (nachname), p2=output (abtnr)
      oci_bind_by_name($sproc, ':p1', $id);
      oci_bind_by_name($sproc, ':p2', $folger_id);
      oci_execute($sproc);
      $conn_err=oci_error($conn);
      $proc_err=oci_error($sproc);
      if(!$conn_err && !$proc_err){
        $sql = "SELECT ADRESSE FROM Person WHERE ID='$folger_id'";
        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);

        while ($row = oci_fetch_assoc($stmt)) {
          echo "Folger adresse = " . $row['ADRESSE'] . "";
        }
        }
      else{
         //Print potential errors and warnings
         print($conn_err);
         print_r($proc_err);
      }
      oci_free_statement($stmt);
      oci_free_statement($sproc);
    }

   ?>
  </div>
  </div>
  </div>
  </section>

  <section id="figuren">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2>About this page</h2>
          <p class="lead">Hier wir haben Entität Figuren und Leute</p>

        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
      <form id='searchform' action='index.php' method='get'>
        <a href='index.php'>Alle Persönlichkeiten</a> ---
        Suche nach Name:
        <input id='search2' name='search2' type='text' size='20' value='' />
        <input id='submit' type='submit' value='Los!' />
      </form>

  <?php
    // check if search view of list view
    if (isset($_GET['search2'])) {
      $sql = "SELECT * FROM Figuren_Leute WHERE Name like '%" . $_GET['search2'] . "%'";
    } else {
      $sql = "SELECT * FROM Figuren_Leute";
    }

    // execute sql statement
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
  ?>
    <table style='border: 1px solid #DDDDDD; display: block; height: 400px; overflow-y: scroll;'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Wichtigkeit</th>
          <th>Einflussbereich</th>
        </tr>
      </thead>
      <tbody>
  <?php
    // fetch rows of the executed sql query
    while ($row = oci_fetch_assoc($stmt)) {
      echo "<tr>";
      echo "<td>" . $row['NAME'] . "</td>";
      echo "<td>" . $row['WICHTIGKEIT'] . "</td>";
      echo "<td>" . $row['EINFLUSSBEREICH']  . "</td>";
      echo "</tr>";
    }
  ?>
      </tbody>
    </table>
  <div>Insgesamt <?php echo oci_num_rows($stmt); ?> Persönnlichkeit(en) gefunden!</div>
  <?php  oci_free_statement($stmt); ?>

  <div>
    <form id='insertform' action='index.php' method='get'>
      Neue Persönnlichkeit einfuegen:
    <table style='border: 1px solid #DDDDDD'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Wichtigkeit</th>
          <th>Einflussbereich</th>
        </tr>
      </thead>
      <tbody>
         <tr>
            <td>
               <input id='name2' name='name2' type='text' size='10' value='' />
                  </td>

      <td>
         <input id='w' name='w' type='text' size='20' value='' />
      </td>
      <td>
         <input id='ein' name='ein' type='text' size='20' value='' />
      </td>
          </tr>
             </tbody>
          </table>
          <input id='submit' type='submit' value='Insert!' />
    </form>
  </div>


  <?php
    //Handle insert
    if (isset($_GET['name2']) && isset($_GET['w']) && isset($_GET['ein']))
    {
      //  print("Successfully inserted" . $_GET['name2'] . "");
      //Prepare insert statementd
      //$sql = "INSERT INTO Themen (Name) VALUES('" . substr($_GET['name2'],0,6) . "','"  . $_GET['w'] . "','" . $_GET['ein'] . "')";
      $sql = "INSERT INTO Themen (Name) VALUES('" . substr($_GET['name2'],0,6) . "')";

      //Parse and execute statement
      $insert = oci_parse($conn, $sql);
      oci_execute($insert);
      $conn_err=oci_error($conn);
      $insert_err=oci_error($insert);
      if(!$conn_err & !$insert_err){
    print("Successfully inserted");
    print("<br>");
      }
      //Print potential errors and warnings
      else{
         print($conn_err);
         print_r($insert_err);
         print("<br>");
      }
      oci_free_statement($insert);

      $sql_last_id = "SELECT MAX(ID) as NUM FROM Themen";
      $stmt2 = oci_parse($conn, $sql_last_id);
      oci_define_by_name($stmt2, 'NUM', $idd);
      oci_execute($stmt2);
      $id_last = "";
      while (oci_fetch($stmt2)) {
        $id_last = $idd;
      }
      //$last_id = $insert->lastInsertId();
      //echo "New record created successfully. Last inserted ID is: " . $id_last;
      $conn_err=oci_error($conn);
      $insert_err=oci_error($stmt2);
      if(!$conn_err & !$insert_err){
    //print("Successfully inserted");
    //print("<br>");
      }
      //Print potential errors and warnings
      else{
         print($conn_err);
         print_r($insert_err);
         print("<br>");
      }
      oci_free_statement($stmt2);


      $sql = "INSERT INTO Figuren_Leute (T_ID, Name, Wichtigkeit, Einflussbereich) VALUES('" . $id_last . "','" . $_GET['name2'] . "','" . $_GET['w'] . "','" . $_GET['ein'] . "')";

      //Parse and execute statement
      $insert = oci_parse($conn, $sql);
      oci_execute($insert);
      $conn_err=oci_error($conn);
      $insert_err=oci_error($insert);
      if(!$conn_err & !$insert_err){
    print("Successfully inserted");
    print("<br>");
      }
      //Print potential errors and warnings
      else{
         print($conn_err);
         print_r($insert_err);
         print("<br>");
      }
      oci_free_statement($insert);

          }
  ?>


  </div>
  </div>
  </div>
  </section>


  <!-- Ereignisse -->
  <section id="ereignisse">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2>About this page</h2>
          <p class="lead">Hier wir haben Entität Ereignisse</p>

        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
      <form id='searchform' action='index.php' method='get'>
        <a href='index.php'>Alle Ereignisse</a> ---
        Suche nach Name:
        <input id='search3' name='search3' type='text' size='20' value='' />
        <input id='submit' type='submit' value='Los!' />
      </form>

  <?php
    // check if search view of list view
    if (isset($_GET['search3'])) {
      $sql = "SELECT * FROM Ereignisse WHERE Name like '%" . $_GET['search3'] . "%'";
    } else {
      $sql = "SELECT * FROM Ereignisse";
    }

    // execute sql statement
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
  ?>
    <table style='border: 1px solid #DDDDDD; display: block; height: 400px; overflow-y: scroll;'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Ort</th>
          <th>Wichtigkeit</th>
        </tr>
      </thead>
      <tbody>
  <?php
    // fetch rows of the executed sql query
    while ($row = oci_fetch_assoc($stmt)) {
      echo "<tr>";
      echo "<td>" . $row['NAME'] . "</td>";
      echo "<td>" . $row['ORT'] . "</td>";
      echo "<td>" . $row['WICHTIGKEIT']  . "</td>";
      echo "</tr>";
    }
  ?>
      </tbody>
    </table>
  <div>Insgesamt <?php echo oci_num_rows($stmt); ?> Ereignis(se) gefunden!</div>
  <?php  oci_free_statement($stmt); ?>

  <div>
    <form id='insertform' action='index.php' method='get'>
      Neues Ereignis einfuegen:
    <table style='border: 1px solid #DDDDDD'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Ort</th>
          <th>Wichtigkeit</th>
        </tr>
      </thead>
      <tbody>
         <tr>
            <td>
               <input id='name3' name='name3' type='text' size='10' value='' />
                  </td>

      <td>
         <input id='ort' name='ort' type='text' size='20' value='' />
      </td>
      <td>
         <input id='w' name='w' type='text' size='20' value='' />
      </td>
          </tr>
             </tbody>
          </table>
          <input id='submit' type='submit' value='Insert!' />
    </form>
  </div>


  <?php
    //Handle insert
    if (isset($_GET['name3']) && isset($_GET['w']) && isset($_GET['ort']))
    {
      //  print("Successfully inserted" . $_GET['name2'] . "");
      //Prepare insert statementd
      //$sql = "INSERT INTO Themen (Name) VALUES('" . substr($_GET['name2'],0,6) . "','"  . $_GET['w'] . "','" . $_GET['ein'] . "')";
      $sql = "INSERT INTO Themen (Name) VALUES('" . substr($_GET['name3'],0,6) . "')";

      //Parse and execute statement
      $insert = oci_parse($conn, $sql);
      oci_execute($insert);
      $conn_err=oci_error($conn);
      $insert_err=oci_error($insert);
      if(!$conn_err & !$insert_err){
    print("Successfully inserted");
    print("<br>");
      }
      //Print potential errors and warnings
      else{
         print($conn_err);
         print_r($insert_err);
         print("<br>");
      }
      oci_free_statement($insert);

      $sql_last_id = "SELECT MAX(ID) as NUM FROM Themen";
      $stmt2 = oci_parse($conn, $sql_last_id);
      oci_define_by_name($stmt2, 'NUM', $idd);
      oci_execute($stmt2);
      $id_last = "";
      while (oci_fetch($stmt2)) {
        $id_last = $idd;
      }
      //$last_id = $insert->lastInsertId();
      //echo "New record created successfully. Last inserted ID is: " . $id_last;
      $conn_err=oci_error($conn);
      $insert_err=oci_error($stmt2);
      if(!$conn_err & !$insert_err){
    //print("Successfully inserted");
    //print("<br>");
      }
      //Print potential errors and warnings
      else{
         print($conn_err);
         print_r($insert_err);
         print("<br>");
      }
      oci_free_statement($stmt2);


      $sql = "INSERT INTO Ereignisse (T_ID, Name, Ort, Wichtigkeit) VALUES('" . $id_last . "','" . $_GET['name3'] . "','" . $_GET['ort'] . "','" . $_GET['w'] . "')";

      //Parse and execute statement
      $insert = oci_parse($conn, $sql);
      oci_execute($insert);
      $conn_err=oci_error($conn);
      $insert_err=oci_error($insert);
      if(!$conn_err & !$insert_err){
    print("Successfully inserted");
    print("<br>");
      }
      //Print potential errors and warnings
      else{
         print($conn_err);
         print_r($insert_err);
         print("<br>");
      }
      oci_free_statement($insert);

          }
  ?>


  </div>
  </div>
  </div>
  </section>

  <!-- Medien Figuren -->
  <section id="medien">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2>About this page</h2>
          <p class="lead">Hier wir haben Entität Medien_Arhiv_Figuren_Leute</p>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
      <form id='searchform' action='index.php' method='get'>
        <a href='index.php'>Alle Personen</a> ---
        Suche nach Name:
        <input id='search' name='search4' type='text' size='20' value='' />
        <input id='submit' type='submit' value='Los!' />
      </form>

  <?php
    // check if search view of list view
    if (isset($_GET['search4'])) {
      $sql = "SELECT * FROM Medien_Arhiv_Figuren_Leute WHERE Name like '%" . $_GET['search4'] . "%'";
    } else {
      $sql = "SELECT * FROM Medien_Arhiv_Figuren_Leute";
    }

    // execute sql statement
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
  ?>
    <table style='border: 1px solid #DDDDDD; display: block; height: 400px; overflow-y: scroll;'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Preis</th>
          <th>Medien_pfad</th>
          <th>ID von Persönnlichkeit</th>
        </tr>
      </thead>
      <tbody>
  <?php
    // fetch rows of the executed sql query
    while ($row = oci_fetch_assoc($stmt)) {
      echo "<tr>";
      echo "<td>" . $row['NAME'] . "</td>";
      echo "<td>" . $row['PREIS'] . "</td>";
      echo "<td>" . $row['MEDIEN_PFAD']  . "</td>";
      echo "<td>" . $row['FL_ID']  . "</td>";
      echo "</tr>";
    }
  ?>
      </tbody>
    </table>
  <div>Insgesamt <?php echo oci_num_rows($stmt); ?> Medien gefunden!</div>
  <?php  oci_free_statement($stmt); ?>

  <div>
    <form id='insertform' action='index.php' method='get'>
      Neue Media einfuegen:
    <table style='border: 1px solid #DDDDDD'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Preis</th>
          <th>Medien Pfad</th>
          <th>ID von Persönnlichkeit</th>
        </tr>
      </thead>
      <tbody>
         <tr>
            <td>
               <input id='name4' name='name4' type='text' size='10' value='' />
                  </td>

      <td>
         <input id='preis' name='preis' type='text' size='20' value='' />
      </td>
      <td>
         <input id='pfad' name='pfad' type='text' size='20' value='' />
      </td>
      <td>
         <input id='fl_id' name='fl_id' type='text' size='20' value='' />
      </td>
          </tr>
             </tbody>
          </table>
          <input id='submit' type='submit' value='Insert!' />
    </form>
  </div>


  <?php
    //Handle insert
    if (isset($_GET['name4']) && isset($_GET['preis']) && isset($_GET['pfad']) && isset($_GET['fl_id']))
    {
      //Prepare insert statementd
      $sql = "INSERT INTO Medien_Arhiv_Figuren_Leute (Medien_Pfad,Preis,Name,FL_ID) VALUES('" . $_GET['pfad'] . "','"  . $_GET['preis'] . "','" . $_GET['name4'] . "', '" . $_GET['fl_id'] . "')";
      //Parse and execute statement
      $insert = oci_parse($conn, $sql);
      oci_execute($insert);
      $conn_err=oci_error($conn);
      $insert_err=oci_error($insert);
      if(!$conn_err & !$insert_err){
    print("Successfully inserted");
    print("<br>");
      }
      //Print potential errors and warnings
      else{
         print($conn_err);
         print_r($insert_err);
         print("<br>");
      }
      oci_free_statement($insert);
    }
  ?>
  </div>
  </div>
  </div>
  </section>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2017</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom JavaScript for this theme -->
  <script src="js/scrolling-nav.js"></script>

<?php
  // clean up connections

  oci_close($conn);
?>
</body>
</html>
