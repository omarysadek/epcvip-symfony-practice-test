#!/bin/bash

cd /home/codebase/

composer install

cd

if [ ! -f "/home/codebase/.env.local" ]
then
	cp /home/devops/config/symfony/.env.local /home/codebase/.env.local
	echo ".env.local copied to symfony folder"
fi

if [ ! -d "/home/codebase/config/jwt" ]
then
	mkdir /home/codebase/config/jwt
	echo "create /home/codebase/config/jwt"
fi

if [ ! -f "/home/codebase/config/jwt/private.pem" ]
then
	cp /home/devops/config/jwt/private.pem /home/codebase/config/jwt/private.pem
	echo "private.pem copied to symfony folder"
fi

if [ ! -f "/home/codebase/config/jwt/public.pem" ]
then
	cp /home/devops/config/jwt/public.pem /home/codebase/config/jwt/public.pem
	echo "public.pem copied to symfony folder"
fi

if php /home/codebase/bin/console doctrine:database:create
then
	php /home/codebase/bin/console doctrine:schema:create
	php /home/codebase/bin/console doctrine:fixtures:load -q
	echo "creating schema and populate it with fixtures"
fi

exit 0