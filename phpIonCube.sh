#!/bin/bash
if [[ $(uname -m) == 'aarch64' ]]; then
  wget -P /tmp https://downloads.ioncube.com/loader_downloads/ioncube_loaders_lin_aarch64.zip
  echo "ARM64"
fi
if [[ $(uname -m) == 'arm64' ]]; then
  wget -P /tmp https://downloads.ioncube.com/loader_downloads/ioncube_loaders_lin_aarch64.zip
  echo "ARM64"
fi
if [[ $(uname -m) == 'x86_64' ]]; then
  wget -P /tmp https://downloads.ioncube.com/loader_downloads/ioncube_loaders_lin_x86-64.zip
  echo "x86_64"
fi
