# urlShorten
Easiest way to shorten your url in your own server by PHP and MySql
It is a simple link shortener service (such as Bitly). 
Non existing shortened url serves a 404 ( header("HTTP/1.0 404 Not Found"); )

### Tools require ###
You need a very small mysql table to keep the actual id, url and whether it is used or not for high security. So that after one used it will be disabled to again rerouting.

Used mccrypt libraries. You can find out more about it and how to use with PHP 5 http://aryo.lecture.ub.ac.id/easy-install-php-mcrypt-extension-on-ubuntu-linux/
and with PHP 7 https://www.digitalocean.com/community/questions/how-to-enable-mcrypt-for-php7

### How it works ###
First create the shorten url with createShortUrl() 
Then whenever call the shorten url with your hostname. It will come to server and by .htaccess come for process. 
First need to decrypt the id part. Then need to fetch the details row for actual url.
Redirect to actual url. If the actual url not found then show error.

## Easy, secure and FREE ##



