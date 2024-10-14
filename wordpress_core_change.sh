#!/bin/bash

# Download the latest WordPress core files
wget https://wordpress.org/latest.zip -O latest.zip

# Unzip the downloaded file
unzip latest.zip

# Move new core files to the current directory, excluding wp-content
cd wordpress || { echo "Failed to enter wordpress directory"; exit 1; }

# Use rsync to move files excluding wp-content
rsync -av --exclude='wp-content' . ../

# Clean up by removing the downloaded zip and extracted folder
cd .. 
rm -rf latest.zip wordpress

echo "WordPress core files have been updated successfully, excluding wp-content."
