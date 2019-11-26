## Unzip script 
This script can check the zip file encode charset, then unzip it by OS default charset. In order to solve the file name with strange character which transfer by different OS computer.

## Useage
* Check your php environment php-zip extention
* Down this script to your computer
* Just use php cli mode: `php unzip.php  zipFilesName.zip`

## Case
* If you want to unzip RAR by MacOS zip,  You can run `unzip -O UTF-8 packageName`, It's easier. 

### Inspiration
Thank [lanisle](https://gist.github.com/lanisle/2909160)
