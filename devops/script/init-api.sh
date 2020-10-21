#!/bin/bash

if [ ! -f "/home/codebase/.env.local" ]
then
	cp /home/devops/config/symfony/.env.local /home/codebase/.env.local
	echo ".env.local copied to symfony folder"
fi