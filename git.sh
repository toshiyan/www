#!/bin/sh

cwd=$(pwd)

autogit()
{
  cd ${1}
  echo "pull"
  git pull
  echo "add"
  git add *
  echo "commit"
  git commit -m "update"
  echo "push"
  git push
  cd ${cwd}
}

autogit Work/Lib/mylib/
autogit Work/Lib/mycamb/
autogit Work/Ongoing/
autogit Work/Published/
autogit Work/Sleep/

