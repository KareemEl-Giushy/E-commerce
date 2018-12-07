<?php
  ob_start();
  session_start();
  $pagetitle = 'Add New';
  if (!isset($_SESSION['noruser'])){
    header("location: index.php");
    exit();
  }
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php";

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $itemname     = filter_var($_POST['itemname'], FILTER_SANITIZE_STRING);
    $description  = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $price        = abs($_POST['price']);
    $country      = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $status       = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    $category     = filter_var($_POST['categories'], FILTER_SANITIZE_NUMBER_INT);

    // itemname validate
    if (empty($itemname)){
      $errors[] = "<div class='alert alert-danger l-capital'>The item name can't be <strong>empty</strong></div>";
    }

    // Description validate
    if (empty($description)){
      $errors[] = "<div class='alert alert-danger l-capital'>The description can't be <strong>empty</strong></div>";
    }

    // price validate
    if (empty($price)) {
      $price = 0 . "$";
    }
    if (!is_numeric($price) || is_float($price)) {
      $errors[] = "<div class='alert alert-danger l-capital'>The price is invalid <strong>(must be a number)</strong></div>";
    }

    // Country
    if (empty($country) || $country == 'Select A Country') {
      $errors[] = "<div class='alert alert-danger l-capital'>The country can't be <strong>empty</strong></div>";
    }

    // Status
    if (empty($status) || $status == 'Status') {
      $errors[] = "<div class='alert alert-danger l-capital'>The status can't be <strong>empty</strong></div>";
    }

    // categories
    if (empty($category) || $category == 0) {
      $errors[] = "<div class='alert alert-danger l-capital'>The Categories can't be <strong>empty</strong></div>";
    }

    // echo $itemname . '<br>';
    // echo $description . '<br>';
    // echo $price . '<br>';
    // echo $country . '<br>';
    // echo $status . '<br>';
    // echo $category . '<br>';

    // Add to the database
    if (empty($errors)){
      $price = strval($price) . '$';

      $stmt = $con->prepare("INSERT INTO items(itemname, description, price, udate, madein, status, cat_id, member_id) VALUES(:iname, :idesc, :iprice, now(), :icountry, :istatus, :catid, :memberid)");
      $stmt->execute([
        'iname' => $itemname,
        'idesc' => $description,
        'iprice' => $price,
        'icountry' => $country,
        'istatus' => $status,
        'catid' => $category,
        'memberid' => $_SESSION['norid']
      ]);
    }
  }
  ?>

  <h2 class='text-center mb-5 mt-4 l-capital'>Add new item</h2>
  <div class="container">
    <div class="row">
      <form class="form-group w-75 col-12 col-sm-12 col-md-7 col-lg-8" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-row mb-3">
          <label class='col col-form-label'>Item Name</label>
          <input type="text" name="itemname" class="form-control col-12" required>
        </div>
        <div class="form-row mb-3">
          <label class='col col-form-label'>Description</label>
          <textarea type="text" name="description" class="form-control col-12" required></textarea>
          <span class="negma">*</span>
        </div>
        <div class="form-row mb-3">
          <label class='col col-form-label'>Price</label>
          <input type="text" name="price" class="form-control col-12" required>
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
              } ?>
            </select>
          </div>
        </div>
        <input type="submit" Value="Add Item" class="btn btn-primary float-sm-none float-md-right mt-2 col-md-3 col-12 col-sm-12">
        <div class="errors" style="margin-top: 75px;">
<?php
          if (isset($errors) && !empty($errors)) {
            foreach ($errors as $error) {
              echo $error;
            }
          }
          if (empty($errors) && isset($errors)){
            echo "<div class='alert alert-success l-capital'>The item was added successfully</div>";
          } ?>
        </div>
      </form>
      <!-- Start the card -->
      <div class='col-12 col-sm-12 col-md-5 col-lg-4'>
        <div class='card'>
          <div class='card-header'>
          <h5 class='card-text text-center'></h5>
          </div>
          <img class='card-img-top img-fluid' src='data/uploads/default.png' alt=''/>
          <div class='card-body'>
            <h6 class='card-title item-title'></h6>
            <p class='card-text item-desc'></p>
            <div class='card-footer'>
              <a class='btn btn-secondary d-block' href='#'>View</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
  include "includes/templates/footer.html";
  ob_end_flush(); ?>
