# Attachment-Downloader

A simple Symphone PHP command line project to load and store all founded eMail attachments from a special Goolge Gmail Account Folder.
All Attachment that found will be stored into a a local volume folder, orderd with new created YEAR, MONTH, DAY subfolders.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

You need to install the package composer 

```
apt install composer
```

### Installing


```
composer update
composer install
```

### configure youre own eMail credentials / settings

configure in -> /attachment-downloader/src/Autodownload/Mail/Command/DownloadAttachment.php

Youre eMail and Password!
```
$mailbox = new Mailbox('{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX', 'testxyz@gmail.com',
            'your_password',
```

Your Folder Example: ALL or an other INBOX name
```
$mailIds = $mailbox->searchMailbox('ALL');
```

Change to your right eMail for alert / information
```
$to = "alertmail@youre_domain.de";
	    	$subject = "Automatic alert eMail because the automated attachment downloader was failed!";
		$txt = "Automatic alert eMail because the automated attachment downloader was failed: $mail->fromAddress";
		$headers = "From: root@localsystem.local" . "\r\n"; // . "CC: in-CC-@your_domain.de";
		mail($to,$subject,$txt,$headers);
```



### until installation it's able to start with 

```
./mail download -o /mounted_volume
```

### example output on the command-shell / bash 
```
/opt/attachment-downloader/bin/mail download -o /mnt/export-archiv

  1/30 [>---------------------------]   3% 2 secs/1 mins
  2/30 [=>--------------------------]   6% 3 secs/45 secs
  3/30 [==>-------------------------]  10% 4 secs/40 secs
  4/30 [===>------------------------]  13% 6 secs/45 secs
  5/30 [====>-----------------------]  16% 7 secs/42 secs
  6/30 [=====>----------------------]  20% 8 secs/40 secs
  7/30 [======>---------------------]  23% 9 secs/39 secs
  8/30 [=======>--------------------]  26% 11 secs/41 secs
  9/30 [========>-------------------]  30% 12 secs/40 secs
 10/30 [=========>------------------]  33% 14 secs/42 secs
 11/30 [==========>-----------------]  36% 15 secs/41 secs
 12/30 [===========>----------------]  40% 16 secs/40 secs
 13/30 [============>---------------]  43% 17 secs/39 secs
 14/30 [=============>--------------]  46% 18 secs/39 secs
 15/30 [==============>-------------]  50% 20 secs/40 secs
 16/30 [==============>-------------]  53% 21 secs/39 secs
 17/30 [===============>------------]  56% 22 secs/39 secs
 18/30 [================>-----------]  60% 23 secs/38 secs
 19/30 [=================>----------]  63% 24 secs/38 secs
 20/30 [==================>---------]  66% 26 secs/39 secs
 21/30 [===================>--------]  70% 27 secs/39 secs
 22/30 [====================>-------]  73% 28 secs/38 secs
 23/30 [=====================>------]  76% 30 secs/39 secs
 24/30 [======================>-----]  80% 31 secs/39 secs
 25/30 [=======================>----]  83% 32 secs/38 secs
 26/30 [========================>---]  86% 33 secs/38 secs
 27/30 [=========================>--]  90% 34 secs/38 secs
 28/30 [==========================>-]  93% 38 secs/41 secs
 29/30 [===========================>]  96% 41 secs/42 secs
 30/30 [============================] 100% 42 secs/42 secs
```



## Built With

* [Symfony](https://github.com/symfony/symfony) - The web framework used
* [Composer](https://github.com/composer/composer) - Dependency Management

## Authors

* **Oliver Donzyk** 

## License

This project is licensed under the MIT License - see the [LICENSE](https://github.com/odonzyk/attachment-downloader/blob/master/LICENSE) file for details

