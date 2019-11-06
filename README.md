# Attachment-downloader

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
until installation it's able to start with 

```
./mail download -o /mounted_volume
```

## Built With

* [Symfony](https://github.com/symfony/symfony) - The web framework used
* [Composer](https://github.com/composer/composer) - Dependency Management

## Authors

* **Oliver Donzyk** 

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

