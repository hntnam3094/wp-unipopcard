echo "#####Git pull#####"

git pull


echo "#####Chmod folders and files#####"

find . -type d -exec chmod 0755 {} \;
find . -type f -exec chmod 0644 {} \;

echo "#####Chown folders and files#####"
chown -R devun3311:devun3311 *
cd .git
chown -R devun3311:devun3311 *


echo "#####Done#####"
