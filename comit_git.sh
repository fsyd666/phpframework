echo "..................pull" 
git pull

git add .
git commit -m "commit to server"
echo "..................push"
git push

read -p "Press any key to exit..." gitout 