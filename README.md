XML Parser
========

This parser takes an xml file and parses the data while storing it
in a MySQL database

## Setup

* Open the `config.php` file in a text editor
* Set the variables for your MySQL host, username, password and database name

## Files

* The `fetch_xml.php` file takes a url and a filename as parameters. It downloads
the zip located at the specified url and extracts the file from it to /tmp.
* The `parse_xml.php` file takes a path to the xml file as a parameter and
parses/stores it in the database configured in `config.php`.
* The `run.php` is an entry script that calls `fetch_xml.php` and `parse_xml.php`
with the proper parameters.

## Usage

* Simply run `php run.php` to download/parse/store the latest xml.
* `fetch_xml.php` and `parse_xml.php` can also be used without the `run.php`
to get the xml from past dates.
