IP2Location (PHP Module)
========================
[![Latest Stable Version](https://img.shields.io/packagist/v/ip2location/ip2location-php.svg)](https://packagist.org/packages/ip2location/ip2location-php)
[![Total Downloads](https://img.shields.io/packagist/dt/ip2location/ip2location-php.svg?style=flat-square)](https://packagist.org/packages/ip2location/ip2location-php)  

*This is the official release maintained by IP2Location.com*

This PHP module provides fast lookup of country, region, city, latitude, longitude, ZIP code, time zone, ISP, domain name, connection speed, IDD code, area code, weather station code, weather station name, MNC, MCC, mobile brand, elevation, and usage type from IP address by using IP2Location database. This module uses a file based database available at IP2Location.com. 

This module can be used in many types of projects such as:

1. select the geographically closest mirror
2. analyze your web server logs to determine the countries of your visitors
3. credit card fraud detection
4. software export controls
5. display native language and currency 
6. prevent password sharing and abuse of service 
7. geotargeting in advertisement

Free IP2Location LITE and commerical databases are available for download. 
* LITE database is available at https://lite.ip2location.com (Free with limited accuracy)
* Commercial database is availabe at https://www.ip2location.com (Comprehensive with high accuracy)

Monthly update is available for both IP2Location LITE and commercial database.

## KEY FEATURES

1. **Support both IPv4 and IPv6 with ease.** If you would like to enable IPv6 support, you just need to replace your BIN file with IPv6 version. That's it, and no code modification needed.
2. **Extensible.** If you require different granularity of IP information, you can visit [IP2Location.com](https://www.ip2location.com/databases) to download the relevant BIN file, and the information will made ready for you.
3. **Comprehensive Information.** There are more than 13 types of information that you can retrieve from an IP address. Please visit [IP2Location.com](https://www.ip2location.com/databases) for details.

## INSTALLATION

To install this module, unzip the package and copy the following files to your web folder.
* IP2Location.php
* example.php
* databases/IP2LOCATION-LITE-DB1.BIN

To test this installation, please browse example.php using web browser.

## USAGE

You can check the **example.php** file to learn more about usage.

### Database Class
Below is the description of the functions available in the **Database** class.

| Function Name | Description |
|---|---|
|Constructor|Expect 2 input parameters:<ol><li>Full path of IP2Location BIN data file.</li><li>File Open Mode<ul><li>	SHARED_MEMORY</li><li>MEMORY_CACHE</li><li>FILE_IO</li></ul></li></ol>For SHARED_MEMORY and MEMORY_CACHE, it will require your server to have sufficient memory to hold the BIN data, otherwise it will raise the errors during the object initialization.|
|getDate|Return the database's compilation date as a string of the form 'YYYY-MM-DD'|
|getType|Return the database's type, 1 to 24 respectively for DB1 to DB24. Please visit https://www.ip2location.com/databases for details.|
|getModuleVersion|Return the version of module|
|getDatabaseVersion|Return the version of database|
|lookup|Return the IP information in array. Below is the information returned:<ul><li>ipNumber</li><li>ipVersion</li><li>ipAddress</li><li>countryCode</li><li>countryName</li><li>regionName</li><li>cityName</li><li>latitude</li><li>longitude</li><li>areaCode</li><li>iddCode</li><li>weatherStationCode</li><li>weatherStationName</li><li>mcc</li><li>mnc</li><li>mobileCarrierName</li><li>usageType</li><li>elevation</li><li>netSpeed</li><li>timeZone</li><li>zipCode</li><li>domainName</li><li>isp</li></ul>You can visit [IP2Location](https://www.ip2location.com/databases/db24-ip-country-region-city-latitude-longitude-zipcode-timezone-isp-domain-netspeed-areacode-weather-mobile-elevation-usagetype) for the description of each field. Note: although the above names are not exactly matched with the names given in this link, but they are self-described.|
|getCidr|Return an array of the sub-network of an IP address.|


### WebService Class
Below is the description of the functions available in the **WebService** class.

| Function Name | Description                                                  |
| ------------- | ------------------------------------------------------------ |
| Constructor   | Expect 3 input parameters:<ol><li>IP2Location API Key.</li><li>Package (WS1 - WS24)</li><li>Use HTTPS or HTTP</li></ol> |
| lookup        | Return the IP information in array.<ul><li>country_code</li><li>country_name</li><li>region_name</li><li>city_name</li><li>latitude</li><li>longitude</li><li>zip_code</li><li>time_zone</li><li>isp</li><li>domain</li><li>net_speed</li><li>idd_code</li><li>area_code</li><li>weather_station_code</li><li>weather_station_name</li><li>mcc</li><li>mnc</li><li>mobile_brand</li><li>elevation</li><li>usage_type</li><li>continent<ul><li>name</li><li>code</li><li>hemisphere</li><li>translations</li></ul></li><li>country<ul><li>name</li><li>alpha3_code</li><li>numeric_code</li><li>demonym</li><li>flag</li><li>capital</li><li>total_area</li><li>population</li><li>currency<ul><li>code</li><li>name</li><li>symbol</li></ul></li><li>language<ul><li>code</li><li>name</li></ul></li><li>idd_code</li><li>tld</li><li>translations</li></ul></li><li>region<ul><li>name</li><li>code</li><li>translations</li></ul></li><li>city<ul><li>name</li><li>translations</li></ul></li><li>geotargeting<ul><li>metro</li></ul></li><li>country_groupings</li><li>time_zone_info<ul><li>olson</li><li>current_time</li><li>gmt_offset</li><li>is_dst</li></ul></li><ul> |
| getCredit     | Return remaining credit of the web service account.          |



## DEPENDENCIES

This library requires IP2Location BIN data file to function. You may download the BIN data file at
* IP2Location LITE BIN Data (Free): https://lite.ip2location.com
* IP2Location Commercial BIN Data (Comprehensive): https://www.ip2location.com

An outdated BIN database was provided in the databases folder for your testing. You are recommended to visit the above links to download the latest BIN database.

You can also sign up for [IP2Location Web Service](https://www.ip2location.com/web-service/ip2location) to lookup by IP2Location API.

## IPv4 BIN vs IPv6 BIN
* Use the IPv4 BIN file if you just need to query IPv4 addresses.
* Use the IPv6 BIN file if you need to query BOTH IPv4 and IPv6 addresses.

## OTHER FRAMEWORK LIBRARY
Below are the list of other framework library that you can install and use right away.
* [IP2Location Laravel](https://github.com/ip2location/ip2location-laravel)
* [IP2Location CakePHP](https://github.com/ip2location/ip2location-cakephp)
* [IP2Location CodeIgniter](https://github.com/ip2location/codeigniter-ip2location)

## COPYRIGHT AND LICENCE

Copyright (C) 2005-2020 by IP2Location.com

License under MIT
