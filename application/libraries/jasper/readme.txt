php-sample
----------

This sample shows how to use the JasperReports Server Web Services to run a report 
from a PHP application.

Requirements
----------
To use the sample, you need will need:
 * A web server that supports PHP 5.3
 * SOAP pear package (http://pear.php.net/package/SOAP/)
 * Net_Dime pear package (http://pear.php.net/package/Net_DIME/)

See the php documentation for information about installing the pear packages. 
On Debian/Ubuntu installing the "php-soap" package is sufficient.

Configuration
----------
The sample assumes you are running JasperReports Server instance at:

  http://127.0.0.1:8080/jasperserver/services/repository
  
If you need to change this URL (for example, if you are running JasperReports Server 
Professional), you must change the variable $jasperserver_url in client.php. And 
the use the following URL:

  http://127.0.0.1:8080/jasperserver-pro/services/repository

The sample application shows how to navigate the JasperReports Server repository, 
displaying only folder and report units. The sample also has the ability to schedule a report.

On login, use a regular JasperServer account (such as jasperadmin/jasperadmin).

Click a ReportUnit to run it. If it contains input controls, they are displayed
before report execution.

Notes
----------
The sample application doesn't necesarily recognize all of the types of input control 
that JasperReports Server supports. This is not an exaustive list of things that 
JasperReports Server can do, just a sample.

Additional Notes on PHP Versions
--------------------------------

Due deprecation of older PHP 4/5 functionality, in order to run this PHP sample
you will need to have PHP version 5.3.0 or greater. 

2011-12-06

This PHP sample was tested with PHP version 5.3.8