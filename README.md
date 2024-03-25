# Gunz WebEngine CMS

WebEngine is an Open source Content Management System (CMS) for Gunz Online servers. Our main goal is to provide a fast, secure and high quality framework for server owners to create and implement their own features to their websites.

## Getting Started

These instructions will help you deploy your own website using GunZ WebEngine CMS.

### Prerequisites

Here's what you'll need to run WebEngine CMS in your web server

* Apache mod_rewrite
* PHP 5.6 or higher (7.4 recommended)
* PHP PDO dblib/odbc/sqlsrv
* cURL Extension
* OpenSSL Extension
* short_open_tag enabled
* JSON

### Installing

1. GunZ WebEngine CMS is only suitable for installation on VPS or dedicated servers using Windows OS
2. Install Xampp [VerPHP7.4](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.33/xampp-windows-x64-7.4.33-0-VC15-installer.exe/download)
3. Copy 4 dlls files from `install` folder to xampp `xampp\php\ext`
4. Edit php.ini `short_open_tag=On` `extension=odbc` `extension=pdo_odbc` `extension=pdo_sqlsrv_74_nts_x64` `extension=pdo_sqlsrv_74_ts_x64` `extension=sqlsrv_74_nts_x64` `extension=sqlsrv_74_ts_x64`
5. Upload the ZIP file contents to your web server
6. Run WebEngine CMS Installer by going to `example.com/install` and follow the given instructions

## Other Software

GunZ WebEngine CMS wouldn't be possible without the following awesome projects.

* [PHPMailer](https://github.com/PHPMailer/PHPMailer/)
* [Bootstrap](https://getbootstrap.com/)
* [jQuery](http://jquery.com/)
* [reCAPTCHA](https://github.com/google/recaptcha)

## Author

* **Lautaro Angelico** - *Developer CMS*
* **Desperate** - *Data structure developer for GunZ*

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Support

### GunZ WebEngine CMS Priview Website
[GunZ WebEngine CMS Website](https://gunz.vn/)

### Discord Server
[Gunz VN Discord](https://discord.gg/JkxeQ4P78Q)
