<?php
  /**
   * PHP Export to Excel - Index
   * ==================================================
   * Author : Thanadon X Songsuittipong
   * ==================================================
   * using PHPExcel Libraries 
   * Available at http://phpexcel.codeplex.com/
   */
?>
<?php
  require('dbfunction.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PHP Export to Excel</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container" align="center">
  <div class="page-header">
    <h1>PHP Export to Excel <small>[ Demo ]</small></h1>
  </div>
  <form action="excel_generate.php" method="post">
  <div class="row">
      <table class="table table-hover">
      <thead>
        <tr>
          <th><input type="checkbox" onchange="checkAll(this)" name="chkAll[]" /></th>
          <th>Username</th>
          <th>Full Name</th>
          <th>Last Export</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $results = get_data();
          while($fetch = $results->fetch_assoc()) {
        ?>
        <tr>
          <th scope="row"><input type="checkbox" name="chkSelect[]" value="<?php echo $fetch['memberID']; ?>" /></th>
          <td><?php echo $fetch['username']; ?></td>
          <td><?php echo $fetch['fullname']; ?></td>
          <td><?php echo $fetch['lastexport']; ?></td>
        </tr>
        <? } ?>
      </tbody>
      </table>
  </div>
   <div class="row" align="center" style = "padding: 0px 0px 20px 0px;">
    <input type="submit" class="btn btn-info" value="Export" style="margin-right: 20px;">
    <button type="button" class="btn btn-warning" onclick="refreshPage()">Reload</button>

   </div>
   
  </form>
</div>
</body>
<script type="text/javascript">
// Check ALL Function
function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
}
function refreshPage() {
  window.location.reload();
}
</script>
</html>