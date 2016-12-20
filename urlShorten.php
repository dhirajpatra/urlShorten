<?php
/*
This script will process url shorten and redirect to actual url
*/

define('TABLE', 'url_shorters');
define('SEC_KEY', 'sw2w5f2g');
define('HOST', 'https://test.com/');

/**
 * save the actual url
 * @return [[Type]] [[Description]]
 */
function createShortUrl()
{
    
    $con = mysqli_connect("localhost","root","mysqladmin","test");
    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }
    
    $sql = "insert into ".TABLE."(actual_url, used) values (mysql_real_escape_string(".$_POST['url']."), 0)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        $id = $mysqli->insert_id;
        
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
        $encrypted_id = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SEC_KEY, $id, MCRYPT_MODE_CBC, $iv);
        
        $shortenUrl = HOST . $encrypted_id;
        
        return $shortenUrl;
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}

/**
* Process short url
*
*/
$con=mysqli_connect("localhost","root","mysqladmin","test");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

if(!isset($_GET['url'])){
    exit;
}
$shortenUrl = $_GET['url'];
$encryptedId = basename($_GET['url']);

$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
$decryptedId = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SEC_KEY, $encryptedId, MCRYPT_MODE_CBC, $iv);

// Perform queries 
$query = "SELECT * FROM ".TABLE." where id = ".$decryptedId;

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        $url = $row['actual_url'];
    }

    /* free result set */
    $result->free();
}

mysqli_close($con);

if($url != null){
    header('Location: ' . $url);
}else{
    header('HTTP/1.0 404 Not Found');
    echo 'Url not found';
}

/*

--
-- Table structure for table `url_shorters`
--

CREATE TABLE `url_shorters` (
  `id` int(11) NOT NULL,
  `actual_url` varchar(256) DEFAULT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=big5;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `url_shorters`
--
ALTER TABLE `url_shorters`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `url_shorters`
--
ALTER TABLE `url_shorters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
*/

