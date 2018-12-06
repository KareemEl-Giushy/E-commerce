<?php
  ob_start();
  session_start();
  $pagetitle = 'Items';
  if (isset($_SESSION['user'])){
    include 'connect.php';
    include 'includes/templates/header.php';
    include 'includes/templates/navbar.php';

    $act = isset($_GET['act']) ? $_GET['act'] : 'manage';

    if ($act == 'manage'){

      $stmt = $con->prepare("SELECT items.*, categories.cname, users.Username FROM items INNER JOIN categories ON items.Cat_ID = categories.cID INNER JOIN users ON items.Member_ID = users.UserID");
      $stmt->execute();
      $itemsinfo = $stmt->fetchAll();
      // echo "<pre>";
      // print_r($itemsinfo);
      // echo "</pre>";
    ?>
      <h2 class="text-center mb-5 mt-3">Manage</h2>
      <div class="container">
        <div class="table-responsive table-responsive-sm table-responsive-md table-striped table-hover">
          <table class="table table-bordered">
            <tr>
              <td>#ID</td>
              <td>Item Name</td>
              <td>Price</td>
              <td>Published Date</td>
              <td>Status</td>
              <td>Category</td>
              <td>User</td>
              <td>Controls</td>
            </tr>
<?php
            foreach ($itemsinfo as $item){
              echo "<tr>";
              echo "<td>" . $item[0] . "</td>";
              echo "<td style='width: min-content;'>" . $item[1] . "</td>";
              echo "<td>" . $item[3] . "</td>";
              echo "<td>" . $item[4] . "</td>";
              echo "<td>" . $item[7] . "</td>";
              echo "<td>" . $item[12] . "</td>";
              echo "<td>" . $item[13] . "</td>";
              echo "<td>
                <a class='btn btn-success m-0' href='?act=edit&itemid=" . $item[0] . "'><i class='fa fa-edit'></i></a>
                <a class='confirm btn btn-danger m-1' href='?act=delete&itemid=" . $item[0] . "'><i class='fa fa-trash'></i></a>";
                if ($item[8] == 0) {
                  echo "<a class='btn btn-info m-1' href='?act=approve&itemid=" . $item[0] . "'><i class='fa fa-check-square'></i></a>";
                }
              echo"</td>";
              echo "</tr>";
            } ?>
          </table>
        </div>
        <a href="?act=add"><i class="fa fa-plus"></i> Add New Item</a>
      </div>
<?php
    }elseif ($act == 'edit'){
      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 1;

      $stmt = $con->prepare("SELECT * FROM items WHERE itemid = ?");
      $stmt->bindParam(1, $itemid);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        $iteminfo = $stmt->fetch();?>
        <h2 class='text-center mb-5 mt-3 l-capital'>edit item</h2>
        <div class="container">
          <div class="row">
            <form class="form-group w-75 m-auto" action="items.php?act=update" method="post">
              <input type="hidden" name="theid" value="<?php echo $itemid; ?>">
              <div class="form-row mb-3">
                <label class='col col-form-label'>Item Name</label>
                <input type="text" name="itemname" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" required value="<?php echo $iteminfo[1]; ?>">
              </div>
              <div class="form-row mb-3">
                <label class='col col-form-label'>Description</label>
                <textarea type="text" name="description" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" required ><?php echo $iteminfo[2]; ?></textarea>
              </div>
              <div class="form-row mb-3">
                <label class='col col-form-label'>Price</label>
                <input type="text" name="price" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" required value="<?php echo $iteminfo[3]; ?>">
              </div>
              <div class="form-row mb-3">
                <label class='col col-form-label'>Status</label>
                <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                  <select class="form-control" name='status'>
                    <option>Status</option>
                    <option value="new" <?php if($iteminfo['status'] == 'new'){echo "selected";} ?>>Band-New</option>
                    <option value="like-new" <?php if($iteminfo['status'] == 'like-new'){echo "selected";} ?>>Like-New</option>
                    <option value="used" <?php if($iteminfo['status'] == 'used'){echo "selected";} ?>>Used</option>
                    <option value="old" <?php if($iteminfo['status'] == 'old'){echo "selected";} ?>>Very Old</option>
                  </select>
                </div>
              </div>
              <div class="form-row mb-3">
                <label class='col col-form-label'>Members</label>
                <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                  <select class="form-control" name='members'>
                    <option value="0">...</option>
<?php
                    $stmt = $con->prepare("SELECT userid, username FROM users");
                    $stmt->execute();
                    $membersinfo = $stmt->fetchAll();
                    foreach ($membersinfo as $member){
                      if ($member[0] == $iteminfo["Member_ID"]) {
                        echo "<option value='" . $member[0] . "' selected>" . $member[1] . "</option>";
                      }else {
                        echo "<option value='" . $member[0] . "'>" . $member[1] . "</option>";
                      }
                    }?>
                  </select>
                </div>
              </div>
              <div class="form-row mb-3">
                <label class='col col-form-label'>Categories</label>
                <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                  <select class="form-control" name='categories'>
                    <option value="0">...</option>
<?php
                    $stmt = $con->prepare("SELECT cid, cname FROM categories");
                    $stmt->execute();
                    $catesinfo = $stmt->fetchAll();
                    foreach ($catesinfo as $cate){
                      if ($cate[0] == $iteminfo["Cat_ID"]) {
                        echo "<option value='" . $cate[0] . "' selected>" . $cate[1] . "</option>";
                      }else {
                        echo "<option value='" . $cate[0] . "'>" . $cate[1] . "</option>";
                      }
                    }?>
                  </select>
                </div>
              </div>
              <input type="submit" Value="Update Item" class="btn btn-primary float-sm-none float-md-right mt-2 col-md-3 col-12 col-sm-12">
            </form>
            <div class=" m-auto">
<?php
            $stmt = $con->prepare("SELECT comments.*, users.Username FROM comments INNER JOIN users ON users.UserID = comments.user_id WHERE comments.item_id = ?");
            $stmt->execute([$itemid]);
            $commentsinfo = $stmt->fetchAll();
            // echo "<pre>";
            // print_r($commentsinfo);
            // echo "</pre>";
            if ($stmt->rowCount() > 0) {
            ?>
            <h2 class="text-center mb-5 mt-3 h4">Comments</h2>
              <div class="table-responsive table-responsive-sm table-responsive-md table-striped table-hover">
                <table class="table table-bordered">
                  <tr>
                    <td>#ID</td>
                    <td>Comment</td>
                    <td>Date</td>
                    <td>User</td>
                    <td>Controls</td>
                  </tr>
  <?php
                  foreach ($commentsinfo as $comment){
                    echo "<tr>";
                    echo "<td>" . $comment[0] . "</td>";
                    echo "<td>" . $comment[1] . "</td>";
                    echo "<td>" . $comment[2] . "</td>";
                    echo "<td>" . $comment[6] . "</td>";
                    echo "<td>
                      <a class='btn btn-success mt-1 ml-1' href='comments.php?act=edit&commentid=" . $comment[0] . "'><i class='fa fa-edit'></i></a>
                      <a class='confirm btn btn-danger m-1' href='comments.php?act=delete&commentid=" . $comment[0] . "'><i class='fa fa-trash'></i></a>";
                      if ($comment[3] == 0) {
                        echo "<a class='btn btn-info m-1 ml-0' href='comments.php?act=approve&commentid=" . $comment[0] . "'><i class='fa fa-check-square'></i></a>";
                      }
                    echo"</td>";
                    echo "</tr>";
                  } ?>
                </table>
              </div>
            </div>
<?php       }?>
          </div>
        </div>
<?php
      }else {
        gohome("<strong>There Is No Such An Item</strong>");
        exit();
      }
    }elseif ($act == 'add'){?>
      <h2 class='text-center mb-5 mt-3 l-capital'>Add new item</h2>
      <div class="container">
        <div class="row">
          <form class="form-group w-75 m-auto" action="items.php?act=insert" method="post">
            <div class="form-row mb-3">
              <label class='col col-form-label'>Item Name</label>
              <input type="text" name="itemname" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" required>
            </div>
            <div class="form-row mb-3">
              <label class='col col-form-label'>Description</label>
              <textarea type="text" name="description" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" required></textarea>
            </div>
            <div class="form-row mb-3">
              <label class='col col-form-label'>Price</label>
              <input type="text" name="price" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" required>
            </div>
            <div class="form-row mb-3">
              <label class='col col-form-label'>Made In</label>
              <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                <select class="form-control" name='country'>
                  <option>Select A Country</option>
                  <option value="AF">Afghanistan</option>
                	<option value="AX">Åland Islands</option>
                	<option value="AL">Albania</option>
                	<option value="DZ">Algeria</option>
                	<option value="AS">American Samoa</option>
                	<option value="AD">Andorra</option>
                	<option value="AO">Angola</option>
                	<option value="AI">Anguilla</option>
                	<option value="AQ">Antarctica</option>
                	<option value="AG">Antigua and Barbuda</option>
                	<option value="AR">Argentina</option>
                	<option value="AM">Armenia</option>
                	<option value="AW">Aruba</option>
                	<option value="AU">Australia</option>
                	<option value="AT">Austria</option>
                	<option value="AZ">Azerbaijan</option>
                	<option value="BS">Bahamas</option>
                	<option value="BH">Bahrain</option>
                	<option value="BD">Bangladesh</option>
                	<option value="BB">Barbados</option>
                	<option value="BY">Belarus</option>
                	<option value="BE">Belgium</option>
                	<option value="BZ">Belize</option>
                	<option value="BJ">Benin</option>
                	<option value="BM">Bermuda</option>
                	<option value="BT">Bhutan</option>
                	<option value="BO">Bolivia, Plurinational State of</option>
                	<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                	<option value="BA">Bosnia and Herzegovina</option>
                	<option value="BW">Botswana</option>
                	<option value="BV">Bouvet Island</option>
                	<option value="BR">Brazil</option>
                	<option value="IO">British Indian Ocean Territory</option>
                	<option value="BN">Brunei Darussalam</option>
                	<option value="BG">Bulgaria</option>
                	<option value="BF">Burkina Faso</option>
                	<option value="BI">Burundi</option>
                	<option value="KH">Cambodia</option>
                	<option value="CM">Cameroon</option>
                	<option value="CA">Canada</option>
                	<option value="CV">Cape Verde</option>
                	<option value="KY">Cayman Islands</option>
                	<option value="CF">Central African Republic</option>
                	<option value="TD">Chad</option>
                	<option value="CL">Chile</option>
                	<option value="CN">China</option>
                	<option value="CX">Christmas Island</option>
                	<option value="CC">Cocos (Keeling) Islands</option>
                	<option value="CO">Colombia</option>
                	<option value="KM">Comoros</option>
                	<option value="CG">Congo</option>
                	<option value="CD">Congo, the Democratic Republic of the</option>
                	<option value="CK">Cook Islands</option>
                	<option value="CR">Costa Rica</option>
                	<option value="CI">Côte d'Ivoire</option>
                	<option value="HR">Croatia</option>
                	<option value="CU">Cuba</option>
                	<option value="CW">Curaçao</option>
                	<option value="CY">Cyprus</option>
                	<option value="CZ">Czech Republic</option>
                	<option value="DK">Denmark</option>
                	<option value="DJ">Djibouti</option>
                	<option value="DM">Dominica</option>
                	<option value="DO">Dominican Republic</option>
                	<option value="EC">Ecuador</option>
                	<option value="EG">Egypt</option>
                	<option value="SV">El Salvador</option>
                	<option value="GQ">Equatorial Guinea</option>
                	<option value="ER">Eritrea</option>
                	<option value="EE">Estonia</option>
                	<option value="ET">Ethiopia</option>
                	<option value="FK">Falkland Islands (Malvinas)</option>
                	<option value="FO">Faroe Islands</option>
                	<option value="FJ">Fiji</option>
                	<option value="FI">Finland</option>
                	<option value="FR">France</option>
                	<option value="GF">French Guiana</option>
                	<option value="PF">French Polynesia</option>
                	<option value="TF">French Southern Territories</option>
                	<option value="GA">Gabon</option>
                	<option value="GM">Gambia</option>
                	<option value="GE">Georgia</option>
                	<option value="DE">Germany</option>
                	<option value="GH">Ghana</option>
                	<option value="GI">Gibraltar</option>
                	<option value="GR">Greece</option>
                	<option value="GL">Greenland</option>
                	<option value="GD">Grenada</option>
                	<option value="GP">Guadeloupe</option>
                	<option value="GU">Guam</option>
                	<option value="GT">Guatemala</option>
                	<option value="GG">Guernsey</option>
                	<option value="GN">Guinea</option>
                	<option value="GW">Guinea-Bissau</option>
                	<option value="GY">Guyana</option>
                	<option value="HT">Haiti</option>
                	<option value="HM">Heard Island and McDonald Islands</option>
                	<option value="VA">Holy See (Vatican City State)</option>
                	<option value="HN">Honduras</option>
                	<option value="HK">Hong Kong</option>
                	<option value="HU">Hungary</option>
                	<option value="IS">Iceland</option>
                	<option value="IN">India</option>
                	<option value="ID">Indonesia</option>
                	<option value="IR">Iran, Islamic Republic of</option>
                	<option value="IQ">Iraq</option>
                	<option value="IE">Ireland</option>
                	<option value="IM">Isle of Man</option>
                	<option value="IL">Israel</option>
                	<option value="IT">Italy</option>
                	<option value="JM">Jamaica</option>
                	<option value="JP">Japan</option>
                	<option value="JE">Jersey</option>
                	<option value="JO">Jordan</option>
                	<option value="KZ">Kazakhstan</option>
                	<option value="KE">Kenya</option>
                	<option value="KI">Kiribati</option>
                	<option value="KP">Korea, Democratic People's Republic of</option>
                	<option value="KR">Korea, Republic of</option>
                	<option value="KW">Kuwait</option>
                	<option value="KG">Kyrgyzstan</option>
                	<option value="LA">Lao People's Democratic Republic</option>
                	<option value="LV">Latvia</option>
                	<option value="LB">Lebanon</option>
                	<option value="LS">Lesotho</option>
                	<option value="LR">Liberia</option>
                	<option value="LY">Libya</option>
                	<option value="LI">Liechtenstein</option>
                	<option value="LT">Lithuania</option>
                	<option value="LU">Luxembourg</option>
                	<option value="MO">Macao</option>
                	<option value="MK">Macedonia, the former Yugoslav Republic of</option>
                	<option value="MG">Madagascar</option>
                	<option value="MW">Malawi</option>
                	<option value="MY">Malaysia</option>
                	<option value="MV">Maldives</option>
                	<option value="ML">Mali</option>
                	<option value="MT">Malta</option>
                	<option value="MH">Marshall Islands</option>
                	<option value="MQ">Martinique</option>
                	<option value="MR">Mauritania</option>
                	<option value="MU">Mauritius</option>
                	<option value="YT">Mayotte</option>
                	<option value="MX">Mexico</option>
                	<option value="FM">Micronesia, Federated States of</option>
                	<option value="MD">Moldova, Republic of</option>
                	<option value="MC">Monaco</option>
                	<option value="MN">Mongolia</option>
                	<option value="ME">Montenegro</option>
                	<option value="MS">Montserrat</option>
                	<option value="MA">Morocco</option>
                	<option value="MZ">Mozambique</option>
                	<option value="MM">Myanmar</option>
                	<option value="NA">Namibia</option>
                	<option value="NR">Nauru</option>
                	<option value="NP">Nepal</option>
                	<option value="NL">Netherlands</option>
                	<option value="NC">New Caledonia</option>
                	<option value="NZ">New Zealand</option>
                	<option value="NI">Nicaragua</option>
                	<option value="NE">Niger</option>
                	<option value="NG">Nigeria</option>
                	<option value="NU">Niue</option>
                	<option value="NF">Norfolk Island</option>
                	<option value="MP">Northern Mariana Islands</option>
                	<option value="NO">Norway</option>
                	<option value="OM">Oman</option>
                	<option value="PK">Pakistan</option>
                	<option value="PW">Palau</option>
                	<option value="PS">Palestinian Territory, Occupied</option>
                	<option value="PA">Panama</option>
                	<option value="PG">Papua New Guinea</option>
                	<option value="PY">Paraguay</option>
                	<option value="PE">Peru</option>
                	<option value="PH">Philippines</option>
                	<option value="PN">Pitcairn</option>
                	<option value="PL">Poland</option>
                	<option value="PT">Portugal</option>
                	<option value="PR">Puerto Rico</option>
                	<option value="QA">Qatar</option>
                	<option value="RE">Réunion</option>
                	<option value="RO">Romania</option>
                	<option value="RU">Russian Federation</option>
                	<option value="RW">Rwanda</option>
                	<option value="BL">Saint Barthélemy</option>
                	<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                	<option value="KN">Saint Kitts and Nevis</option>
                	<option value="LC">Saint Lucia</option>
                	<option value="MF">Saint Martin (French part)</option>
                	<option value="PM">Saint Pierre and Miquelon</option>
                	<option value="VC">Saint Vincent and the Grenadines</option>
                	<option value="WS">Samoa</option>
                	<option value="SM">San Marino</option>
                	<option value="ST">Sao Tome and Principe</option>
                	<option value="SA">Saudi Arabia</option>
                	<option value="SN">Senegal</option>
                	<option value="RS">Serbia</option>
                	<option value="SC">Seychelles</option>
                	<option value="SL">Sierra Leone</option>
                	<option value="SG">Singapore</option>
                	<option value="SX">Sint Maarten (Dutch part)</option>
                	<option value="SK">Slovakia</option>
                	<option value="SI">Slovenia</option>
                	<option value="SB">Solomon Islands</option>
                	<option value="SO">Somalia</option>
                	<option value="ZA">South Africa</option>
                	<option value="GS">South Georgia and the South Sandwich Islands</option>
                	<option value="SS">South Sudan</option>
                	<option value="ES">Spain</option>
                	<option value="LK">Sri Lanka</option>
                	<option value="SD">Sudan</option>
                	<option value="SR">Suriname</option>
                	<option value="SJ">Svalbard and Jan Mayen</option>
                	<option value="SZ">Swaziland</option>
                	<option value="SE">Sweden</option>
                	<option value="CH">Switzerland</option>
                	<option value="SY">Syrian Arab Republic</option>
                	<option value="TW">Taiwan, Province of China</option>
                	<option value="TJ">Tajikistan</option>
                	<option value="TZ">Tanzania, United Republic of</option>
                	<option value="TH">Thailand</option>
                	<option value="TL">Timor-Leste</option>
                	<option value="TG">Togo</option>
                	<option value="TK">Tokelau</option>
                	<option value="TO">Tonga</option>
                	<option value="TT">Trinidad and Tobago</option>
                	<option value="TN">Tunisia</option>
                	<option value="TR">Turkey</option>
                	<option value="TM">Turkmenistan</option>
                	<option value="TC">Turks and Caicos Islands</option>
                	<option value="TV">Tuvalu</option>
                	<option value="UG">Uganda</option>
                	<option value="UA">Ukraine</option>
                	<option value="AE">United Arab Emirates</option>
                	<option value="GB">United Kingdom</option>
                	<option value="US">United States</option>
                	<option value="UM">United States Minor Outlying Islands</option>
                	<option value="UY">Uruguay</option>
                	<option value="UZ">Uzbekistan</option>
                	<option value="VU">Vanuatu</option>
                	<option value="VE">Venezuela, Bolivarian Republic of</option>
                	<option value="VN">Viet Nam</option>
                	<option value="VG">Virgin Islands, British</option>
                	<option value="VI">Virgin Islands, U.S.</option>
                	<option value="WF">Wallis and Futuna</option>
                	<option value="EH">Western Sahara</option>
                	<option value="YE">Yemen</option>
                	<option value="ZM">Zambia</option>
                	<option value="ZW">Zimbabwe</option>
                </select>
              </div>
            </div>
            <div class="form-row mb-3">
              <label class='col col-form-label'>Status</label>
              <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                <select class="form-control" name='status'>
                  <option>Status</option>
                  <option value="new">Band-New</option>
                  <option value="like-new">Like-New</option>
                  <option value="used">Used</option>
                  <option value="old">Very Old</option>
                </select>
              </div>
            </div>
            <div class="form-row mb-3">
              <label class='col col-form-label'>Members</label>
              <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                <select class="form-control" name='members'>
                  <option value="0">...</option>
<?php
                  $stmt = $con->prepare("SELECT userid, username FROM users");
                  $stmt->execute();
                  $membersinfo = $stmt->fetchAll();
                  foreach ($membersinfo as $member){
                    echo "<option value='" . $member[0] . "'>" . $member[1] . "</option>";
                  }?>
                </select>
              </div>
            </div>
            <div class="form-row mb-3">
              <label class='col col-form-label'>Categories</label>
              <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                <select class="form-control" name='categories'>
                  <option value="0">...</option>
<?php
                  $stmt = $con->prepare("SELECT cid, cname FROM categories");
                  $stmt->execute();
                  $catesinfo = $stmt->fetchAll();
                  foreach ($catesinfo as $cate){
                    echo "<option value='" . $cate[0] . "'>" . $cate[1] . "</option>";
                  }?>
                </select>
              </div>
            </div>
            <!-- <div class="form-row mb-3">
              <label class='col col-form-label'>Rating</label>
              <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                <select class="form-control" name="rating">
                  <option value="1">*</option>
                  <option value="2">**</option>
                  <option value="3">***</option>
                  <option value="4">****</option>
                  <option value="5">*****</option>
                </select>
              </div>
            </div> -->
            <input type="submit" Value="Add Item" class="btn btn-primary float-sm-none float-md-right mt-2 col-md-3 col-12 col-sm-12">
          </form>
        </div>
      </div>
<?php
    }elseif ($act == 'update'){
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<h2 class='text-center mb-5 mt-3 l-capital'>New page Errors</h2>";

        $itemGetId        = $_POST['theid'];
        $item_name        = $_POST['itemname'];
        $description      = $_POST['description'];
        $price            = $_POST['price'];
        $status           = $_POST['status'];
        $category         = $_POST["categories"];
        $member_selected  = $_POST["members"];

        if (!empty($itemGetId)) {

          $checker = checkuser('itemid', 'items', $itemGetId);
          if ($checker == false) {
            $errors[] = "<div class='alert alert-danger l-capital'>There is no such an item</div>";
          }

        }else {
          $errors[] = "<div class='alert alert-danger l-capital'><strong>There is no id</strong></div>";
        }
        if (empty($item_name)) {
          $errors[] = "<div class='alert alert-danger l-capital'>The item name can't be <strong>empty</strong></div>";
        }
        if (empty($description)) {
          $errors[] = "<div class='alert alert-danger l-capital'>The description can't be <strong>empty</strong></div>";
        }
        if (empty($price)) {
          $errors[] = "<div class='alert alert-danger l-capital'>The price can't be <strong>empty</strong></div>";
        }
        if ($status == "Status") {
          $errors[] = "<div class='alert alert-danger l-capital'>the status can't be <strong>empty</strong></div>";
        }
        if ($category == 0) {
          $errors[] = "<div class='alert alert-danger l-capital'>The category field can't be <strong>empty</strong></div>";
        }
        if ($member_selected == 0){
          $errors[] = "<div class='alert alert-danger l-capital'>The Member field can't be <strong>empty</strong></div>";
        }
        if (empty($errors)) {
          $stmt = $con->prepare("UPDATE items SET itemname = :iname, description = :idesc, price = :iprice, status = :istatus, Cat_ID = :icid, Member_ID = :imid WHERE itemid = $itemGetId");
          $stmt->execute([
            "iname" => $item_name,
            "idesc" => $description,
            "iprice" => $price,
            "istatus" => $status,
            "icid" => $category,
            "imid" => $member_selected
          ]);
          header("location: ?act=edit&itemid=$itemGetId");
        }else {
          echo "<div class='container'>";
          foreach ($errors as $error) {
            echo $error;
          }
          echo "<a class='btn btn-success' href='?act=edit&itemid=$itemGetId'>Go Back</a>";
          echo "</div>";
        }
      }else {
        gohome("<strong>You Can't Brows This Page Directly</strong>");
      }
    }elseif ($act == 'insert'){
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<h2 class='text-center mb-5 mt-3 l-capital'>New page Errors</h2>";

        $item_name        = $_POST['itemname'];
        $description      = $_POST['description'];
        $price            = $_POST['price'];
        $made_country     = $_POST['country'];
        $status           = $_POST['status'];
        // $rate = $_POST['rating'];
        $category         = $_POST["categories"];
        $member_selected  = $_POST["members"];

        $errors = [];
        if (empty($item_name)){
          $errors[] = "<div class='alert alert-danger l-capital'>The item name can't be <strong>empty</strong></div>";
        }
        if (empty($description)){
          $errors[] = "<div class='alert alert-danger l-capital'>The description can't be <strong>empty</strong></div>";
        }
        if (empty($price)){
          $errors[] = "<div class='alert alert-danger l-capital'>The price can't be <strong>empty</strong></div>";
        }
        if ($made_country == 'Select A Country'){
          $errors[] = "<div class='alert alert-danger l-capital'>The made in country can't be <strong>empty</strong></div>";
        }
        if ($status == "Status"){
          $errors[] = "<div class='alert alert-danger l-capital'>The item status can't be <strong>empty</strong></div>";
        }
        if ($category == 0){
          $errors[] = "<div class='alert alert-danger l-capital'>The category field can't be <strong>empty</strong></div>";
        }
        if ($member_selected == 0){
          $errors[] = "<div class='alert alert-danger l-capital'>The Member field can't be <strong>empty</strong></div>";
        }
        if (empty($errors)){
          $stmt = $con->prepare("INSERT INTO items (itemName, description, price, uDate, madein, status, cat_id, member_id, approve) VALUES(:iname, :idesc, :iprice, now(), :imadein, :istatus, :catid, :memberid, 1)");
          $stmt->execute([
            "iname" => $item_name,
            "idesc" => $description,
            "iprice" => $price,
            "imadein" => $made_country,
            "istatus" => $status,
            "catid" => $category,
            "memberid" => $member_selected
          ]);
          header("location: ?act=add");
        }else {
          echo "<div class='container'>";
          foreach ($errors as $error) {
            echo $error;
          }
          echo "<a class='btn btn-success text-center' href='?act=add'>Go Back</a>";
          echo "</div>";
        }
      }else {
        gohome("<strong>You Can't Brows This Page Directly</strong>");
      }
    }elseif ($act == 'delete'){
      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? $_GET['itemid'] : 0;
      if (checkuser("itemid", 'items', $itemid) == true){
        $stmt = $con->prepare("DELETE FROM items WHERE itemid = ?");
        $stmt->execute([$itemid]);
        header("location: ?act=manage");
      }else {
        gohome("<strong>There is no such an item</strong>");
      }
    }elseif ($act == 'approve'){
      $itemid = isset($_GET['itemid']) ? intval($_GET['itemid']) : 0;
      if (checkuser('itemid', 'items', $itemid) == true) {
        $stmt = $con->prepare("UPDATE items SET approve = 1 WHERE itemid = :zid");
        $stmt->bindParam(':zid' ,$itemid);
        $stmt->execute();
        header("location: items.php?act=manage");
      }else {
        gohome("There Is No Sush an item");
      }
    }
    include 'includes/templates/footer.html';
  }else {
    header("location: index.php");
    exit();
  }
  ob_end_flush();
