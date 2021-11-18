echo "#####Git pull#####"

git pull

echo "#####Chmod folders and files#####"

find . -type d -exec chmod 0755 {} \;
find . -type f -exec chmod 0644 {} \;
